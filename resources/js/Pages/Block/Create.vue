<template>
  <AppLayout title="Block">
  <PageHeader sticky :title=" 'Create Block'">
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'sanctum.category.create'"
    >Save
    </Button>
  </PageHeader>

  <Form :form="form" :submit="submit" :typeOptions="typeOptions" />
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { BlockForm } from "./types";


import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  typeOptions: Array<{value: string|number, label: string}>;
}

const props = defineProps<Props>();

const { form, submit } = useForm<BlockForm>(
    {
    name: "", 
    type: "", 
    content: { ...translatableDefaultValue }, 
    },
    route("blocks.store"),
    "post"
);
</script>
