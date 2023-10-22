<template>
  <CraftableProUserPasswordPage v-bind="props" />
</template>

<script setup lang="ts">
import type { CraftableProUser } from "kingcms/types/models";
import CraftableProUserPasswordPage from "kingcms/Pages/CraftableProUser/Password/Edit.vue";

interface Props {
  craftableProUser: CraftableProUser;
}

const props = defineProps<Props>();
</script>
