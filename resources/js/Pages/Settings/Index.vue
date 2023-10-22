<template>
  <IndexPage v-bind="$props" />
</template>

<script lang="ts" setup>

import IndexPage from "kingcms/Pages/Settings/Index.vue";
import {GeneralSettings} from "kingcms/Pages/Settings/types";

interface Props {
  generalSettings: GeneralSettings;
  availableRoutes: string[];
}

defineProps<Props>();

</script>
