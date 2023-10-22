<template>
  <ForgotPasswordPage v-bind="props" />
</template>

<script setup lang="ts">
import ForgotPasswordPage from "kingcms/Pages/Auth/ForgotPassword.vue";

interface Props {
  status: string;
}

const props = defineProps<Props>();
</script>
