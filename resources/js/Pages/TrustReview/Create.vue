<template>
  <AppLayout title="Category">
  <PageHeader sticky :title=" 'Create Category'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.category.create'"
    >Save
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit"  />
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { CategoryForm } from "./types";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<CategoryForm>(
    {
title: { ...translatableDefaultValue }, 
description: { ...translatableDefaultValue }, 
rating: "",
    },
    route("trust_reviews.store"),
    "post"
);
</script>
