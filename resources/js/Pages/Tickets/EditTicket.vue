<script setup>
import { ref, onMounted, onUnmounted, nextTick} from "vue";
import { useForm, Head, Link, router } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ColorButton from "@/Components/ColorButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import TagableEdit from "@/Components/TagableEdit.vue";
import ActionMessage from "@/Components/ActionMessage.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import { pauseTracking } from "@vue/reactivity";
import { propsToAttrMap } from "@vue/shared";
import FormSection from "@/Components/FormSection.vue";
import MessageList from "@/Components/MessageList.vue";
import {DocumentPlusIcon, PencilIcon} from '@heroicons/vue/24/outline';
import SectionBorder from '@/Components/SectionBorder.vue';
import Pagination from "@/Components/Pagination.vue";
import { pickBy } from "lodash";
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';


const props = defineProps({
  ticket: Object,
  success: String,
    statusEnum : Array,
    priorityEnum : Array,
});

const photoPreview = ref(null);
const photoInput = ref(null);
const alltags = ref(props.ticket.tags);
const ticketStatus = ref(props.ticket.status);
const ticketPriority = ref(props.ticket.priority);


const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo_path = photoInput.value.files[0];

    if (!photo_path) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };
    reader.readAsDataURL(photo_path);
};

const deletePhoto = () => {
    form.delete(route("current-photo.destroy", props.ticket), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};

const form = useForm({
    _method: "PUT",
    title: props.ticket.title,
    message: props.ticket.message,
    tags: null,
    something : 'new',
    photo_path: null,
    status: null,
    priority: null
});

const submitForm = () => {
    if (photoInput.value) {
        form.photo_path = photoInput.value.files[0];
    }
    form.tags = alltags;
    form.status = ticketStatus;
    form.priority = ticketPriority;

    form.post(route("tickets.update", props.ticket), {
        errorBag: "updateProfileInformation",
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),
    });
};

const saveEditTicket = (e) => {
    if (e.key === "s" && (e.altKey || e.metaKey) && form.processing === false && route().current() == 'tickets.edit') {
        e.preventDefault();
        form.processing = true;
        nextTick().then(submitForm());
    }
};

function removeAllTags(alltags){
    alltags.length = 0
}

function removeTag(alltags, tagIndex) {
    if (alltags[tagIndex] !== undefined) {
        alltags.splice(tagIndex, 1);
    }
}

</script>

<template>
  <AppLayout title="Tickets">
    <template #header>
        <div class="flex items-center">
            <div
                class="
            flex
            mr-2
            flex-shrink-0
            items-center
            justify-center
            bg-green-200
            h-12
            w-12
            rounded-xl
          "
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    aria-hidden="true"
                    class="w-6 h-6 text-green-700"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 01-1.125-1.125v-3.75zM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-8.25zM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 01-1.125-1.125v-2.25z"
                    ></path>
                </svg>
            </div>
            <div>
                <h2 class="font-semibold text-xl text-black leading-tight">
                    <Link
                        :href="route('tickets.index')"
                        class="underline text-gray-600 hover:text-gray-900"
                    >Tickets</Link
                    >
                    / {{ form.title }}
                </h2>
                <span class="text-sm text-gray-500"
                >Edit This Ticket</span
                >
            </div>
        </div>
    </template>


      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
          <div class="md:grid md:grid-cols-4 md:gap-6">
              <div class="md:col-span-2 flex justify-between">
                  <div class="px-4 sm:px-0">
                      <h3 class="text-lg font-medium text-gray-900">Ticket Information</h3>
                      <p class="mt-1 text-sm text-gray-600">
                          Update ticket inormation image needs to be under 1MB use tickets to
                          organise messages
                      </p>
                  </div>

                  <div class="px-4 sm:px-0">
                      <slot name="aside" />
                  </div>
              </div>
              <div class="mt-5 md:mt-0 md:col-span-4">
                  <form @submit.prevent="submitForm">
                      <div
                          class="
                px-4
                py-5
                bg-white
                sm:p-6
                shadow
                sm:rounded-tl-md sm:rounded-tr-md
              "
                      >
                          <!-- Enable -->

<!-- top grid -->
<div class="grid lg:grid-cols-4 md:grid-cols-2 gap-6 w-full">
    <div>
        <div class="col-span-6 sm:col-span-4">
            <!-- Profile Photo File Input -->
            <input
                ref="photoInput"
                type="file"
                class="hidden"
                @change="updatePhotoPreview"
            />

            <InputLabel value="Photo" />

            <!-- Current Profile Photo -->
            <div v-show="!photoPreview" class="mt-2">
                <img
                    :src="ticket.photo_url"
                    :alt="ticket.title"
                    class="rounded-sm h-44 w-auto object-cover"
                />
            </div>

            <!-- New Profile Photo Preview -->
            <div v-show="photoPreview" class="mt-2">
                    <span
                        class="
                        block
                        rounded-sm
                        w-auto
                        h-44
                        bg-cover bg-no-repeat bg-center
                      "
                        :style="
                        'background-image: url(\'' + photoPreview + '\');'
                      "
                    />
            </div>

            <SecondaryButton
                class="mt-2 mr-2"
                type="button"
                @click.prevent="selectNewPhoto"
            >
                Select Photo
            </SecondaryButton>

            <SecondaryButton
                v-if="ticket.photo_path"
                type="button"
                class="mt-2"
                @click.prevent="deletePhoto"
            >
                Remove Photo
            </SecondaryButton>

            <InputError :message="form.errors.photo_path" class="mt-2" />
        </div>
    </div>
    <!-- Status -->
    <div>
    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Status</h3>
    <ul v-if="statusEnum.length > 0" class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <li v-for="status in statusEnum" class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
            <div class="flex items-center pl-3">
                <input :id="status" type="radio" :checked="ticketStatus == status" v-model="ticketStatus" :value="status" name="status" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                <label :for="status" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ status }}</label>
            </div>
        </li>
    </ul>
    </div>
    <!-- End Status -->
    <!-- Priority -->
    <div>
    <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Priority</h3>
    <ul v-if="priorityEnum.length > 0" class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        <li v-for="priority in priorityEnum" class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
            <div class="flex items-center pl-3">
                <input :id="priority" type="radio" :checked="ticketPriority == priority" v-model="ticketPriority" :value="priority" name="priority" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                <label :for="priority" class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ priority }}</label>
            </div>
        </li>
    </ul>
    </div>
    <!-- End Priority -->
    <!-- type -->
    <div>
        <div class="col-span-6 sm:col-span-4">
            <InputLabel value="Type" />
            <TagableEdit
                v-model="alltags"
                :tags="props.ticket.tags"
                :everyGroupTag="props.ticket.allTicketTags"
            />
        </div>
        <div v-if="alltags" class="vue-tags col-span-4 relative">
            <div v-if="(alltags.length > 0)" class="absolute top-0 right-0 p-0.5 hover:bg-gray-400 bg-gray-200 hover:text-gray-900 cursor-pointer rounded-full" @click.stop="removeAllTags(alltags)">
                <svg aria-hidden="true" class="w-4 h-4 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </div>
            <div v-for="(tag,index) in alltags" :key="tag" class="vue-tag selected">{{ tag }} <span @click.stop="removeTag(alltags, index)"></span>
            </div>
        </div>
    </div>
    <!-- end type -->
</div>
<!-- end top grid -->


                          <!-- Profile Photo -->
                          <div class="mt-4">

                              <!-- Name -->
                              <div class="col-span-6 sm:col-span-4 mb-4">
                                  <InputLabel  value="Title" />
                                  <TextInput
                                      id="name"
                                      v-model="form.title"
                                      type="text"
                                      class="mt-1 block w-full"
                                      autocomplete="name"
                                      autofocus
                                  />
                                  <InputError :message="form.errors.title" class="mt-2" />
                              </div>
                              <!-- Message -->
                              <div class="col-span-6 sm:col-span-4 mb-4">
                                  <InputLabel  value="Message" />
                                  <QuillEditor theme="snow" v-model:content="form.message" contentType="html" />
                                  <InputError :message="form.errors.message" class="mt-2" />
                              </div>


                          </div>
                      </div>
                      <div
                          class="
                flex
                items-center
                justify-start
                px-4
                py-3
                bg-gray-50
                text-right
                sm:px-6
                shadow
                sm:rounded-bl-md sm:rounded-br-md
              "
                      >
                          <PrimaryButton
                              :class="{ 'opacity-25': form.processing }"
                              :disabled="form.processing"
                          >
                              <PencilIcon
                                  class="mr-2 -ml-1 w-4 h-4"
                              />
                              Edit Ticket
                              {{ form.progress ? `${form.progress.percentage}%` : "" }}
                              <kbd class="ml-2 mr-1 px-1 text-xs font-semibold text-black bg-indigo-200 border border-indigo-300 rounded-lg">alt</kbd> + <kbd class="ml-1 px-1 text-xs font-semibold text-black bg-indigo-200 border border-indigo-300 rounded-lg">s</kbd>
                          </PrimaryButton>
                          <ActionMessage :on="form.recentlySuccessful" class="ml-3">
                              Saved.
                          </ActionMessage>
                      </div>

                  </form>
                  <div class="hidden sm:block">
                      <div class="pt-12 pb-4">
                          <div class="border-t border-gray-200" />
                      </div>
                  </div>
              </div>





              <div class="mt-5 md:mt-0 md:col-span-4">




                  <div class="overflow-x-auto relative shadow-md sm:rounded-lg">


                  </div>
              </div>
          </div>
      </div>

  </AppLayout>
</template>
