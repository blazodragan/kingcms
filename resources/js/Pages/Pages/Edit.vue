<template>
  <AppLayout title="Edit Page">
  <PageHeader
    sticky
    :title="'Edit Page'"
    :subtitle="`Last updated at ${dayjs(
      pages.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.news.edit'"
    >Save
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit" :userOptions="userOptions" :tempaltesOptions="tempaltesOptions" :statusOptions="statusOptions"/>
</AppLayout>
</template>

<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { Pages, PagesForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  pages: Pages;
  userOptions: Array<{value: string|number, label: string}>;
  statusOptions: Array<{value: string|number, label: string}>;
  tempaltesOptions: Array<{ value: string | number; label: string }>;
}

const props = defineProps<Props>();

const { form, submit } = useForm<PagesForm>(
    {
title: props.pages?.title ?? { ...translatableDefaultValue }, 
slug: props.pages?.slug ?? { ...translatableDefaultValue }, 
perex: props.pages?.perex ?? { ...translatableDefaultValue }, 
content: props.pages?.content ?? { ...translatableDefaultValue }, 
template: props.pages?.template ?? "", 
meta_title: props.pages?.meta_title ?? { ...translatableDefaultValue }, 
meta_description: props.pages?.meta_description ?? { ...translatableDefaultValue }, 
meta_url_canolical: props.pages?.meta_url_canolical ?? { ...translatableDefaultValue }, 
href_lang: props.pages?.href_lang ?? { ...translatableDefaultValue }, 
is_index: props.pages?.no_index ?? false, 
no_index: props.pages?.no_index ?? false, 
no_follow: props.pages?.no_follow ?? false, 
og_title: props.pages?.og_title ?? { ...translatableDefaultValue }, 
og_description: props.pages?.og_description ?? { ...translatableDefaultValue }, 
og_type: props.pages?.og_type ?? { ...translatableDefaultValue }, 
og_url: props.pages?.og_url ?? { ...translatableDefaultValue }, 
user_id: props.pages?.user_id ?? "", 
status: props.pages?.status ?? "", 
published_at: props.pages?.published_at ?? "", 
cover: getMediaCollection(props.pages?.media, 'cover'), 
og_cover: getMediaCollection(props.pages?.media, 'og_cover'), 
    },
    route("pages.update", [props.pages?.id])
);



</script>
