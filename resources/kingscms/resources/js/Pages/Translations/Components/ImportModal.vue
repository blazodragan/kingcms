<template>
  <Modal :open="open" @toggle-open="toggleOpen" :external-open="true">
    <template #title>Import translations</template
    >
    <template #content>
      <ImportModalFirstStep
        v-if="currentStep === 1"
        :locales="locales"
        :processing="processing"
        @upload-file="uploadFile"
        @select-language="selectLanguage"
        @check-only-missing="checkOnlyMissing"
      />
      <ImportModalSecondStep
        v-if="currentStep === 2"
        :import-language="language"
        :locales="locales"
        :number-of-found-translations="numberOfFoundTranslations"
        :number-of-translations-to-review="numberOfTranslationsToReview"
        :processing="processing"
        :translations-to-import="translationsToImport"
      />
      <ImportModalThirdStep
        v-if="currentStep === 3"
        :locales="locales"
        :number-of-successfully-imported-translations="
          numberOfSuccessfullyImportedTranslations
        "
        :number-of-successfully-updated-translations="
          numberOfSuccessfullyUpdatedTranslations
        "
        :processing="processing"
      />
    </template>
    <template #buttons="{ setIsOpen }">
      <Button
        v-if="currentStep !== 3"
        :disabled="processing"
        @click.prevent="nextStep"
      >Next step
      </Button>
      <Button
        v-if="currentStep !== 3"
        variant="outline"
        color="gray"
        @click.prevent="
          () => {
            setIsOpen();
          }
        "
      >Cancel
      </Button>
      <Button
        v-if="currentStep === 3"
        @click.prevent="
          () => {
            setIsOpen();
            router.reload();
            currentStep = 1;
          }
        "
      >Finish import
      </Button>
    </template>
  </Modal>
</template>

<script lang="ts" setup>
import { Button, Modal } from "kingcms/Components";
import { onMounted, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import type { PageProps } from "kingcms/types/page";
import ImportModalFirstStep from "kingcms/Pages/Translations/Components/ImportModalFirstStep.vue";
import ImportModalThirdStep from "kingcms/Pages/Translations/Components/ImportModalThirdStep.vue";
import ImportModalSecondStep from "kingcms/Pages/Translations/Components/ImportModalSecondStep.vue";
import axios from "axios";
import { useToast } from "@brackets/vue-toastification";
import { router } from "@inertiajs/vue3";
import { trans } from "kingcms/plugins/laravel-vue-i18n";

interface Props {
  locales: string[];
  open: boolean;
}

const props = defineProps<Props>();

const processing = ref<boolean>(false);
const currentStep = ref<Number>(1);
const importedFile = ref(null);
const file = ref(null);
const language = ref<string>("");
const numberOfSuccessfullyImportedTranslations = ref<number | null>(null);
const numberOfSuccessfullyUpdatedTranslations = ref<number | null>(null);
const numberOfFoundTranslations = ref<number | null>(null);
const numberOfTranslationsToReview = ref<number>(0);
const translationsToImport = ref([]);
const onlyMissing = ref(false);

const uploadFile = (uploadedFile: any) => {
  file.value = uploadedFile;
  importedFile.value = uploadedFile;
};

const selectLanguage = (selectedLanguage: string) => {
  language.value = selectedLanguage;
};

const checkOnlyMissing = (checkOnlyMissing: boolean) => {
  onlyMissing.value = checkOnlyMissing;
};

const toast = useToast();

const emit = defineEmits(["toggleOpen"]);

const toggleOpen = () => {
  emit("toggleOpen");
};

const nextStep = () => {
  processing.value = true;

  if (currentStep.value === 1) {
    let url = route("translations.import");
    let formData = new FormData();

    formData.append("fileImport", file.value ?? "");
    formData.append("importLanguage", language.value);
    formData.append("onlyMissing", onlyMissing.value ? "1" : "0");

    axios
      .post(url, formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
      .then(
        (response) => {
          if (
            response.data.hasOwnProperty("numberOfImportedTranslations") &&
            response.data.hasOwnProperty("numberOfUpdatedTranslations")
          ) {
            currentStep.value = 3;
            numberOfSuccessfullyImportedTranslations.value =
              response.data.numberOfImportedTranslations;
            numberOfSuccessfullyUpdatedTranslations.value =
              response.data.numberOfUpdatedTranslations;
          } else {
            currentStep.value = 2;
            numberOfFoundTranslations.value = Object.keys(response.data).length;
            translationsToImport.value = response.data;

            for (let i = 0; i < translationsToImport.value.length; i++) {
              if (
                translationsToImport.value[i].hasOwnProperty("has_conflict")
              ) {
                if (translationsToImport.value[i].has_conflict) {
                  numberOfTranslationsToReview.value++;
                }
              }
            }
          }
        },
        (error) => {
          toast.error(error.response.data);
        }
      )
      .finally(() => {
        processing.value = false;
      });
  } else if (currentStep.value === 2) {
    for (let i = 0; i < translationsToImport.value.length; i++) {
      if (translationsToImport.value[i].hasOwnProperty("checkedCurrent")) {
        if (translationsToImport.value[i].checkedCurrent) {
          translationsToImport.value[i][language.value.toLowerCase()] =
            translationsToImport.value[i].current_value;
        }
      }
    }
    const adminPath = ref((usePage().props as PageProps).admin_path);
    let url = "/"+adminPath.value+"/translations/import/conflicts";
    let data = {
      importLanguage: language.value,
      resolvedTranslations: translationsToImport.value,
    };

    axios
      .post(url, data)
      .then(
        (response) => {
          currentStep.value = 3;
          numberOfSuccessfullyImportedTranslations.value =
            response.data.numberOfImportedTranslations;
          numberOfSuccessfullyUpdatedTranslations.value =
            response.data.numberOfUpdatedTranslations;
        },
        (error) => {
          toast.error("An error has occurred.");
        }
      )
      .finally(() => {
        processing.value = false;
      });
  }
};
</script>
