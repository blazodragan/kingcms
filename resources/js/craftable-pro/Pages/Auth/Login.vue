<template>
  <LoginPage v-bind="props" />
</template>

<script setup lang="ts">
import LoginPage from "kingcms/Pages/Auth/Login.vue";

interface Props {
  canResetPassword: boolean;
  status: string;
}

const props = defineProps<Props>();
</script>
