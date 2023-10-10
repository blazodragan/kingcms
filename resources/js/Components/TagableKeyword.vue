<template>
  <!-- <pre>{{ JSON.stringify(favoriteLanguages) }}</pre> -->

  <vue-select v-model="favoriteLanguages" :options="languages"
  multiple
  searchable
  clear-on-select
  label-by="name"
  track-by="name"
  value-by="id"
  clear-on-close
  openDirection="top"
  :maxHeight="200"
  :max="1"
  @search:input="handleInput"
  @update:modelValue="emitsomething"
  taggable>
    <template #tag="{ option, remove }">
      <div :style="`border-radius: 4px; padding: 0 4px;`">
        <div class="inline-block w-2 h-2 rounded-full mr-2"  :class="[option.groupColor]"></div>{{ option.name }}
        <span @click.stop="remove"></span>
      </div>
    </template>
  </vue-select>
</template>

<script lang="ts">
import { defineComponent, ref, computed  } from 'vue'
import VueSelect from 'vue-next-select'
    
export default defineComponent({
  components: { VueSelect },
  props: {
  modelValue: Array,
  tags:Object,

  },
  emits: ['update:modelValue'],
  setup(props, { emit }) { 
    const favoriteLanguages = ref('')
    const languages = ref(props.tags)
    const prevInput = ref('')
    const emitsomething = (value: Array<string>) => {
    emit('update:modelValue', value)
  };


    function removeTemporaryOption(inputEvent: InputEvent) {
      if (favoriteLanguages.value.includes(prevInput.value) === false) {
        languages.value = languages.value.filter(option => option !== prevInput.value)
      }
        prevInput.value = (inputEvent.target! as HTMLInputElement).value
    }



    function handleInput(inputEvent: InputEvent) {
      removeTemporaryOption(inputEvent)
    }

    return {
      favoriteLanguages,
      languages,
      handleInput,
      emitsomething,
    }
  },
})
</script>
9:47 AM 11/21/2022