<template>
  <AppLayout title="News">
  <PageHeader sticky :title="'Create News'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.news.create'"
    >Save
    </Button>
  </PageHeader>
  <Form :form="form" :submit="submit" :userOptions="userOptions" :categoriesOptions="categoriesOptions" :tempaltesOptions="tempaltesOptions" :statusOptions="statusOptions" :iconOptions="iconOptions" :slugDisabled="slugDisabled"/>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { PagesForm } from "./types";
import { ref, Ref } from 'vue';


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  userOptions: Array<{value: string|number, label: string}>;
  statusOptions: Array<{value: string|number, label: string}>;
  tempaltesOptions: Array<{value: string|number, label: string}>;
  iconOptions: Array<{value: string|number, label: string}>;
}

const props = defineProps<Props>();

const { form, submit } = useForm<PagesForm>(
    {
title: { ...translatableDefaultValue }, 
slug: { ...translatableDefaultValue }, 
perex: { ...translatableDefaultValue }, 
content: { ...translatableDefaultValue }, 
template: "", 
meta_title: { ...translatableDefaultValue }, 
meta_description: { ...translatableDefaultValue }, 
meta_url_canolical: { ...translatableDefaultValue }, 
href_lang: { ...translatableDefaultValue }, 
is_index: false, 
no_index: false, 
no_follow: false, 
og_title: { ...translatableDefaultValue }, 
og_description: { ...translatableDefaultValue }, 
og_type: { ...translatableDefaultValue }, 
og_url: { ...translatableDefaultValue }, 
user_id: "", 
status: "", 
published_at: "", 
cover: [], 
og_cover: [], 
faqs: [{question: { ...translatableDefaultValue }, answer:{ ...translatableDefaultValue }}], 
tips: [{title: { ...translatableDefaultValue }, body:{ ...translatableDefaultValue }, icon:"", type:""}], 

    },
    route("pages.store"),
    "post"
);

const slugDisabled = ref<boolean>(form.slug[currentLocale.value] ? true : false);
</script>
