<template>
  <AppLayout title="Create user">
  <PageHeader sticky :title="'Create user'">
    <div class="flex gap-3">
      <Button
        :leftIcon="ArrowDownTrayIcon"
        @click="submit"
        :loading="form.processing"
      >Save
      </Button>
    </div>
  </PageHeader>

  <PageContent>
    <Form :locales="locales" :form="form" :submit="submit" :roles="roles" />
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, PageContent, Button } from "craftable-pro/Components";
import { useForm } from "craftable-pro/hooks/useForm";
import Form from "./Form.vue";
import type { UserForm } from "./types";

interface Props {
  roles: any[];
  locales?: string[];
  defaultLocale: string;
}

const props = withDefaults(defineProps<Props>(), {
  locales: () => ["en"],
  defaultLocale: 'en'
});

const { form, submit } = useForm<UserForm>(
  {
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    locale: props.defaultLocale,
    active: true,
    role_id: null,
    avatar: [],
  },
  route("users.store"),
  "post"
);
</script>
