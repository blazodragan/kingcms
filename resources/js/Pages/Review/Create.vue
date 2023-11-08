<template>
   <AppLayout title="Reviews">
  <PageHeader sticky :title="'Create Review'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.review.create'"
    >Save
    </Button>

  </PageHeader>

  <Form :form="form" :submit="submit" :userOptions="userOptions" :categoriesOptions="categoriesOptions" :statusOptions="statusOptions" :iconOptions="iconOptions" :slugDisabled="slugDisabled" :templates="templates"/>

</AppLayout>
</template>

<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { ReviewForm } from "./types";
import { ref, Ref } from 'vue';

import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();

interface Props {
  userOptions: Array<{value: string|number, label: string}>;
  categoriesOptions: Array<{value: string|number, label: string}>;
  statusOptions: Array<{value: string|number, label: string}>;
  iconOptions: Array<{value: string|number, label: string}>;
  templates: Array<{value: string|number, label: string}>;
}

const props = defineProps<Props>();



const { form, submit } = useForm<ReviewForm>(
    {
title: { ...translatableDefaultValue }, 
slug: { ...translatableDefaultValue }, 
perex: { ...translatableDefaultValue }, 
content: { ...translatableDefaultValue }, 
text: { ...translatableDefaultValue }, 
why: { ...translatableDefaultValue }, 
active: false, 
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
rating: "", 
status: "",
template: "",
published_at: "", 
cover_review: [], 
og_cover_review: [], 
faqs: [{question: { ...translatableDefaultValue }, answer:{ ...translatableDefaultValue }}], 
tips: [{title: { ...translatableDefaultValue }, body:{ ...translatableDefaultValue }, icon:"", type:""}], 
categories_ids: []
    },
    route("reviews.store"),
    "post"
);

const slugDisabled = ref<boolean>(form.slug[currentLocale.value] ? true : false);
</script>
