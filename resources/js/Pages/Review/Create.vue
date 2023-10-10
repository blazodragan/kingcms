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

  <Form :form="form" :submit="submit" :userOptions="userOptions" :categoriesOptions="categoriesOptions" :statusOptions="statusOptions" />

</AppLayout>
</template>

<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { ReviewForm } from "./types";

import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();

interface Props {
  userOptions: Array<{value: string|number, label: string}>;
  categoriesOptions: Array<{value: string|number, label: string}>;
  statusOptions: Array<{value: string|number, label: string}>;
}

const props = defineProps<Props>();



const { form, submit } = useForm<ReviewForm>(
    {
title: { ...translatableDefaultValue }, 
slug: { ...translatableDefaultValue }, 
perex: { ...translatableDefaultValue }, 
content: { ...translatableDefaultValue }, 
text: { ...translatableDefaultValue }, 
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
status: "", 
published_at: "", 
cover_review: [], 
og_cover_review: [], 
faqs: [{question: { ...translatableDefaultValue }, answer:{ ...translatableDefaultValue }}], 
categories_ids: []
    },
    route("reviews.store"),
    "post"
);
</script>
