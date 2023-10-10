<script setup>
import NavLink from '@/Components/NavLink.vue';
import {Disclosure,DisclosureButton,DisclosurePanel} from '@headlessui/vue'
import {ChevronDownIcon} from '@heroicons/vue/24/outline';

const props = defineProps({
    item: Object,
})
// this is done because we need to split the current path because it's like this groups.index and for ziggy it needs to be groups* if you want to watch for any route in to groups
let link = props.item.href.split('.')[0]
let newLink = link+'*'
</script>
<template>
    <NavLink v-if="item.children && !item.children.length" :href="route(item.href)" :active="route().current(newLink)">
        <component
        :class="['w-6 h-6 mr-2 shrink-0']"
        :is="item.icon" v-if="item.icon"></component>
        <span>{{ item.label }}</span>
    </NavLink>
    <Disclosure v-else>
        <DisclosureButton class="flex w-full text-left items-center px-6 py-3 border-r-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-green-50 focus:outline-none focus:text-gray-700 focus:border-green-300 transition">
            <component
            :class="['w-6 h-6 mr-2 shrink-0']"
            :is="item.icon"
            v-if="item.icon">
            </component>
            <span class="flex-1">{{ item.label }}</span>
            <ChevronDownIcon :class="['w-6 h-6 shrink-0 ']"/>
        </DisclosureButton>
        <DisclosurePanel class="">
            <div class="" v-if="item.childern.length">
                <NavItem v-for="child in item.childern" :key="child.label" :item="child" />
            </div>
        </DisclosurePanel>
  </Disclosure>


</template>
