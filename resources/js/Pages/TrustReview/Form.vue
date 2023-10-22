<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <CardLocaleSwitcher v-model="currentLocale" class="mb-6" />

      <Card>
        <div class="space-y-4">


            <TextInput
                v-model="form.title[currentLocale]"
                :name="`title.${currentLocale}`"
                :label="getLabelWithLocale('Title')"
                
            /> 
            <TextArea
                v-model="form.description[currentLocale]"
                :name="`description.${currentLocale}`"
                :label="getLabelWithLocale('Description')"
                
            /> 
            <TextInput
                v-model="form.rating"
                :name="`rating`"
                :label="'Rating'"
                :type="'number'"
            /> 
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
    CardLocaleSwitcher
} from "kingcms/Components";
import { InertiaForm } from "kingcms/types";
import type { trustReviewForm } from "./types";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  form: InertiaForm<trustReviewForm>;
  submit: void;
  
}

const props = defineProps<Props>();
</script>
