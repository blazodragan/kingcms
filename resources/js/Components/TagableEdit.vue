<template>
    <!-- <pre>{{ JSON.stringify(favoriteLanguages) }}</pre> -->

    <vue-select v-model="favoriteLanguages" :options="languages"
    multiple
    searchable
    clear-on-select
    clear-on-close
    :maxHeight="200"
    openDirection="top"
    @search:input="handleInput"
    @update:modelValue="emitsomething"
    >
      <template #tag="{ option, remove }">
        <div :style="`border-radius: 4px; padding: 0 4px;`">
          {{ option }}
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
        tags:Array,
    everyGroupTag:Array,
    },
    emits: ['update:modelValue'],
    setup(props, { emit }) {
      const favoriteLanguages = ref(props.tags)
      const languages = ref(props.everyGroupTag)
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

      function addTemporaryOption(inputEvent: InputEvent) {
        const input = (inputEvent.target! as HTMLInputElement).value
        if (input === '') return
        if (languages.value.includes(input)) return

        languages.value.push(input)
      }

      function handleInput(inputEvent: InputEvent) {
        removeTemporaryOption(inputEvent)
        addTemporaryOption(inputEvent)
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
