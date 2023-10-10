<script setup>
import { ref, computed, watch } from "vue";
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm, Head, router } from "@inertiajs/vue3";

const props = defineProps({
  invoice: "",
  allSelectedMerchants: "",
});

const emit = defineEmits(["add", "remove", "reset"]);
const checked = ref(false);

const handleChange = (id, checked) => {
  if (checked == true) {
    console.log(id);
    emit("add", id);
  } else {
    emit("remove", id);
  }
};

watch(
  () => props.allSelectedMerchants,
  () => {
    if (props.allSelectedMerchants == true) {
      checked.value = true;
      emit("add", props.invoice.id);
    } else {
      checked.value = false;
      emit("remove", props.invoice.id);
    }
  }
);
</script>
<template>
    <tr :class="{'bg-red-50': checked,'bg-white': !checked}">
    <td scope="row"
                    class="
                      py-4
                      px-6
                      font-medium
                      text-gray-900
                      whitespace-nowrap
                      dark:text-white
                    ">

                    <input
          type="checkbox"
          :value="invoice.id"
          v-model="checked"
          :checked="allSelectedMerchants"
          id="{{ invoice.id }}"
          @change="handleChange(invoice.id, checked)"
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

</td>
<td class="px-6 py-4" >
    {{ invoice.id }}
</td>
<td class="px-6 py-4">
    {{ invoice.name }}
</td>
<td class="px-6 py-4">
    {{ invoice.merchant_finance_code }}
</td>
<td class="px-6 py-4">
    {{ invoice.contacts }}
</td>
</tr>
</template>