<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit Category')"
    :subtitle="`Last updated at ${dayjs(
      category.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.category.edit'"
    >
      {{ $t("craftable-pro", "Save") }}
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit"  />
</template>

<script setup lang="ts">
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
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<CategoryForm>(
    {
          alias: props.category?.alias ?? "", 
slug: props.category?.slug ?? { ...translatableDefaultValue }, 
title: props.category?.title ?? { ...translatableDefaultValue }, 
description: props.category?.description ?? { ...translatableDefaultValue }, 
cover: getMediaCollection(props.category?.media, 'cover')
    },
    route("craftable-pro.categories.update", [props.category?.id])
);
</script>
