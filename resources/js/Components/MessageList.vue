<script setup>
import { ref, computed, watch } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";

const props = defineProps({
  message: "",
  allSelectedMessages:""
});

const emit = defineEmits(["add", "remove", "reset"]);
const checked = ref(false);
const messageBeingDeleted = ref(null);
const deletemessageForm = useForm();



const confirmmessageDeletion = (id) => {
  messageBeingDeleted.value = id;
};

const deletemessage = () => {
  deletemessageForm.delete(route("messages.destroy", messageBeingDeleted.value),{
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => (messageBeingDeleted.value = null),
  });
};
const handleChange = (id, checked) => {
  if (checked == true) {
    console.log(id);
    emit("add", id);
  } else {
    emit("remove", id);
  }
};

watch(
  () => props.allSelectedMessages,
  () => {
    if (props.allSelectedMessages == true) {
      checked.value = true;
      emit("add", props.message.id);
    } else {
      checked.value = false;
      emit("remove", props.message.id);
    }
  }
);

</script>

<template>


  <tr class="bg-white border-b hover:bg-gray-50"
  :class="{
      'bg-green-50': checked,
    }"
  >
    <th
                    scope="row"
                    class="
                      py-4
                      px-6
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                      dark:text-white
                    "
                  >
                  <input
                  type="checkbox"
          :value="message.id"
          v-model="checked"
          :checked="allSelectedMessages"
          id="{{ message.id }}"
          @change="handleChange(message.id, checked)"
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
                  </th>

                  <th
                    scope="row"
                    class="
                      py-2
                      px-4
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                      dark:text-white
                    "
                  >
                  <div class="flex-shrink-0 w-10 h-10 ">
											<img class="w-full h-full rounded-full bg-slate-100" :src="message.photo_url" :alt="message.name">
                                        </div>
                  </th>
                  <td class="py-2 px-4"> {{message.name}} </td>
                  <td class="py-2 px-4">
                    <span v-if="message.status" class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">Enabled</span>
                    <span v-else class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-200 dark:text-red-900">Disabled</span>

                  </td>
                  <td class="py-2 px-4">{{ new Date(message.created_at).toLocaleString("en-GB",{ dateStyle: 'medium' }) }}</td>
                  <td class="py-2 px-4 text-right">
                    <div class="whitespace-no-wrap flex">
                      <Link :href="`/messages/${message.id}/edit`" tabindex="-1" class="py-2 px-2 rounded bg-gray-100 mr-4 hover:bg-gray-200 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-200"
        >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
        </Link>

                          <button @click="confirmmessageDeletion(message.id)" class="py-2 px-2 rounded bg-gray-100 hover:bg-gray-200 focus:outline-none focus:border-gray-700 focus:ring focus:ring-gray-200 active:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </button>
                          </div>
                          </td>




  </tr>

  <!-- Delete Token Confirmation Modal -->
  <ConfirmationModal
    :show="messageBeingDeleted != null"
    @close="messageBeingDeleted = null"
  >
    <template #title> Delete message </template>

    <template #content>
      Are you sure you would like to delete this message?
    </template>

    <template #footer>
      <SecondaryButton @click="messageBeingDeleted = null">
        Cancel
      </SecondaryButton>

      <DangerButton
        class="ml-3"
        :class="{ 'opacity-25': deletemessageForm.processing }"
        :disabled="deletemessageForm.processing"
        @click="deletemessage"
      >
        Delete
      </DangerButton>
    </template>
  </ConfirmationModal>
</template>
