<script setup>
import Modal from './Modal.vue';
import {DocumentPlusIcon} from '@heroicons/vue/24/outline';
import InputLabel from "@/Components/InputLabel.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import ColorButton from "@/Components/ColorButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Tagable from "@/Components/Tagable.vue";
import { ref, computed } from 'vue';
import { useForm } from "@inertiajs/vue3";

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '4xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    id: Number,
    name: String,
    color: String,
    tags: Object,
});

const close = () => {
    emit('close');
};

// Keyword logic
const mainColors = [
  { color: "bg-rose-600" },
  { color: "bg-fuchsia-600" },
  { color: "bg-purple-600" },
  { color: "bg-violet-600" },
  { color: "bg-indigo-600" },
  { color: "bg-blue-600" },
  { color: "bg-sky-600" },
  { color: "bg-cyan-600" },
  { color: "bg-teal-600" },
  { color: "bg-emerald-600" },
  { color: "bg-green-600" },
  { color: "bg-lime-600" },
  { color: "bg-yellow-600" },
  { color: "bg-amber-600" },
  { color: "bg-orange-600" },
  { color: "bg-red-600" },
  { color: "bg-stone-600" },
  { color: "bg-neutral-600" },
  { color: "bg-zinc-600" },
  { color: "bg-gray-600" },
  { color: "bg-pink-600" },
];

const keywordStatus = ref(false);
const keywordColor = ref(null);
const importKeywords = ref(null);
const alltags = ref();


const form = useForm({
  name: "",
  group_id: props.id,
  tags: alltags,
  status: keywordStatus,
  keywordColor: keywordColor,
  importKeywords:null,
});


const submitFormImport = () => {

  form.post(route("keywords.import"), {
    _method: "PUT",
    preserveScroll: true,
    onSuccess: () => {
      return Promise.all([
        form.reset(),
        emit('close'),
      ]);
    },
  });
};
function changeColor(newColor) {
  keywordColor.value = newColor;
  console.log(keywordColor.value);
}

const addTags = computed(() => {
  return [...props.allTags];
});
</script>

<template>
    <Modal
        :show="props.show"
        :max-width="props.maxWidth"
        :closeable="props.closeable"
        @close="close"
    >
        <div class="bg-white px-4 pt-5 sm:p-6 sm:pb-0">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 ">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    <slot name="title" />
                </h3>
                <button type="button" @click="close" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

        </div>
        <form @submit.prevent="submitFormImport">
              <div class="max-w-full mx-auto px-8 pb-8">
                <div class="grid gap-4 sm:grid-cols-3">
                    <!-- Selected Group -->
                    <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="Selected Group" value="Selected Group" />
                        <div class="flex items-center align-middle mt-2">
                            <div :class="[props.color]" class="inline-block w-2 h-2 rounded-full mr-2"></div>{{props.name}}
                        </div>
                    </div>

                                        <!-- Enable -->
                                        <div class="col-span-6 sm:col-span-4">
                        <InputLabel for="Status" value="Status" />
                        <label
                          for="large-toggle-keyword"
                          class="
                            mt-2
                            inline-flex
                            relative
                            items-center
                            cursor-pointer
                          "
                        >
                          <input
                            type="checkbox"
                            v-model="keywordStatus"
                            :checked="keywordStatus"
                            id="large-toggle-keyword"
                            class="sr-only peer"
                          />
                          <div
                            class="
                              w-14
                              h-7
                              bg-gray-200
                              peer-focus:outline-none
                              peer-focus:ring-4
                              peer-focus:ring-blue-300
                              dark:peer-focus:ring-blue-800
                              rounded-full
                              peer
                              dark:bg-gray-700
                              peer-checked:after:translate-x-full
                              peer-checked:after:border-white
                              after:content-['']
                              after:absolute
                              after:top-0.5
                              after:left-[4px]
                              after:bg-white
                              after:border-gray-300
                              after:border
                              after:rounded-full
                              after:h-6
                              after:w-6
                              after:transition-all
                              dark:border-gray-600
                              peer-checked:bg-blue-600
                            "
                          ></div>
                          <span
                            v-if="keywordStatus"
                            class="
                              ml-3
                              text-sm
                              font-medium
                              text-gray-900
                              dark:text-gray-300
                            "
                            >Enabled</span
                          >
                        </label>
                      </div>
                                            <!-- Color -->

                                            <div class="col-span-6 sm:col-span-4">
                        <div
                          class="flex items-center pb-2 text-gray-900 bg-white"
                        >
                          <span class="mr-2">Keyword Tag</span
                          ><span
                            class="w-5 h-5 rounded-full"
                            :class="[keywordColor]"
                          ></span>
                        </div>
                        <div class="col-span-6 sm:col-span-4">
                          <ColorButton
                            v-for="item in mainColors"
                            :key="item.color"
                            :color="item.color"
                            v-model="keywordColor"
                            @click.prevent="changeColor(item.color)"
                          />
                        </div>
                      </div>
                      <div class="sm:col-span-3">
 

                        <span class="mr-2">Import Keywords</span>
                        <TextArea
                          id="name"
                          v-model="form.importKeywords"
                          type="text"
                          class="block w-full"
                          autocomplete="name"
                          placeholder="Use comma or new row to import keywords"
                        />
                        <span class="limiter">{{ 1240 - form.importKeywords?.length || 1240 }} characters remaining</span>
                        <InputError :message="form.errors.importKeywords" />
                      </div>
                      <!-- <div class="sm:col-span-2 h-20 relative">
                        <InputLabel for="tags" value="Tags" />
                        <div class="absolute w-full">
                        <Tagable v-model="alltags" :tags="props.allTags" />
                        <InputError :message="form.errors.tags" />
                      </div>
                      </div> -->
                      <div class="sm:col-span-4">
                        <InputLabel for="Source" value="Add Source" />
                                              <TextInput
                          id="name"
                          v-model="form.name"
                          type="text"
                          class="block w-full"
                          autocomplete="name"
                        />
                        <InputError :message="form.errors.name" />
                      </div>
                                          <!-- select tags -->
                    <div class="sm:col-span-2 h-20 relative">
                        <InputLabel for="tags" value="Tags" />
                        <div class="absolute w-full">
                        <Tagable v-model="alltags" :tags="props.tags" />
                        <InputError :message="form.errors.tags" />
                      </div>
                      </div>




                </div>
              </div>
              <div
                class="
                  flex flex-row
                  justify-end
                  px-6
                  py-4
                  bg-gray-100
                  text-right
                "
              >
                <PrimaryButton
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Add Keyword
                  {{ form.progress ? `${form.progress.percentage}%` : "" }}
                </PrimaryButton>
                <ActionMessage :on="form.recentlySuccessful" class="ml-3">
                  Saved.
                </ActionMessage>
                <SecondaryButton @click="addFormMassImport = null">
                  Cancel
                </SecondaryButton>
              </div>
            </form>

    </Modal>
</template>