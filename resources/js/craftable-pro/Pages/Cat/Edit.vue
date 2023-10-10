<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit Cat')"
    :subtitle="`Last updated at ${dayjs(
      cat.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.cat.edit'"
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
import type { Cat, CatForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  cat: Cat;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<CatForm>(
    {
          slug: props.cat?.slug ?? { ...translatableDefaultValue }, 
title: props.cat?.title ?? { ...translatableDefaultValue }, 
description: props.cat?.description ?? { ...translatableDefaultValue }, 
active: props.cat?.active ?? false, 
cover: getMediaCollection(props.cat?.media, 'cover')
    },
    route("craftable-pro.cats.update", [props.cat?.id])
);
</script>
