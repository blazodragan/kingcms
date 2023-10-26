<script setup>
import ToastListItem from "@/Components/ToastListItem.vue";
import {onUnmounted, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import { router } from '@inertiajs/vue3'
import toast from "@/Stores/toast"
 
const page = usePage();
 


let removeFinishEventListener = router.on("finish", () => {
  console.log(toast);
  if (page.props.toast) {
    
    toast.add({
      message: page.props.toast.message,
      duration: page.props.toast.duration,
      type: page.props.toast.type,
    });
  }
});

// Event listener to clear toasts on navigation start
let removeStartEventListener = router.on("start", () => {
  toast.items = [];  // Clear out the toasts
});
 
onUnmounted(() => {
  removeFinishEventListener();
  removeStartEventListener();
});
 
function remove(index) {
  toast.remove(index);
  page.props.toast = null;
}
</script>
<template>
  <!-- Only render this container if there are toast messages -->  
  <TransitionGroup
    tag="div"
    enter-from-class="translate-x-full opacity-0"
    enter-active-class="duration-500"
    leave-active-class="duration-500"
    leave-to-class="translate-x-full opacity-0"
    class="fixed top-3 right-3 z-50 w-full max-w-xs space-y-4">
    <div v-if="toast.items && toast.items.length > 0" class="toast-container">
    <ToastListItem
      v-for="(item, index) in toast.items"
      :key="item.key"
      :message="item.message"
      :duration="item.duration"
      :type="item.type"
      @remove="remove(index)"
    />
  </div>  
  </TransitionGroup>

</template>