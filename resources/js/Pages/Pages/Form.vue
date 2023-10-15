<template>
  <PageContent>
    <div class="grid items-start gap-6 xl:grid-cols-6">
    <div class="col-span-4">
        <CardLocaleSwitcher v-model="currentLocale" ref="switcher" id="cardlocale"/>
        <Card class="mb-6 ">
        <div class="space-y-4">
            <TextInput
                v-model="form.title[currentLocale]"
                :name="`title.${currentLocale}`"
                :label="getLabelWithLocale('Title')"
                
            /> 



            <TextInput
                v-model="form.slug[currentLocale]"
                :name="`slug.${currentLocale}`"
                :label="getLabelWithLocale('Slug')"
                @input="handleSlugInput"
                
            /> 

            <Dropzone
                v-model="form.cover"
                name="cover"
                :maxFileSize="10485760"
                :label="'Cover'"
            /> 

            <TextInput
                v-model="form.perex[currentLocale]"
                :name="`perex.${currentLocale}`"
                :label="getLabelWithLocale('Perex')"
                
            /> 

            <Wysiwyg
                v-model="form.content[currentLocale]"
                :name="`content.${currentLocale}`"
                :label="getLabelWithLocale('Content')"
            /> 


          

        

        </div>
      </Card>
      <div class="grid items-start gap-6 xl:grid-cols-2">
        <div class="col-span-1">

    </div>
          <div class="col-span-1">

    </div>
    
</div>
    </div>

    <div class="col-span-2">     
      <Card class="mb-4">
        <div class="space-y-4">
            <RadioGroupLink
            v-model="form.status"
              name="status"
              :label="'Status'"
              :options="statusOptions"
              mode="single"
            />
            <RadioGroupLink
            v-model="form.templates"
              name="template"
              :label="'Template'"
              :options="tempaltesOptions"
              mode="single"
            />
            <DatePicker
                v-model="form.published_at"
                name="published_at"
                mode="dateTime"
                :label="'Published At'"
            /> 
            <Multiselect
                v-model="form.user_id"
                name="user_id"
                :label="'User'"
                :options="userOptions"
                mode="single"
            /> 
            <Checkbox
                v-model="form.is_index"
                name="is_index"
                :label="'Is Index'"
            /> 
        
        </div>
      </Card>
      <Card class="mb-4">
        <div class="space-y-4">
        <TextInput
                v-model="form.meta_title[currentLocale]"
                :name="`meta_title.${currentLocale}`"
                :label="getLabelWithLocale('Meta Title')"
                
            /> 

            <TextInput
                v-model="form.meta_description[currentLocale]"
                :name="`meta_description.${currentLocale}`"
                :label="getLabelWithLocale('Meta Description')"
                
            /> 

            <TextInput
                v-model="form.meta_url_canolical[currentLocale]"
                :name="`meta_url_canolical.${currentLocale}`"
                :label="getLabelWithLocale('Meta Url Canolical')"
                
            /> 

            <TextInput
                v-model="form.href_lang[currentLocale]"
                :name="`href_lang.${currentLocale}`"
                :label="getLabelWithLocale('Href Lang')"
                
            /> 

            <Checkbox
                v-model="form.no_index"
                name="no_index"
                :label="'No Index'"
            /> 

            <Checkbox
                v-model="form.no_follow"
                name="no_follow"
                :label="'No Follow'"
            /> 
        </div>
      </Card>
      <Card>
        <div class="space-y-4">
        <TextInput
                v-model="form.og_title[currentLocale]"
                :name="`og_title.${currentLocale}`"
                :label="getLabelWithLocale('Og Title')"
                
            /> 

            <TextInput
                v-model="form.og_description[currentLocale]"
                :name="`og_description.${currentLocale}`"
                :label="getLabelWithLocale('Og Description')"
                
            /> 

            <TextInput
                v-model="form.og_type[currentLocale]"
                :name="`og_type.${currentLocale}`"
                :label="getLabelWithLocale('Og Type')"
                
            /> 

            <TextInput
                v-model="form.og_url[currentLocale]"
                :name="`og_url.${currentLocale}`"
                :label="getLabelWithLocale('Og Url')"
                
            /> 




            <Dropzone
                v-model="form.og_cover"
                name="og_cover"
                :maxFileSize="10485760"
                :label="'Og Cover'"
            /> 
        </div>
      </Card>
    </div>
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
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { PagesForm } from "./types";
import { reactive, watch } from 'vue';


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  form: InertiaForm<PagesForm>;
  submit: void;
  userOptions: Array<{value: string|number, label: string}>;
  statusOptions: Array<{ value: string | number; label: string }>;
  tempaltesOptions: Array<{ value: string | number; label: string }>;
}

const props = defineProps<Props>();
console.log(props);

const slugify = (str?: string) => {
  if (typeof str === 'undefined' || str === null) {
    return '';
  }
  return str
    .toLowerCase()
    .replace(/[^\w \-]+/g, '') // Allow hyphens, word characters, and spaces
    .replace(/ +/g, '-')      // Replace spaces with hyphens
    .trim();                  // Trim leading/trailing spaces and hyphens
};

    watch(() => props.form.title[currentLocale.value], (newTitle) => {
        props.form.slug[currentLocale.value] = slugify(newTitle);
    });

    const handleSlugInput = () => {
        console.log(props.form.title[currentLocale.value]);
        props.form.slug[currentLocale.value] = slugify(props.form.slug[currentLocale.value]);
    };
</script>
