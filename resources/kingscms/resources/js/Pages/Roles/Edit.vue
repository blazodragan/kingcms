<template>
  <PageHeader
    sticky
    :title="`${$t('craftable-pro', 'Edit permissions for role')} ${role.name}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
    >
      {{ $t("craftable-pro", "Save") }}
    </Button>
  </PageHeader>

  <PageContent>
    <Form :form="form" :role="role" :submit="submit" />
  </PageContent>
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, PageContent, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { Role } from "kingcms/types/models";

interface Props {
  role: Role;
  permissionsTree: any;
}

const props = defineProps<Props>();

const { form, submit } = useForm<any>(
  {
    permissionsTree: props.permissionsTree,
  },
  route("craftable-pro.roles.update", [props.role.id])
);
</script>
