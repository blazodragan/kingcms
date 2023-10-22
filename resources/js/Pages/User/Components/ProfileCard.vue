<template>
  <Card :title="'Profile'">
    <div class="grid grid-cols-6 gap-6">
      <ImageUpload
        v-model="form.avatar"
        name="avatar"
        :label="'User photo'"
        class="col-span-6"
      />
      <TextInput
        v-model="form.name"
        name="name"
        :label="'Name'"
        class="col-span-6 sm:col-span-3"
      />

      <TextInput
        v-model="form.email"
        name="email"
        :label="'E-mail'"
        type="email"
        class="col-span-6 sm:col-span-3"
      />
      <Multiselect
        v-model="form.locale"
        name="locale"
        :label="'Locale'"
        mode="single"
        :options="availableLocales"
        class="col-span-6 sm:col-span-3 sm:col-start-1"
        :canDeselect="false"
      >
        <template #singlelabel="{ value }">
          <LocaleFlag :locale="value.value" />
        </template>
        <template #option="{ option, search }">
          <LocaleFlag :locale="option.value" />
        </template>
      </Multiselect>
    </div>
  </Card>
</template>

<script setup lang="ts">
import { computed } from "vue";
import {
  Card,
  ImageUpload,
  Multiselect,
  TextInput,
  LocaleFlag,
} from "kingcms/Components";
import { InertiaForm, usePage } from "@inertiajs/vue3";
import type { UserProfileForm } from "../types";

interface Props {
  form: InertiaForm<UserProfileForm>;
}

const props = defineProps<Props>();

const availableLocales = computed(() => {
  return usePage().props.settings.available_locales;
});
</script>
