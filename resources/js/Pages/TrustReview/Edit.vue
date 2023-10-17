<template>
  <AppLayout title="Trust Review">
  <PageHeader
    sticky
    :title="'Edit Trust Review'"
    :subtitle="`Last updated at ${dayjs(
      trustReview.updated_at
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

  <Form :form="form" :submit="submit"  />
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { trustReview, trustReviewForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  trustReview: trustReview;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<trustReviewForm>(
    {

title: props.trustReview?.title ?? { ...translatableDefaultValue }, 
description: props.trustReview?.description ?? { ...translatableDefaultValue }, 
rating: props.trustReview?.rating ?? '',
    },
    route("trust_reviews.update", [props.trustReview?.id])
);
</script>
