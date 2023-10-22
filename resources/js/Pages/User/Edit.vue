<template>
  <AppLayout title="Edit user">
  <PageHeader
    sticky
    :title="'Edit user'"
    :subtitle="`Last updated at ${dayjs(User.updated_at).format(
      'DD.MM.YYYY HH:mm'
    )}`"
  >
    <Button
      :leftIcon="ArrowDownTrayIcon"
      @click="submit"
      :loading="form.processing"
    >Save
    </Button>
  </PageHeader>

  <PageContent>
    <Form
      :locales="locales"
      :form="form"
      :User="User"
      :submit="submit"
      :roles="roles"
    />
  </PageContent>
</AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { PageHeader, PageContent, Button } from "kingcms/Components";
import { useForm } from "@inertiajs/vue3";
import Form from "./Form.vue";
import type { User } from "kingcms/types/models";
import dayjs from "dayjs";
import type { UploadedFile } from "../../types";
import type { Role } from "../../types/models";
import isNull from "lodash/isNull";
import omitBy from "lodash/omitBy";

interface Props {
  User: User;
  avatar: UploadedFile[];
  roles: Role[];
  locales: string[];
}

const props = defineProps<Props>();

const form = useForm({
  name: props.User.name ?? "",
  last_name: props.User.last_name ?? "",
  email: props.User.email ?? "",
  password: null,
  password_confirmation: null,
  locale: props.User.locale ?? "",
  active: props.User.active ?? false,
  role_id: props.User.roles
    ? props.User.roles?.[0]?.id
    : null,
  avatar: props.User.avatar ?? [],
});

const submit = () => {
  form
    .transform((data) => omitBy(data as object, isNull))
    .put(
      route("users.update", [
        props.User.id,
      ])
    );
};
</script>
