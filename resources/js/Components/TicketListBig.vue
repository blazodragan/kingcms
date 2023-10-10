<script setup>
import { ref, computed, watch } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    ticket: "",
    allSelectedTickets: "",
});

const emit = defineEmits(["add", "remove", "reset"]);
const checked = ref(false);
const TicketBeingDeleted = ref(null);
const deleteTicketForm = useForm({});

const confirmTicketDeletion = (id) => {
    TicketBeingDeleted.value = id;
};

const deleteTicket = () => {
    deleteTicketForm.delete(("tickets.destroy", TicketBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (TicketBeingDeleted.value = null),
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
    () => props.allSelectedTickets,
    () => {
        if (props.allSelectedTickets == true) {
            checked.value = true;
            emit("add", props.ticket.id);
        } else {
            checked.value = false;
            emit("remove", props.ticket.id);
        }
    }
);
</script>

<template>
    <div
        class="col-span-1 flex flex-col bg-white drop-shadow-sm rounded-md"
        :class="{
      'border-indigo-300 ring ring-indigo-200 ring-opacity-100': checked,
    }"
    >
        <div class="flex flex-col px-4 pt-4 pb-2">
            <div class="flex flex-wrap">

                <input
                    type="checkbox"
                    :value="ticket.id"
                    v-model="checked"
                    :checked="allSelectedTickets"
                    :id="ticket.id"
                    @change="handleChange(ticket.id, checked)"
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
                <div class="flex ml-2 mb-3">
                    <span v-if="ticket.status == 'open'" class="bg-green-100  text-green-800 text-xs font-medium rounded px-3">{{ ticket.status }}</span>
                    <span v-else-if="ticket.status == 'closed'" class="bg-red-100  text-red-800 text-xs font-medium rounded px-3">{{ ticket.status }}</span>
                    <span v-else class="bg-blue-100  text-blue-800 text-xs font-medium rounded px-3">{{ ticket.status }}</span>
                </div>
                <div class="flex ml-2 mb-3">
                    <span v-if="ticket.priority == 'low'" class="bg-green-100  text-green-800 text-xs font-medium rounded px-3">{{ ticket.priority }}</span>
                    <span v-else-if="ticket.priority == 'high'" class="bg-red-100  text-red-800 text-xs font-medium rounded px-3">{{ ticket.priority }}</span>
                    <span v-else class="bg-blue-100  text-blue-800 text-xs font-medium rounded px-3">{{ ticket.priority }}</span>
                </div>

                <small class=" flex-1 text-right">{{ new Date(ticket.created_at).toLocaleString("en-GB",{ dateStyle: 'medium' }) }}</small>
                <span v-if="ticket.ticketColor" class="absolute right-1 top-1 w-2 h-2 rounded-full ml-2" :class="[ticket?.ticketColor]"></span>
            </div>

            <img
                :src="ticket.photo_url"
                :alt="ticket.name"
                class="rounded-sm h-44 w-auto object-cover"
            />
            <span class="truncate font-medium mt-2 text-xl text-center">{{ ticket.title }}</span>
        </div>
        <div
            class="
        flex flex-wrap
        bg-gray-50
        row-span-1
        w-full
        mt-auto
        text-xs
        rounded-b-md
        p-3
      "
        >
      <span class="flex-1">
        <Link
            class="
            inline-flex
            items-center
            px-4
            py-2
            bg-white
            border border-gray-300
            rounded-md
            font-semibold
            text-xs text-gray-700
            uppercase
            tracking-widest
            shadow-sm
            hover:text-gray-500
            focus:outline-none
            focus:border-blue-300
            focus:ring
            focus:ring-blue-200
            active:text-gray-800 active:bg-gray-50
            disabled:opacity-25
            transition
          "
            :href="`/tickets/${ticket.uuid}/edit`"
            tabindex="-1"
        >
          Edit / View
        </Link>
      </span>
            <span class="flex">
        <DangerButton @click="confirmTicketDeletion(ticket.id)">
          <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.236 6.149a.2.2 0 00-.197.233L6 24h12l2.96-17.618a.2.2 0 00-.196-.233H3.236zM21.8 1.983c.11 0 .2.09.2.2v1.584a.2.2 0 01-.2.2H2.2a.2.2 0 01-.2-.2V2.183c0-.11.09-.2.2-.2h5.511c.9 0 1.631-1.09 1.631-1.983h5.316c0 .894.73 1.983 1.631 1.983H21.8z" fill="#fff"></path></svg>
        </DangerButton>
      </span>
        </div>
    </div>
    <!-- Delete Token Confirmation Modal -->
    <ConfirmationModal
        :show="TicketBeingDeleted != null"
        @close="TicketBeingDeleted = null"
    >
        <template #title> Delete Ticket </template>

        <template #content>
            Are you sure you would like to delete this Ticket?
        </template>

        <template #footer>
            <SecondaryButton @click="TicketBeingDeleted = null">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ml-3"
                :class="{ 'opacity-25': deleteTicketForm.processing }"
                :disabled="deleteTicketForm.processing"
                @click="deleteTicket"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
</template>
