<template>
  <p class="text-sm font-medium text-gray-700">
    {{ numberOfSuccessfullyImportedTranslations.toString() }} successfully imported 
    {{numberOfSuccessfullyUpdatedTranslations.toString()}} successfully updated
  </p>
</template>

<script lang="ts" setup>
interface Props {
  numberOfSuccessfullyImportedTranslations: number;
  numberOfSuccessfullyUpdatedTranslations: number;
}

const props = defineProps<Props>();
</script>
