<template>
    <div>
        <div v-for="(field, index) in fields" :key="index">
          <i class="handle fas fa-grip-lines"></i>
          <label>Input:</label>
          <input v-model="field.input" />
          <label>Image:</label>
          <input type="file" ref="photoInput"  @change="handleImageUpload(field.image, index)" />
          <img :src="field.imageUrl" />
          <button @click="removeField(index)">Remove Field</button>
        </div>
      <button @click="addField">Add Field</button>
    </div>
  </template>
  <script>
  import { ref, computed } from 'vue'
  import draggable from 'vuedraggable'

  export default {
    components: {
      draggable
    },
    setup() {
      const fields = ref([])
      const photoInput= ref(null)

      function addField() {
        fields.value.push({
          input: '',
          image: null,
          imageUrl: '',
        })
      }

      function handleImageUpload(file, index) {
        const photo_path = photoInput.value.files[0];
        const reader = new FileReader()
        reader.onload = (e) => {
          fields.value[index].imageUrl = e.target.result
        }
        reader.readAsDataURL(photo_path)
      }

      function removeField(index) {
        fields.value.splice(index, 1)
      }

      return {
        fields,
        addField,
        handleImageUpload,
        removeField
      }
    }
  }
  </script>
  <style>
  .handle {
    cursor: grab;
  }
  </style>
