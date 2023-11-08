<template>
  <AppLayout title="Post">
  <PageHeader sticky :title="'Create New Post'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.news.create'"
    >Save
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit" :userOptions="userOptions" :categoriesOptions="categoriesOptions" :statusOptions="statusOptions" :templates="templates"/>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { PostForm } from "./types";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  userOptions: Array<{value: string|number, label: string}>;
  categoriesOptions: Array<{value: string|number, label: string}>
  statusOptions: Array<{value: string|number, label: string}>;
  templates: Array<{value: string, label: string}>;
}

const props = defineProps<Props>();

const { form, submit } = useForm<PostForm>(
    {
title: { ...translatableDefaultValue }, 
slug: { ...translatableDefaultValue }, 
perex: { ...translatableDefaultValue }, 
content: { ...translatableDefaultValue }, 
meta_title: { ...translatableDefaultValue }, 
meta_description: { ...translatableDefaultValue }, 
meta_url_canolical: { ...translatableDefaultValue }, 
href_lang: { ...translatableDefaultValue }, 
no_index: false, 
no_follow: false, 
og_title: { ...translatableDefaultValue }, 
og_description: { ...translatableDefaultValue }, 
og_type: { ...translatableDefaultValue }, 
og_url: { ...translatableDefaultValue }, 
user_id: "", 
status: "", 
published_at: "",
template: "",
faqs: [{question: { ...translatableDefaultValue }, answer:{ ...translatableDefaultValue }}],  
cover: [], 
og_cover: [], 
categories_ids: []
    },
    route("post.store"),
    "post"
);
</script>
