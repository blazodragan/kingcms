<template>
    <div class="grid items-start gap-6 xl:grid-cols-6">
      <div class="col-span-4">
    <ProfileCard :form="form" :locales="locales" />

  </div>
  
  <div class="col-span-2">
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
    <Card :title="'About The User'" class="mt-4">
      <div class="grid gap-6">
      <TextInput
        v-model="form.facebook"
        name="facebook"
        :label="'Facebook'"
        class="col-span-6 sm:col-span-3"
        :leftIcon="leftIcon"
      />
      <TextInput
        v-model="form.twitter"
        name="twitter"
        :label="'Twitter'"
        class="col-span-6 sm:col-span-3"
        :leftIcon="leftIcon"

      />
      <TextInput
        v-model="form.linkedin"
        name="linkedin"
        :label="'Linkedin'"
        class="col-span-6 sm:col-span-3"
        :leftIcon="leftIcon"
      />
    </div>
    </Card>
  </div>
  </div>
  
</template>

<script setup lang="ts">
import { Card, Multiselect, TextInput, Wysiwyg } from "kingcms/Components";
import { InertiaForm } from "@inertiajs/vue3";
import { CalendarDaysIcon, XMarkIcon, LinkIcon } from "@heroicons/vue/24/solid";
import type { UserForm } from "./types";
import { User } from "kingcms/types/models";
import ProfileCard from "./Components/ProfileCard.vue";
import PasswordCard from "./Components/PasswordCard.vue";
import type { Component } from "vue";

interface Props {
  form: InertiaForm<UserForm>;
  submit: void;
  User?: User;
  roles: any[];
  locales?: string[];
  leftIcon?: Component;
}

const props = withDefaults(defineProps<Props>(), {
  locales: () => ["en"],
  labelPlacement: "top",
  leftIcon:LinkIcon,
});
</script>
