<template>
  <AppLayout title="Edit Post">
  <PageHeader
    sticky
    :title="'Edit Post'"
    :subtitle="`Last updated at ${dayjs(post.updated_at).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.news.edit'"
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
import type { Post, PostForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "kingcms/helpers";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  post: Post;
  userOptions: Array<{value: string|number, label: string}>;
  categoriesOptions: Array<{value: string|number, label: string}>
  statusOptions: Array<{value: string|number, label: string}>;
  templates: Array<{value: string, label: string}>;
}

const props = defineProps<Props>();

const { form, submit } = useForm<PostForm>(
    {
title: props.post?.title ?? { ...translatableDefaultValue }, 
slug: props.post?.slug ?? { ...translatableDefaultValue }, 
perex: props.post?.perex ?? { ...translatableDefaultValue }, 
content: props.post?.content ?? { ...translatableDefaultValue }, 
meta_title: props.post?.meta_title ?? { ...translatableDefaultValue }, 
meta_description: props.post?.meta_description ?? { ...translatableDefaultValue }, 
meta_url_canolical: props.post?.meta_url_canolical ?? { ...translatableDefaultValue }, 
href_lang: props.post?.href_lang ?? { ...translatableDefaultValue }, 
no_index: props.post?.no_index ?? false, 
no_follow: props.post?.no_follow ?? false, 
og_title: props.post?.og_title ?? { ...translatableDefaultValue }, 
og_description: props.post?.og_description ?? { ...translatableDefaultValue }, 
og_type: props.post?.og_type ?? { ...translatableDefaultValue }, 
og_url: props.post?.og_url ?? { ...translatableDefaultValue }, 
user_id: props.post?.user_id ?? "", 
status: props.post?.status ?? "", 
published_at: props.post?.published_at ?? "", 
template: props.post?.template ?? "", 
cover: getMediaCollection(props.post?.media, 'cover'), 
og_cover: getMediaCollection(props.post?.media, 'og_cover'), 
faqs: props.post?.faqs.map(faq => ({...faq,question: faq.question,answer: faq.answer})) ?? [],
categories_ids: props.post?.categories.map(item => item.id) ?? []
    },
    route("post.update", [props.post?.id])
);
</script>
