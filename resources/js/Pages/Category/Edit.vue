<template>
  <AppLayout title="Category">
  <PageHeader
    sticky
    :title="'Edit Category'"
    :subtitle="`Last updated at ${dayjs(
      category.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.category.edit'"
    >Save
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit" :categoryTypes="categoryTypes" />
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { Category, CategoryForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  category: Category;
  categoryTypes: Array<{value: string|number, label: string}>;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<CategoryForm>(
    {
alias: props.category?.alias ?? "", 
title: props.category?.title ?? { ...translatableDefaultValue }, 
slug: props.category?.slug ?? { ...translatableDefaultValue }, 
description: props.category?.description ?? { ...translatableDefaultValue }, 
type: props.category?.type ?? "", 
cover: getMediaCollection(props.category?.media, 'cover')
    },
    route("categories.update", [props.category?.id])
);
</script>
