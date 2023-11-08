<template>
  <PageContent>
    <div class="grid items-start gap-6 xl:grid-cols-6">
    <div class="col-span-4">
        <CardLocaleSwitcher v-model="currentLocale" ref="switcher" id="cardlocale"/>
        <Card class="mb-6 ">
        <div class="space-y-4">
            <TextInput
                v-model="form.title[currentLocale]"
                :name="`title.${currentLocale}`"
                :label="getLabelWithLocale('Title')"
                
            /> 

            <div class="col-span-1 flex items-start gap-2">
            <div class="flex gap-1 flex-col flex-1">
              <TextInput v-model="form.slug[currentLocale]" :name="`slug.${currentLocale}`" :label="getLabelWithLocale('Slug')" :disabled="slugDisabled" @input="handleSlugInput" />
            </div>
            <Modal type="danger">
                <template #trigger="{ setIsOpen }">
                  <Button :leftIcon="slugDisabled ? EyeIcon : EyeSlashIcon" @click="() => { slugDisabled ? setIsOpen(true) : toggleSlugInput() }" class="text-sm mt-6" :loading="form.processing" v-can="'sanctum.category.create'">{{ slugDisabled ? 'Edit' : 'Disable' }}</Button>
                </template>

              <template #title>Edit Slug
              </template>
              <template #content>Are you sure you want to edit the slug. If you do you need to make a rule for redirecting
                to the new slug
              </template>

              <template #buttons="{ setIsOpen }">
                <Button @click="toggleSlugInput" @click.prevent="() => setIsOpen()" color="primary">Ok
                </Button>
                <Button @click.prevent="() => setIsOpen()" color="gray" variant="outline">Cancel
                </Button>
              </template>
            </Modal>
          </div>
          <a class="text-xs pl-1 mt-1 text-blue-600" target="_balnk" :href="route('showBlogPost', {slug: form.slug?.[currentLocale]})">{{ route('showBlogPost', {slug: form.slug?.[currentLocale]}) }}</a>

            <Dropzone
                v-model="form.cover"
                name="cover"
                :maxFileSize="10485760"
                :label="'Cover'"
            /> 

            <TextInput
                v-model="form.perex[currentLocale]"
                :name="`perex.${currentLocale}`"
                :label="getLabelWithLocale('Perex')"
                
            /> 

            <Wysiwyg
                v-model="form.content[currentLocale]"
                :name="`content.${currentLocale}`"
                :label="getLabelWithLocale('Content')"
            /> 


          

        

        </div>
      </Card>

                <!-- First Card in Nested Grid -->
                <Accordion>
          <template #title> FAQs </template>
          <template #content>
            <div v-for="(faq, index) in form.faqs" :key="index">
              <div class="border border-gray-200/50 p-6 rounded-md bg-gray-100 mb-4 relative">
                <div class="space-y-4">
                    <TextInput
                    v-model="faq.question[currentLocale]"
                    :name="`question.${currentLocale}`"
                    :label="getLabelWithLocale('Question')"
                    />
                    <TextInput
                    v-model="faq.answer[currentLocale]"
                    :name="`answer.${currentLocale}`"
                    :label="getLabelWithLocale('Answer')"
                    />
                </div>
                <div class="absolute top-0 right-0 px-3 py-3">
                <Tooltip position="top">
                  <template #button>
                    <button
                      @click="removeFAQ(index)"
                      class="hover:cursor-pointer"
                    >
                      <svg
                        class="h-5 w-5 stroke-gray-400 hover:stroke-gray-700"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                    </button>
                  </template>
                  <template #content> Delete </template>
                </Tooltip>

                </div>

              </div>
            </div>
<div class="flex justify-center"><button class="px-2 hover:bg-slate-50 rounded border"  @click="addFAQ">+ add new</button></div>
          </template>
          </Accordion>
      <div class="grid items-start gap-6 xl:grid-cols-2">
        <div class="col-span-1">

    </div>
          <div class="col-span-1">

    </div>
    
</div>
    </div>

    <div class="col-span-4 md:col-span-2">
      <Card class="mb-4">
        <div class="space-y-4">
            <RadioGroupLink
            v-model="form.status"
              name="status"
              :label="'Status'"
              :options="statusOptions"
              mode="single"
            />
            <Multiselect
              v-model="form.template"
              name="template"
              :label="'Template'"
              :options="formattedTemplates"
              mode="single"
            />

            <DatePicker
                v-model="form.published_at"
                name="published_at"
                mode="dateTime"
                :label="'Published At'"
            /> 
            <Multiselect
                v-model="form.user_id"
                name="user_id"
                :label="'User'"
                :options="userOptions"
                mode="single"
            /> 

            <Multiselect
                v-model="form.categories_ids"
                name="categories_ids"
                :label="'Categories'"
                :options="categoriesOptions"
                :mode="'tags'"
            /></div>
      </Card>
      <Card class="mb-4">
        <div class="space-y-4">
        <TextInput
                v-model="form.meta_title[currentLocale]"
                :name="`meta_title.${currentLocale}`"
                :label="getLabelWithLocale('Meta Title')"
                minCharactersCount="50"
                maxCharactersCount="60"
                
            /> 

            <TextInput
                v-model="form.meta_description[currentLocale]"
                :name="`meta_description.${currentLocale}`"
                :label="getLabelWithLocale('Meta Description')"
                minCharactersCount="150"
                maxCharactersCount="160"
                
            /> 

            <TextInput
                v-model="form.meta_url_canolical[currentLocale]"
                :name="`meta_url_canolical.${currentLocale}`"
                :label="getLabelWithLocale('Meta Url Canolical')"
                
            /> 

            <TextInput
                v-model="form.href_lang[currentLocale]"
                :name="`href_lang.${currentLocale}`"
                :label="getLabelWithLocale('Href Lang')"
                
            /> 

            <div class="flex flex-row justify-between">
    <SwitchGroup>
    <div class="flex items-center">
      <SwitchLabel class="mr-4">No Index</SwitchLabel>
      <Switch
        v-model="form.no_index"
        :class='form.no_index ? "bg-blue-600" : "bg-gray-200"'
        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      >
        <span
          :class='form.no_index ? "translate-x-6" : "translate-x-1"'
          class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
        />
      </Switch>
    </div>
  </SwitchGroup>
  <SwitchGroup>
    <div class="flex items-center">
      <SwitchLabel class="mr-4">No Follow</SwitchLabel>
      <Switch
        v-model="form.no_follow"
        :class='form.no_follow ? "bg-blue-600" : "bg-gray-200"'
        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
      >
        <span
          :class='form.no_follow ? "translate-x-6" : "translate-x-1"'
          class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
        />
      </Switch>
    </div>
  </SwitchGroup>
  </div>




        </div>
      </Card>
      <Card>
        <div class="space-y-4">
        <TextInput
                v-model="form.og_title[currentLocale]"
                :name="`og_title.${currentLocale}`"
                :label="getLabelWithLocale('Og Title')"
                minCharactersCount="50"
                maxCharactersCount="60"
                
            /> 

            <TextInput
                v-model="form.og_description[currentLocale]"
                :name="`og_description.${currentLocale}`"
                :label="getLabelWithLocale('Og Description')"
                minCharactersCount="150"
                maxCharactersCount="200"
                
            /> 

            <TextInput
                v-model="form.og_type[currentLocale]"
                :name="`og_type.${currentLocale}`"
                :label="getLabelWithLocale('Og Type')"
                
            /> 

            <TextInput
                v-model="form.og_url[currentLocale]"
                :name="`og_url.${currentLocale}`"
                :label="getLabelWithLocale('Og Url')"
                
            /> 


            <Dropzone
                v-model="form.og_cover"
                name="og_cover"
                :maxFileSize="10485760"
                :label="'Og Cover'"
            /> 
        </div>
      </Card>
    </div>
    </div>
  </PageContent>
</template>

<script setup lang="ts">
import { ref, reactive, watch, Ref, computed } from 'vue';
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue'
import {
    Card,
    TextInput,
    Wysiwyg,
    TextArea,
    PageContent,
    DatePicker,
    Checkbox,
    Tooltip,
    Dropzone,
    ImageUpload,
    Multiselect,
    CardLocaleSwitcher,
    RadioGroupLink,
    Accordion,
    IconSelector,
    Button,
    IconButton,
    Modal,
} from "kingcms/Components";
import { EyeDropperIcon, EyeSlashIcon, EyeIcon, ChevronUpIcon } from "@heroicons/vue/24/outline";
import { InertiaForm } from "kingcms/types";
import type { PostForm } from "./types";
import { slugify } from "kingcms/helpers/slugify";
import { useFormLocale } from "kingcms/hooks/useFormLocale"; 


const { availableLocales, currentLocale, translatableDefaultValue, getLabelWithLocale } = useFormLocale();
            

interface Props {
  form: InertiaForm<PostForm>;
  submit: void;
  userOptions: Array<{value: string|number, label: string}>;
  categoriesOptions: Array<{value: string|number, label: string}>
  statusOptions: Array<{ value: string | number; label: string }>;
  slugDisabled: Ref<boolean>;
  templates: Array<{value: string, label: string}>;
}

const props = defineProps<Props>();


// we are formating here the template array because it needs to have a value and a label for the radio or the multiseclet componenet
const formattedTemplates = computed(() => {
  return props.templates.map(temp => ({ value: temp, label: temp }));
});

const addFAQ = (): void => {
  props.form.faqs.push({
    question: { ...translatableDefaultValue },
    answer: { ...translatableDefaultValue },
  });
};

const removeFAQ = (index: number): void => {
  props.form.faqs.splice(index, 1);
};

// for the slug section 

const slugDisabled = ref<boolean>(props.form.slug[currentLocale.value] ? true : false);

const toggleSlugInput = () => {
  slugDisabled.value = !slugDisabled.value;
};

watch(() => props.form.title[currentLocale.value], (newTitle) => {
  if (!slugDisabled.value) {
    props.form.slug[currentLocale.value] = slugify(newTitle);
  }
});

const handleSlugInput = () => {
    props.form.slug[currentLocale.value] = slugify(props.form.slug[currentLocale.value]);
};

</script>
