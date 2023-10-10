<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      

      <Card>
        <div class="space-y-4">
            <TextInput
                v-model="form.name"
                name="name"
                :label="$t('craftable-pro', 'Name')"
                
            /> 

            <TextInput
                v-model="form.email"
                name="email"
                :label="$t('craftable-pro', 'Email')"
                
            /> 

            <Dropzone
                v-model="form.cover"
                name="cover"
                :maxFileSize="10485760"
                :label="$t('craftable-pro', 'Cover')"
            /></div>
      </Card>
    </div>
  </PageContent>
</template>

<script setup lang="ts">
import {
    Card,
    TextInput,
    Wysiwyg,
    TextArea,
    PageContent,
    DatePicker,
    Checkbox,
    Dropzone,
    ImageUpload,
    Multiselect,
    CardLocaleSwitcher
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { AuthorForm } from "./types";



interface Props {
  form: InertiaForm<AuthorForm>;
  submit: void;
  
}

const props = defineProps<Props>();
</script>
