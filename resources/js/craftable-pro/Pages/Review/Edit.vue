<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit Review')"
    :subtitle="`Last updated at ${dayjs(
      review.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.review.edit'"
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
import type { Review, ReviewForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  review: Review;
  userOptions: Array<{value: string|number, label: string}>;
categoriesOptions: Array<{value: string|number, label: string}>
}

const props = defineProps<Props>();

const { form, submit } = useForm<ReviewForm>(
    {
          title: props.review?.title ?? { ...translatableDefaultValue }, 
slug: props.review?.slug ?? { ...translatableDefaultValue }, 
perex: props.review?.perex ?? { ...translatableDefaultValue }, 
content: props.review?.content ?? { ...translatableDefaultValue }, 
text: props.review?.text ?? { ...translatableDefaultValue }, 
active: props.review?.active ?? false, 
meta_title: props.review?.meta_title ?? { ...translatableDefaultValue }, 
meta_description: props.review?.meta_description ?? { ...translatableDefaultValue }, 
meta_url_canolical: props.review?.meta_url_canolical ?? { ...translatableDefaultValue }, 
href_lang: props.review?.href_lang ?? { ...translatableDefaultValue }, 
no_index: props.review?.no_index ?? false, 
no_follow: props.review?.no_follow ?? false, 
og_title: props.review?.og_title ?? { ...translatableDefaultValue }, 
og_description: props.review?.og_description ?? { ...translatableDefaultValue }, 
og_type: props.review?.og_type ?? { ...translatableDefaultValue }, 
og_url: props.review?.og_url ?? { ...translatableDefaultValue }, 
user_id: props.review?.user_id ?? "", 
published_at: props.review?.published_at ?? "", 
cover_review: getMediaCollection(props.review?.media, 'cover_review'), 
og_cover_review: getMediaCollection(props.review?.media, 'og_cover_review'), 
categories_ids: props.review?.categories.map(item => item.id) ?? []
    },
    route("craftable-pro.reviews.update", [props.review?.id])
);
</script>
