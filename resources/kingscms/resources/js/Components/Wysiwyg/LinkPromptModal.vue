<template>
  <Modal class="flex items-center justify-center">
    <template #trigger="{ setIsOpen }">
      <ToolbarButton
        @click="
          () => {
            form.url = editor?.getAttributes('link').href;
            setIsOpen(true);
          }
        "
        :active="editor?.isActive('link')"
        :icon="LinkIcon"
      />
    </template>
    <template #title> Add link </template>
    <template #content>
      <TextInput
        name="link_url"
        :label="'URL'"
        v-model="form.url"
        class="mb-4"
      />
      <Multiselect
    v-model="selectedLink"
    name="link"
    :searchable="true"
    @input="event => fetchLinks(event.target.value)"
    mode="single"
    :options="links"
    label="Search Link"
    track-by="value"
/>
    </template>
    <template #buttons="{ setIsOpen }">
      <Button
        @click="
          () => {
            setIsOpen(false);
            submit();
          }
        "
      >
        Submit
      </Button>
      <Button variant="outline" @click="() => setIsOpen(false)">
        Cancel
      </Button>
    </template>
  </Modal>
</template>
<script setup lang="ts">
import { ref } from 'vue';
import ToolbarButton from "./ToolbarButton.vue";
import { Modal, Button, TextInput, Multiselect } from "kingcms/Components";
import { useForm } from "@inertiajs/vue3";
import { LinkIcon } from "./icons";
import { Editor } from "@tiptap/vue-3";

const emit = defineEmits(["linkAdded"]);

interface Props {
  editor?: Editor;
}

const props = defineProps<Props>();
const links = ref<Array<{ url: string, description?: string }>>([]); // To store fetched links.
const searchQuery = ref<string>(""); // To store the search term entered by the user.
const selectedLink = ref<string>("");


const fetchLinks = async (searchTerm: string) => {
    try {
      const response = await fetch('/api/fetch-links?search=' + searchTerm, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'include'
        });
        const data = await response.json();
        links.value = data.map(link => ({
        label: link.description || link.url, // use the description as the label, but fall back to the url if there's no description
        value: link.url
}));
    
    } catch (error) {
        console.error('Error fetching links:', error);
    }
};

const form = useForm({
  url: "",
});

const submit = () => {
    if (selectedLink.value) {
        emit("linkAdded", selectedLink.value);
        form.url = "";
        selectedLink.value = "";
    } else if (form.url) {
        emit("linkAdded", form.url);
        form.url = "";
    }
};
</script>
