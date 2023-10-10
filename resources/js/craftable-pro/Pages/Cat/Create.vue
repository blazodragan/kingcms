<template>
  <PageHeader sticky :title="$t('craftable-pro', 'Create Cat')">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.cat.create'"
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
import type { CatForm } from "./types";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<CatForm>(
    {
          slug: { ...translatableDefaultValue }, 
title: { ...translatableDefaultValue }, 
description: { ...translatableDefaultValue }, 
active: false, 
cover: []
    },
    route("craftable-pro.cats.store"),
    "post"
);
</script>
