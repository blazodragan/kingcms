<template>
  <div class="mx-auto flex max-w-3xl flex-col gap-6 2xl:max-w-4xl">
    <ProfileCard :form="form" :locales="locales" />

    <PasswordCard
      :form="form"
      :title="'Role and password'"
    >
      <Multiselect
        v-model="form.role_id"
        name="role"
        :label="'Role'"
        mode="single"
        :options="roles"
        optionsValueProp="id"
        optionsLabel="name"
        class="col-span-6 sm:col-span-3"
      />
    </PasswordCard>
  </div>
</template>

<script setup lang="ts">
import { Card, Multiselect } from "craftable-pro/Components";
import { InertiaForm } from "@inertiajs/vue3";
import type { UserForm } from "./types";
import { User } from "craftable-pro/types/models";
import ProfileCard from "./Components/ProfileCard.vue";
import PasswordCard from "./Components/PasswordCard.vue";

interface Props {
  form: InertiaForm<UserForm>;
  submit: void;
  User?: User;
  roles: any[];
  locales?: string[];
}

const props = withDefaults(defineProps<Props>(), {
  locales: () => ["en"],
});
</script>
