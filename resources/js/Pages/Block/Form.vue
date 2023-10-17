<template>
  <PageContent>
    <div class="mx-auto max-w-3xl 2xl:max-w-4xl">
      <CardLocaleSwitcher v-model="currentLocale" class="mb-6" />

      <Card>
        <div class="space-y-4">
            <TextInput
                v-model="form.name"
                name="name"
                :label="'Name'"
                
            /> 
            <RadioGroupLink
            v-model="form.type"
              name="type"
              :label="'Type'"
              :options="typeOptions"
              mode="single"
            />

            <TextArea
                v-model="form.content[currentLocale]"
                :name="`content.${currentLocale}`"
                :label="getLabelWithLocale('Content')" 
            /> 
</div>
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
    RadioGroupLink,
    Multiselect,
    CardLocaleSwitcher
} from "craftable-pro/Components";
import { InertiaForm } from "craftable-pro/types";
import type { BlockForm } from "./types";
import { ref,reactive, watch } from "vue";

import { useFormLocale } from "craftable-pro/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();


interface Props {
  form: InertiaForm<BlockForm>;
  submit: void;
  typeOptions: Array<{ value: string | number; label: string }>;
  
}

const props = defineProps<Props>();
</script>
