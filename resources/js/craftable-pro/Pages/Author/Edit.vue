<template>
  <PageHeader
    sticky
    :title="$t('craftable-pro', 'Edit Author')"
    :subtitle="`Last updated at ${dayjs(
      author.updated_at
    ).format('DD.MM.YYYY')}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
      v-can="'craftable-pro.author.edit'"
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
import type { Author, AuthorForm } from "./types";
import dayjs from "dayjs";
import {getMediaCollection} from "craftable-pro/helpers";



interface Props {
  author: Author;
  
}

const props = defineProps<Props>();

const { form, submit } = useForm<AuthorForm>(
    {
          name: props.author?.name ?? "", 
email: props.author?.email ?? "", 
cover: getMediaCollection(props.author?.media, 'cover')
    },
    route("craftable-pro.authors.update", [props.author?.id])
);
</script>
