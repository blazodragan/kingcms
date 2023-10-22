<template>
  <CraftableProUserProfilePage v-bind="props" />
</template>

<script setup lang="ts">
import type { CraftableProUser } from "kingcms/types/models";
import CraftableProUserProfilePage from "kingcms/Pages/CraftableProUser/Profile/Edit.vue";

interface Props {
  craftableProUser: CraftableProUser;
  locales?: string[];
}

const props = defineProps<Props>();
</script>
