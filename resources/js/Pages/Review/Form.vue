<template>
  <PageContent>
    <div class="grid items-start gap-6 xl:grid-cols-6">
      <div class="col-span-4">
        <CardLocaleSwitcher v-model="currentLocale" ref="switcher" id="cardlocale" />
        <Card class="mb-6">
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

            <Dropzone
              v-model="form.cover_review"
              name="cover_review"
              :maxFileSize="10485760"
              :label="'Cover Review'"
              :maxNumberOfFiles="1"
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


            <Accordion>
              {{ iconOptions }}
          <template #title> Useful Tips </template>
          <template #content>
            <div class="grid grid-cols-3 gap-4">
            <div v-for="(tip, index) in form.tips.filter(tip => tip.type === 'usefultip')" :key="'usefultip-' + index">
              <div class="border border-gray-200/50 p-6 rounded-md bg-gray-100 mb-4 relative">
                <div class="space-y-4">
    
                  <IconSelector 
                  v-model="tip.icon"
                  :iconOptions="iconOptions"
                  />
                    <TextInput
                    v-model="tip.title[currentLocale]"
                    :name="`title.${currentLocale}`"
                    :label="getLabelWithLocale('Title')"
                    />
                    <TextArea
                    v-model="tip.body[currentLocale]"
                    :name="`body.${currentLocale}`"
                    :label="getLabelWithLocale('body')"
                    />
                </div>
                <div class="absolute top-0 right-0 px-3 py-3">
                <Tooltip position="top">
                  <template #button>
                    <button
                    @click="removeTip(tip.id)"
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
          </div>
<div class="flex justify-center"><button class="px-2 hover:bg-slate-50 rounded border"  @click="addTip('usefultip')">+ add new</button></div>
          </template>
          </Accordion>


            <Wysiwyg
              v-model="form.text[currentLocale]"
              :name="`text.${currentLocale}`"
              :label="getLabelWithLocale('Text')"
            />
          </div>
        </Card>

        <!-- Nested Grid -->
        <div class="grid items-start gap-6 xl:grid-cols-1">
          <!-- First Card in Nested Grid -->
          <Card>
            <h2 class="mb-4">FAQs</h2>

            <div v-for="(faq, index) in form.faqs" :key="index">
              <div class="border border-gray-200 p-6 rounded-md bg-gray-50 mb-6 relative">
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
                <div class="absolute top-0 right-0 p-2">
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

            <button class="px-2 hover:bg-slate-50 rounded border"  @click="addFAQ">+ add</button>
          </Card>
        </div>
      </div>

      <!-- Second Column (spanning 2 out of 6) -->
      <div class="col-span-2">    
        <Card class="mb-6 w-full">
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
            <Multiselect
              v-model="form.rating"
              name="rating"
              :label="'Rating'"
              :options="starNumbers"
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
            />
            <Checkbox v-model="form.active" name="active" :label="'Active'" />
          </div>
        </Card>

        <Accordion class="mb-4">
          <template #title> Why Box </template>
          <template #content>
            <TextInput
                v-model="form.why[currentLocale]"
                :name="`why.${currentLocale}`"
                :label="getLabelWithLocale('Why Title')"
                class="mb-4"
                
            /> 
    <div v-for="(tip, index) in form.tips.filter(tip => tip.type === 'why')" :key="'why-' + index">
              <div class="border border-gray-200/50 p-6 rounded-md bg-gray-100 mb-4 relative">
                <div class="space-y-4">
                  <IconSelector 
                  v-model="tip.icon"
                  :iconOptions="iconOptions"
                  />
                    <TextInput
                    v-model="tip.title[currentLocale]"
                    :name="`title.${currentLocale}`"
                    :label="getLabelWithLocale('Title')"
                    />
                    <TextArea
                    v-model="tip.body[currentLocale]"
                    :name="`body.${currentLocale}`"
                    :label="getLabelWithLocale('body')"
                    />
                </div>
                <div class="absolute top-0 right-0 px-3 py-3">
                <Tooltip position="top">
                  <template #button>
                    <button
                    @click="removeTip(tip.id)"
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
<div class="flex justify-center"><button class="px-2 hover:bg-slate-50 rounded border"  @click="addTip('why')">+ add new</button></div>
          </template>
          </Accordion>
        <Card class="mb-6">
          <div class="space-y-4">
            <TextInput
              v-model="form.og_title[currentLocale]"
              :name="`og_title.${currentLocale}`"
              :label="getLabelWithLocale('Og Title')"
            />

            <TextInput
              v-model="form.og_description[currentLocale]"
              :name="`og_description.${currentLocale}`"
              :label="getLabelWithLocale('Og Description')"
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
              v-model="form.og_cover_review"
              name="og_cover_review"
              :maxFileSize="10485760"
              :label="'Og Cover Review'"
            />
          </div>
        </Card>

        <Card>
          <div class="space-y-4">
            <TextInput
              v-model="form.meta_title[currentLocale]"
              :name="`meta_title.${currentLocale}`"
              :label="getLabelWithLocale('Meta Title')"
            />

            <TextInput
              v-model="form.meta_description[currentLocale]"
              :name="`meta_description.${currentLocale}`"
              :label="getLabelWithLocale('Meta Description')"
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

            <Checkbox
              v-model="form.no_index"
              name="no_index"
              :label="'No Index'"
            />

            <Checkbox
              v-model="form.no_follow"
              name="no_follow"
              :label="'No Follow'"
            />
          </div>
        </Card>
      </div>
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
  Modal
} from "kingcms/Components";
import { TrashIcon } from "@heroicons/vue/20/solid";
import { ref,reactive, watch, Ref, computed } from 'vue';
import { EyeDropperIcon, EyeSlashIcon, EyeIcon } from "@heroicons/vue/24/outline";
import { slugify } from "kingcms/helpers/slugify";
import { InertiaForm } from "kingcms/types";
import type { ReviewForm } from "./types";
import { ChevronUpIcon } from "@heroicons/vue/20/solid";
import { useFormLocale } from "kingcms/hooks/useFormLocale";

const {
  availableLocales,
  currentLocale,
  translatableDefaultValue,
  getLabelWithLocale,
} = useFormLocale();

interface Props {
  form: InertiaForm<ReviewForm>;
  submit: void;
  userOptions: Array<{ value: string | number; label: string }>;
  categoriesOptions: Array<{ value: string | number; label: string }>;
  statusOptions: Array<{ value: string | number; label: string }>;
  iconOptions: Array<{ name: string ; path: string }>;
  templates: Array<{value: string|number, label: string}>;
  slugDisabled: Ref<boolean>;
}


const props = defineProps<Props>();


// we are formating here the template array because it needs to have a value and a label for the radio or the multiseclet componenet
const formattedTemplates = computed(() => {
  return props.templates.map(temp => ({ value: temp, label: temp }));
});
const starNumbers = computed(() => {
  return Array.from({ length: 10 }, (_, i) => i + 1);
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


let nextTipId = 1;

const addTip = (type: string): void => {
  props.form.tips.push({
    id: nextTipId++,  // Assign a unique ID to each new tip
    title: { ...translatableDefaultValue },
    body: { ...translatableDefaultValue },
    type: type,
  });
};

const removeTip = (id: number): void => {
  const index = props.form.tips.findIndex(tip => tip.id === id);
  if (index !== -1) {
    props.form.tips.splice(index, 1);
  }
};

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
  