<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit News')"
    :subtitle="`Last updated at ${dayjs(
      news.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.news.edit'"
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
import type { News, NewsForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  news: News;
  userOptions: Array<{value: string|number, label: string}>;
categoriesOptions: Array<{value: string|number, label: string}>
}

const props = defineProps<Props>();

const { form, submit } = useForm<NewsForm>(
    {
          title: props.news?.title ?? { ...translatableDefaultValue }, 
slug: props.news?.slug ?? { ...translatableDefaultValue }, 
perex: props.news?.perex ?? { ...translatableDefaultValue }, 
content: props.news?.content ?? { ...translatableDefaultValue }, 
reference_link: props.news?.reference_link ?? "", 
meta_title: props.news?.meta_title ?? { ...translatableDefaultValue }, 
meta_description: props.news?.meta_description ?? { ...translatableDefaultValue }, 
meta_url_canolical: props.news?.meta_url_canolical ?? { ...translatableDefaultValue }, 
href_lang: props.news?.href_lang ?? { ...translatableDefaultValue }, 
no_index: props.news?.no_index ?? false, 
no_follow: props.news?.no_follow ?? false, 
og_title: props.news?.og_title ?? { ...translatableDefaultValue }, 
og_description: props.news?.og_description ?? { ...translatableDefaultValue }, 
og_type: props.news?.og_type ?? { ...translatableDefaultValue }, 
og_url: props.news?.og_url ?? { ...translatableDefaultValue }, 
user_id: props.news?.user_id ?? "", 
published_at: props.news?.published_at ?? "", 
cover: getMediaCollection(props.news?.media, 'cover'), 
og_cover: getMediaCollection(props.news?.media, 'og_cover'), 
categories_ids: props.news?.categories.map(item => item.id) ?? []
    },
    route("craftable-pro.news.update", [props.news?.id])
);
</script>
