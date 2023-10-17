<template>
  <AppLayout title="Block">
  <PageHeader
    sticky
    :title="'Edit Block'"
    :subtitle="`Last updated at ${dayjs(
      block.updated_at
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

  <Form :form="form" :submit="submit"  :typeOptions="typeOptions"/>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { Block, BlockForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";


import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  block: Block;
  typeOptions: Array<{value: string|number, label: string}>;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<BlockForm>(
    {
name: props.block?.name ?? "", 
type: props.block?.type ?? "", 
content: props.block?.content ?? { ...translatableDefaultValue }, 
    },
    route("blocks.update", [props.block?.id])
);
</script>
