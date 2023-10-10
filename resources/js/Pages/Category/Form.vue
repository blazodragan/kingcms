<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <CardLocaleSwitcher v-model="currentLocale" class="mb-6" />

      <Card>
        <div class="space-y-4">
            <TextInput
                v-model="form.alias"
                name="alias"
                :label="'Alias'"
                
            /> 

            <TextInput
                v-model="form.slug[currentLocale]"
                :name="`slug.${currentLocale}`"
                :label="getLabelWithLocale('Slug')"
                
            /> 

            <TextInput
                v-model="form.title[currentLocale]"
                :name="`title.${currentLocale}`"
                :label="getLabelWithLocale('Title')"
                
            /> 

            <TextInput
                v-model="form.description[currentLocale]"
                :name="`description.${currentLocale}`"
                :label="getLabelWithLocale('Description')"
                
            /> 

            <Dropzone
                v-model="form.cover"
                name="cover"
                :maxFileSize="10485760"
                :label="'Cover'"
            /></div>
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
    CardLocaleSwitcher
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { CategoryForm } from "./types";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  form: InertiaForm<CategoryForm>;
  submit: void;
  
}

const props = defineProps<Props>();
</script>
