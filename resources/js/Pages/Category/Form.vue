<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <CardLocaleSwitcher v-model="currentLocale" class="mb-6" />

      <Card>
        <div class="space-y-4">
          <TextInput v-model="form.alias" name="alias" :label="'Alias'" />

          <TextInput v-model="form.title[currentLocale]" :name="`title.${currentLocale}`"
            :label="getLabelWithLocale('Title')" />
          <div class="col-span-1 flex items-start gap-2">
            <div class="flex gap-1 flex-col flex-1">
              <TextInput v-model="form.slug[currentLocale]" :name="`slug.${currentLocale}`"
                :label="getLabelWithLocale('Slug')" :disabled="slugDisabled" @input="handleSlugInput" />
            </div>


            <Modal type="danger">
              <template #trigger="{ setIsOpen }">
                <Button :leftIcon="slugDisabled ? EyeIcon : EyeSlashIcon"
                  @click="() => { slugDisabled ? setIsOpen(true) : toggleSlugInput() }" class="text-sm mt-6"
                  :loading="form.processing" v-can="'sanctum.category.create'">{{ slugDisabled ? 'Edit' : 'Disable' }}
                </Button>
              </template>

              <template #title>Edit Slug
              </template>
              <template #content>Are you sure you want to edit the slug. If you do you need to make a rule for redirecting
                to the new slug
              </template>

              <template #buttons="{ setIsOpen }">
                <Button @click="toggleSlugInput" @click.prevent="() => setIsOpen()" color="primary">Ok
                </Button>
                <Button @click.prevent="() => setIsOpen()" color="gray" variant="outline">Cancel
                </Button>
              </template>
            </Modal>


          </div>


          <TextInput v-model="form.description[currentLocale]" :name="`description.${currentLocale}`"
            :label="getLabelWithLocale('Description')" />
          <RadioGroupLink v-model="form.type" name="type" :label="'Type'" :options="categoryTypes" mode="single" />

          <Dropzone v-model="form.cover" name="cover" :maxFileSize="10485760" :maxNumberOfFiles="1" :label="'Cover'" />
        </div>
      </Card>
    </div>
  </PageContent>
</template>

<script setup lang="ts">
import {
  Card,
  TextInput,
  Wysiwyg,
  TextArea,
  PageContent,
  DatePicker,
  Checkbox,
  Dropzone,
  ImageUpload,
  Multiselect,
  CardLocaleSwitcher,
  RadioGroupLink,
  Button,
  IconButton,
  Modal
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { CategoryForm } from "./types";
import { slugify } from "craftable-pro/helpers/slugify";
import { ref, Ref } from 'vue';
import { watch } from 'vue';
import { EyeDropperIcon, EyeSlashIcon, EyeIcon } from "@heroicons/vue/24/outline";

import { useFormLocale } from "craftable-pro/hooks/useFormLocale";


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();



interface Props {
  form: InertiaForm<CategoryForm>;
  submit: void;
  categoryTypes: Array<{ value: string | number, label: string }>;
  slugDisabled: Ref<boolean>;

}

const props = defineProps<Props>();

const slugDisabled = ref<boolean>(props.form.slug[currentLocale.value] ? true : false);

const toggleSlugInput = () => {
  slugDisabled.value = !slugDisabled.value;
};

watch(() => props.form.title[currentLocale.value], (newTitle) => {
  if (!slugDisabled.value) {
    props.form.slug[currentLocale.value] = slugify(newTitle);
  }
});

watch(() => props.form.alias, (newAlias) => {
  props.form.title[currentLocale.value] = newAlias;
});

const handleSlugInput = () => {
  props.form.slug[currentLocale.value] = slugify(props.form.slug[currentLocale.value]);
};
</script>
