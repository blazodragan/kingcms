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
    contactView: Object,
    statusEnum : Array,
    priorityEnum : Array,
});


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
                    >Merchant</Link
                    >
                </h2>

            </div>
        </div>
    </template>


      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
          <div class="md:grid md:grid-cols-4 md:gap-6">
              <div class="md:col-span-4 flex justify-between">
                  <div class="px-4 sm:px-0">
                      <h3 class="text-lg font-medium text-gray-900">Merchant Information</h3>

                  </div>

                  <div class="px-4 sm:px-0">

                  </div>
              </div>
              <div class="mt-5 md:mt-0 md:col-span-4">
   
                  <div class="hidden sm:block">
                      <div class="pt-12 pb-4">
                          <div class="border-t border-gray-200" />
                      </div>
                  </div>
              </div>





              <div class="mt-5 md:mt-0 md:col-span-4">
                <div
                  v-for="contacts in props.contactView"
                  :key="contacts.id"
                  >
                {{ contact }}
                
                    <div
                    v-for="terminals in contacts"
                    :key="terminals.id"
                    >
                    <div class="flex justify-between p-4">
                    <span>Contact : {{ terminals.name }}</span>
                    <span>Contact id : {{ terminals.id_c }}</span>
                </div>
                        <div
                        v-for="terminal in terminals"
                        :key="terminal.id"
                        >
                            <div
                            v-for="ter in terminal"
                            :key="ter.id"
                            >
                            <div v-if="ter.name" :class="flex">
                                <span class="bg-white p-2 m-2">{{ ter.name }}</span>
                                <span class="bg-white p-2">{{ ter.description }}</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>




                  <div class="overflow-x-auto relative shadow-md sm:rounded-lg">


                  </div>
              </div>
          </div>
      </div>

  </AppLayout>
</template>
