<template>
  <Card :title="title">
    <div class="grid gap-6">
      <slot></slot>
      <TextInput
        v-model="form.password"
        name="password"
        :label="'Password'"
        type="password"
        autocomplete="new-password"
        class="col-span-6 sm:col-span-3 sm:col-start-1"
      />
      <TextInput
        v-model="form.password_confirmation"
        name="password_confirmation"
        :label="'Password confirmation'"
        type="password"
        autocomplete="new-password"
        class="col-span-6 sm:col-span-3 sm:col-start-1"
      />
    </div>
  </Card>
</template>

<script setup lang="ts">
import { Card, TextInput } from "kingcms/Components";
import { InertiaForm } from "@inertiajs/vue3";
import type { UserPasswordForm } from "../types";
import { wTrans } from "kingcms/plugins/laravel-vue-i18n";

interface Props {
  form: InertiaForm<UserPasswordForm>;
  title?: string;
}

const props = withDefaults(defineProps<Props>(), {
  title: wTrans("", "Password").value,
});
</script>
