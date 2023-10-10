<template>
  <PageHeader sticky :title="$t('craftable-pro', 'Create News')">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.news.create'"
    >
      {{ $t("craftable-pro", "Save") }}
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit" :userOptions="userOptions" :categoriesOptions="categoriesOptions" />
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { NewsForm } from "./types";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  userOptions: Array<{value: string|number, label: string}>;
categoriesOptions: Array<{value: string|number, label: string}>
}

const props = defineProps<Props>();

const { form, submit } = useForm<NewsForm>(
    {
          title: { ...translatableDefaultValue }, 
slug: { ...translatableDefaultValue }, 
perex: { ...translatableDefaultValue }, 
content: { ...translatableDefaultValue }, 
reference_link: "", 
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
published_at: "", 
cover: [], 
og_cover: [], 
categories_ids: []
    },
    route("craftable-pro.news.store"),
    "post"
);
</script>
