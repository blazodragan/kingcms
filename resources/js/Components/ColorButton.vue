<script setup>
import { computed  } from "@vue/runtime-core";



const props = defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    color: {
        type: String,
        default: 'bg-blue-600'
    }
});
const name = computed(() => {
    let str = props.color
    str = str.substring(str.indexOf("-")+1);
    str = str.substring(0,str.indexOf("-"));
    return str
});

</script>

<template>
    <button :type="props.type" class="items-center mr-1 text-gray-600 rounded ">
        <span class="inline-block w-5 h-5 rounded-full"  :class="[props.color]"></span>
    </button>
</template>
