<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <CardLocaleSwitcher v-model="currentLocale" class="mb-6" />

      <Card>
        <div class="space-y-4">
            <TextInput
                v-model="form.title[currentLocale]"
                :name="`title.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Title'))"
                
            /> 

            <TextInput
                v-model="form.slug[currentLocale]"
                :name="`slug.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Slug'))"
                
            /> 

            <TextInput
                v-model="form.perex[currentLocale]"
                :name="`perex.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Perex'))"
                
            /> 

            <Wysiwyg
                v-model="form.content[currentLocale]"
                :name="`content.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Content'))"
            /> 

            <Wysiwyg
                v-model="form.text[currentLocale]"
                :name="`text.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Text'))"
            /> 

            <Checkbox
                v-model="form.active"
                name="active"
                :label="$t('craftable-pro', 'Active')"
            /> 

            <TextInput
                v-model="form.meta_title[currentLocale]"
                :name="`meta_title.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Meta Title'))"
                
            /> 

            <TextInput
                v-model="form.meta_description[currentLocale]"
                :name="`meta_description.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Meta Description'))"
                
            /> 

            <TextInput
                v-model="form.meta_url_canolical[currentLocale]"
                :name="`meta_url_canolical.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Meta Url Canolical'))"
                
            /> 

            <TextInput
                v-model="form.href_lang[currentLocale]"
                :name="`href_lang.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Href Lang'))"
                
            /> 

            <Checkbox
                v-model="form.no_index"
                name="no_index"
                :label="$t('craftable-pro', 'No Index')"
            /> 

            <Checkbox
                v-model="form.no_follow"
                name="no_follow"
                :label="$t('craftable-pro', 'No Follow')"
            /> 

            <TextInput
                v-model="form.og_title[currentLocale]"
                :name="`og_title.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Og Title'))"
                
            /> 

            <TextInput
                v-model="form.og_description[currentLocale]"
                :name="`og_description.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Og Description'))"
                
            /> 

            <TextInput
                v-model="form.og_type[currentLocale]"
                :name="`og_type.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Og Type'))"
                
            /> 

            <TextInput
                v-model="form.og_url[currentLocale]"
                :name="`og_url.${currentLocale}`"
                :label="getLabelWithLocale($t('craftable-pro', 'Og Url'))"
                
            /> 

            <Multiselect
                v-model="form.user_id"
                name="user_id"
                :label="$t('craftable-pro', 'User')"
                :options="userOptions"
                mode="single"
            /> 

            <DatePicker
                v-model="form.published_at"
                name="published_at"
                mode="dateTime"
                :label="$t('craftable-pro', 'Published At')"
            /> 

            <Dropzone
                v-model="form.cover_review"
                name="cover_review"
                :maxFileSize="10485760"
                :label="$t('craftable-pro', 'Cover Review')"
            /> 

            <Dropzone
                v-model="form.og_cover_review"
                name="og_cover_review"
                :maxFileSize="10485760"
                :label="$t('craftable-pro', 'Og Cover Review')"
            /> 

            <Multiselect
                v-model="form.categories_ids"
                name="categories_ids"
                :label="$t('craftable-pro', 'Categories')"
                :options="categoriesOptions"
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
import type { ReviewForm } from "./types";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  form: InertiaForm<ReviewForm>;
  submit: void;
  userOptions: Array<{value: string|number, label: string}>;
categoriesOptions: Array<{value: string|number, label: string}>
}

const props = defineProps<Props>();
</script>
