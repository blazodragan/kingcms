<template>
  <RegisterPage v-bind="props" />
</template>

<script setup lang="ts">
import RegisterPage from "kingcms/Pages/Auth/Register.vue";

interface Props {
  locales: string[];
  defaultLocale: string;
}

const props = defineProps<Props>();
</script>
