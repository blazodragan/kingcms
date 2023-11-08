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
        :disabled="true"
      />
      <TextInput
        v-model="form.slug"
        name="slug"
        :label="'Slug'"
        class="col-span-6 sm:col-span-3"
      />
      <Multiselect
        v-model="form.locale"
        name="locale"
        :label="'Locale'"
        mode="single"
        :options="availableLocales"
        class="col-span-6 sm:col-span-3"
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
    <div class="mt-4">
      <Wysiwyg
              v-model="form.about"
              :name="`about`"
              :label="'About Me'"
            />

    </div>

  </Card>
</template>

<script setup lang="ts">
import { computed, watch } from "vue";
import {
  Card,
  ImageUpload,
  Multiselect,
  TextInput,
  LocaleFlag,
  Wysiwyg,
} from "kingcms/Components";
import { InertiaForm, usePage } from "@inertiajs/vue3";
import { slugify } from "kingcms/helpers/slugify";
import type { UserProfileForm } from "../types";
import { ExclamationCircleIcon, XMarkIcon, CalendarDaysIcon } from "@heroicons/vue/20/solid";

interface Props {
  form: InertiaForm<UserProfileForm>;
}

const props = defineProps<Props>();


watch(() => props.form.name, (newTitle) => {

    props.form.slug = slugify(newTitle);

});

const availableLocales = computed(() => {
  return usePage().props.settings.available_locales;
});
</script>
