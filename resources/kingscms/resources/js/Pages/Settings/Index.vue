<template>
    <AppLayout title="Settings">
  <PageHeader sticky :title="'Settings'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.settings.edit'"
    >Save
    </Button>
  </PageHeader>

  <PageContent>
    <template #tabs>
      <TabGroup variant="underline">
        <Tab >
          General
        </Tab>
        <Tab>
          SEO
        </Tab>
      </TabGroup>
    </template>

    <TabPanel>
      <div class="divide-y divide-slate-200 [&>*]:py-5 max-w-screen-lg mx-auto">
        <Multiselect
          v-model="form.available_locales"
          mode="tags"
          name="available_locales"
          :required="true"
          :label="'Available locales'"
          :options="availableLocales"
          :placeholder="'Type abbreviation and hit enter'"
          :createOption="true"
          labelPlacement="left"
          :leftIcon="MagnifyingGlassIcon"
        >
          <template #tag="{ option, handleTagRemove, disabled }">
            <Tag
              variant="outline"
              @dismiss="(event) => handleTagRemove(option, event)"
              :dissmisable="true"
            >
              <LocaleFlag :locale="option.label" />
            </Tag>
          </template>
          <template #option="{ option, search }">
            <LocaleFlag :locale="option.label" />
          </template>
        </Multiselect>
        <Multiselect
          v-model="form.default_locale"
          mode="single"
          name="default_locale"
          :label="'Default locale'"
          :options="form.available_locales"
          labelPlacement="left"
          inputClass="w-1/2"
        >
          <template #singlelabel="{ value }">
            <LocaleFlag :locale="value.label" />
          </template>
          <template #option="{ option, search }">
            <LocaleFlag :locale="option.label" />
          </template>
        </Multiselect>
        <Multiselect
          v-model="form.default_route"
          mode="single"
          name="default_route"
          :label="'Default route'"
          :options="availableRoutes"
          labelPlacement="left"
        />
        <TextInput
                v-model="form.default_googleAnalytics"
                name="default_googleAnalytics"
                labelPlacement="left"
                :label="'Google Analytics Code'"  
            />

            <TextArea
                v-model="form.default_customCss"
                name="default_customCss"
                labelPlacement="left"
                :label="'Custom Css Code'" 
                
            />
            <!-- <p v-if="isValid !== null">{{ isValid ? 'Valid CSS' : 'Invalid CSS' }}</p> -->

      </div>
    </TabPanel>
    <TabPanel>
      <div class="divide-y divide-slate-200 [&>*]:py-5 max-w-screen-lg mx-auto">
      <CardLocaleSwitcher v-model="currentLocale" ref="switcher" id="cardlocale"/>
      <TextInput
                v-model="form.default_siteTitle[currentLocale]"
                :name="`perex.${currentLocale}`"
 
                maxCharactersCount="70"
                minCharactersCount="50"
                :label="getLabelWithLocale('Default Title')"  
            />
            <TextArea
                v-model="form.default_siteDescription[currentLocale]"
                :name="`perex.${currentLocale}`"
 
                minCharactersCount="140"
                maxCharactersCount="160"
                :label="getLabelWithLocale('Default Description')"
            />

            

      </div>
    </TabPanel>


  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import {
  PageHeader,
  PageContent,
  Button,
  Multiselect,
  TextInput,
  TextArea,
  Tag,
  Tab,
  TabGroup,
  LocaleFlag,
  CardLocaleSwitcher,
} from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import { GeneralSettings } from "kingcms/Pages/Settings/types";
import { TabPanel } from "@headlessui/vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/solid";

import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();


interface Props {
  generalSettings: GeneralSettings;
  availableRoutes: string[];
}

const props = defineProps<Props>();

const availableLocales = props.generalSettings.available_locales;

const { form, submit } = useForm<GeneralSettings>(
  {
    available_locales: props.generalSettings.available_locales,
    default_locale: props.generalSettings.default_locale,
    default_route: props.generalSettings.default_route,
    default_siteTitle: props.generalSettings?.default_siteTitle ?? { ...translatableDefaultValue }, 
    default_siteDescription: props.generalSettings?.default_siteDescription ?? { ...translatableDefaultValue }, 
    default_googleAnalytics: props.generalSettings.default_googleAnalytics,
    default_customCss: props.generalSettings.default_customCss,
  },
  route("settings.update")
);


// // check if css is valid if it's empty dont do anything 
// const isValid = ref<boolean | null>(null);

// function cssomCheck(css: string): boolean {
//   const styleEl = document.createElement('style');
//   styleEl.textContent = css;

//   document.head.appendChild(styleEl);
//   const isValidCSS = !!styleEl.sheet?.cssRules.length; // If no rules, likely invalid
//   document.head.removeChild(styleEl);

//   return isValidCSS;
// }

// function checkCSSValidity() {
//   console.log(form.default_customCss)
//   if (cssomCheck(form.default_customCss)) {
//     isValid.value = true;
//   } else {
//     isValid.value = false;
//   }
// }

</script>
