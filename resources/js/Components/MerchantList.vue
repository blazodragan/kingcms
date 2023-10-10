<script setup>
import { ref, computed, watch } from "vue";

import { useForm, Head, Link, router  } from "@inertiajs/vue3";
import axios from 'axios';

const props = defineProps({
    merchant: "",
    allSelectedTickets: "",
});

const terminals = ref([]);
const isRotated = ref(false);   // State to track rotation
const showTerminals = ref(false); // State to track if terminals should be shown


const loadTerminals = (merchant) => {
    isRotated.value = !isRotated.value;  // Toggle rotation
    showTerminals.value = !showTerminals.value; // Toggle showing terminals
      axios.get(`/merchants/${props.merchant.id}/load`)
        .then(response => {
          terminals.value = response.data;
          console.log(terminals.value);
        })
        .catch(error => {
          console.error("Error fetching terminals:", error);
        });
    };





</script>




<template>
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td>
             
                <button v-if="merchant.merchant_finance_code !== null" @click="loadTerminals(merchant.id)" class="ml-1.5 mr-1.5">
                    <svg class="w-5 h-5 ml-1.5" :class="{ 'rotate-180': isRotated }" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                              </svg>
                </button>
     
            </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ merchant.name }}
                </th>

                <td class="px-6 py-4">
                    {{ merchant.merchant_finance_code }}
                </td>
                <td class="px-6 py-4">
                    <span class="bg-blue-200 text-blue-900 text-xs font-medium px-2 py-0.5 rounded mr-1" v-for="contact in merchant.contacts" :key="contact.index" :value="contact">
                          {{ contact.name }}
                      </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <template v-if="merchant.merchant_finance_code !== null ">
                <Link class="underline mr-2" :href="`/merchants/${merchant.id}/check`" tabindex="-1">Contacts</Link>
                <Link class="underline" :href="`/merchants/${merchant.merchant_finance_code}/invoice`" tabindex="-1">Invoices</Link>
            </template>

                </td>
    </tr>
            <template v-if="showTerminals">
            <tr class="overflow-x-auto flex-grow flex-shrink flex-basis-0 w-full bg-white" v-for="contacts in terminals" :key="contacts.id">
                    <td class="p-4 border-b" colspan="5">
                        <div v-for="contact in contacts" :key="contact.id" class="grid gap-1 grid-cols-1 mb-2">
                            <span class="bg-blue-200 text-blue-900 text-xs font-medium px-2 py-0.5 rounded mr-1">{{ contact.name }}</span>
                            <div v-for="terminals in contact['terminals']" :key="terminals.id" class="bg-white mb-1">
                            {{ terminals.name }}
                            {{ terminals.description }}
                        </div>
                        </div>
                    </td>       
            </tr>
            </template>
     


</template>
