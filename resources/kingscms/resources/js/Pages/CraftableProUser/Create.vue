<template>
  <PageHeader sticky :title="$t('craftable-pro', 'Create user')">
    <div class="flex gap-3">
      <Button
        :leftIcon="ArrowDownTrayIcon"
        @click="submit"
        :loading="form.processing"
      >
        {{ $t("craftable-pro", "Save") }}
      </Button>
    </div>
  </PageHeader>

  <PageContent>
    <Form :locales="locales" :form="form" :submit="submit" :roles="roles" />
  </PageContent>
</template>

<script setup lang="ts">
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, PageContent, Button } from "kingcms/Components";
import { useForm } from "kingcms/hooks/useForm";
import Form from "./Form.vue";
import type { CraftableProUserForm } from "./types";

interface Props {
  roles: any[];
  locales?: string[];
  defaultLocale: string;
}

const props = withDefaults(defineProps<Props>(), {
  locales: () => ["en"],
  defaultLocale: 'en'
});

const { form, submit } = useForm<CraftableProUserForm>(
  {
    first_name: "",
    last_name: "",
    email: "",
    password: "",
    password_confirmation: "",
    locale: props.defaultLocale,
    active: true,
    role_id: null,
    avatar: [],
  },
  route("craftable-pro.craftable-pro-users.store"),
  "post"
);
</script>
