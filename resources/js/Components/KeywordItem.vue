<script setup>
import { ref } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

const props = defineProps({
  keyword: "",
  allSelectedKeywords:""
});
const emit = defineEmits(["add", "remove"]);
const checked = ref(false);
const keywordBeingDeleted = ref(null);
const deletekeywordForm = useForm();

const confirmkeywordDeletion = (id) => {
  keywordBeingDeleted.value = id;
};

const deletekeyword = () => {
  deletekeywordForm.delete(
    route("keywords.destroy", keywordBeingDeleted.value),
    {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => (keywordBeingDeleted.value = null),
    }
  );
};
const handleChange = (id, checked) => {
  if (checked == true) {
    console.log(id);
    emit("add", id);
  } else {
    emit("remove", id);
  }
};


</script>
 
<template>
  <tr tabindex="0" class="focus:outline-none h-16 border border-gray-100 rounded">
                                <td>
                                    <div class="ml-5">
                                        <div class=" rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative">
                                          <input
        type="checkbox"
        :value="keyword.id"
        :id="keyword.id"
        v-model="checked"
        :checked="allSelectedKeywords"
        @change="handleChange(keyword.id, checked)"
        class="
          rounded
          border-gray-300
          text-indigo-600
          shadow-sm
          focus:border-indigo-300
          focus:ring
          focus:ring-indigo-200
          focus:ring-opacity-50
        "
      />
     
                                        </div>
                                    </div>
                                </td>
                                <td class="">
                                    <div class="flex items-center pl-5">
                                      <div class="flex-shrink-0 w-10 h-10 mr-5">
											<img class="w-full h-full rounded-full bg-slate-100" :src="keyword.photo_url" :alt="keyword.name">
                                        </div>
                                        
                                        <p class="text-base font-medium leading-none text-gray-700 mr-2">{{ keyword.name }}</p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M6.66669 9.33342C6.88394 9.55515 7.14325 9.73131 7.42944 9.85156C7.71562 9.97182 8.02293 10.0338 8.33335 10.0338C8.64378 10.0338 8.95108 9.97182 9.23727 9.85156C9.52345 9.73131 9.78277 9.55515 10 9.33342L12.6667 6.66676C13.1087 6.22473 13.357 5.62521 13.357 5.00009C13.357 4.37497 13.1087 3.77545 12.6667 3.33342C12.2247 2.89139 11.6251 2.64307 11 2.64307C10.3749 2.64307 9.77538 2.89139 9.33335 3.33342L9.00002 3.66676" stroke="#3B82F6" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M9.33336 6.66665C9.11611 6.44492 8.8568 6.26876 8.57061 6.14851C8.28442 6.02825 7.97712 5.96631 7.66669 5.96631C7.35627 5.96631 7.04897 6.02825 6.76278 6.14851C6.47659 6.26876 6.21728 6.44492 6.00003 6.66665L3.33336 9.33332C2.89133 9.77534 2.64301 10.3749 2.64301 11C2.64301 11.6251 2.89133 12.2246 3.33336 12.6666C3.77539 13.1087 4.37491 13.357 5.00003 13.357C5.62515 13.357 6.22467 13.1087 6.66669 12.6666L7.00003 12.3333" stroke="#3B82F6" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </div>
                                </td>
                                <td class="pl-24">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path d="M9.16667 2.5L16.6667 10C17.0911 10.4745 17.0911 11.1922 16.6667 11.6667L11.6667 16.6667C11.1922 17.0911 10.4745 17.0911 10 16.6667L2.5 9.16667V5.83333C2.5 3.99238 3.99238 2.5 5.83333 2.5H9.16667" stroke="#52525B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <circle cx="7.50004" cy="7.49967" r="1.66667" stroke="#52525B" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></circle>
                                        </svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2">{{ keyword.group?.name }}</p><span class="inline-block w-2 h-2 rounded-full ml-2" :class="[keyword.group?.groupColor]"></span>
                                    </div>
                                </td>
                                <td class="pl-5">
                                    <div class="flex items-center">
                                      <svg aria-label="Calendar" width="20" height="20" viewBox="0 0 24 24"><path fill="none" stroke="#000" stroke-width="1" d="M2 5h20v17H2V5zm16 0V1M6 5V1m-4 9h20"></path></svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2">{{ new Date(keyword.created_at).toLocaleString("en-GB",{ dateStyle: 'medium' }) }}</p>
                                    </div>
                                </td>

                                <td class="pl-5">
                                    <button class="py-3 px-3 text-sm focus:outline-none leading-none text-red-700 bg-red-100 rounded">Disabled</button>
                                </td>
                                <td class="pl-4">
                                    <button class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none">View / Edit</button>
                                </td>
                            </tr>
                            <tr class="h-3"></tr>
  <!-- Delete Token Confirmation Modal -->
  <ConfirmationModal
    :show="keywordBeingDeleted != null"
    @close="keywordBeingDeleted = null"
  >
    <template #title> Delete keyword </template>

    <template #content>
      Are you sure you would like to delete this keyword?
    </template>

    <template #footer>
      <SecondaryButton @click="keywordBeingDeleted = null">
        Cancel
      </SecondaryButton>

      <DangerButton
        class="ml-3"
        :class="{ 'opacity-25': deletekeywordForm.processing }"
        :disabled="deletekeywordForm.processing"
        @click="deletekeyword"
      >
        Delete
      </DangerButton>
    </template>
  </ConfirmationModal>
</template>