<template>
    <vue-select
      v-model="innerModelValue"
      @update:modelValue="handleUpdateModelValue"
      v-bind="$attrs"
      multiple
    />
  </template>
  
  <script>
  import { defineComponent, nextTick, watch, ref } from "vue";
  import VueSelect from "vue-next-select";
  import "vue-next-select/dist/index.css";
  
  export default defineComponent({
    components: {
      VueSelect,
    },
  
    props: ["modelValue"],
  
    emits: ["update:modelValue"],
  
    setup(props, context) {
      const innerModelValue = ref(null);
  
      // Since we may programmically update modelValue from parent page
      // we need to watch modelValue instead of copy it once.
      watch(
        () => props.modelValue,
        async () => {
          await nextTick();
  
          if (props.modelValue === innerModelValue.value) return;
          innerModelValue.value = props.modelValue;
        },
        { immediate: true }
      );
  
      const handleUpdateModelValue = (newValue) => {
        context.emit("update:modelValue", newValue);
      };
  
      return {
        innerModelValue,
        handleUpdateModelValue,
      };
    },
  });
  </script>
  