<script setup>
import { ref,onMounted, onUnmounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Banner from '@/Components/Banner.vue';
import Toastmessage from '@/Components/Toastmessage.vue';
import Dropdown from '@/Components/Dropdown.vue';
import {usePage} from "@inertiajs/vue3";
import DropdownLink from '@/Components/DropdownLink.vue';
import GlobalSearch from '@/Components/GlobalSearch.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NavItem from '@/Components/NavItem.vue';
import {HomeIcon, DocumentTextIcon, NewspaperIcon, StarIcon, TagIcon, Cog6ToothIcon, DocumentIcon, UserCircleIcon, FolderIcon, BuildingStorefrontIcon, LanguageIcon, ChatBubbleOvalLeftIcon, MicrophoneIcon} from '@heroicons/vue/24/outline';
import ToastList from "@/Components/ToastList.vue";



const props = defineProps({
    title: String,
results: {
    type: Array,
    }
});

const page = usePage();


// Navigation Menu
const mainNavItems = [
    {href:"pages.index", label: "Pages", children: [], icon: DocumentIcon, permission: 'sanctum'},
    {href:"posts.index", label: "Posts", children: [], icon: MicrophoneIcon, permission: 'sanctum'},
    {href:"news.index", label: "News", children: [], icon: NewspaperIcon, permission: 'sanctum'},
    {href:"reviews.index", label: "Reviews", children: [], icon: StarIcon, permission: 'sanctum'},
    {href:"categories.index", label: "Categories", children: [], icon: TagIcon, permission: 'sanctum'},
    {href:"trust_reviews.index", label: "Trust Reviews", children: [], icon: ChatBubbleOvalLeftIcon, permission: 'sanctum'},
    {href:"media.index", label: "Media", children: [], icon: FolderIcon, permission: 'sanctum'},
    {href:"blocks.index", label: "Blocks", children: [], icon: BuildingStorefrontIcon, permission: 'sanctum'},
    // {href:"dashboard", label: "Home", childern: [], icon: HomeIcon},
]


const allNavItems = [
    {href:"users.index", label: "Users", children: [], icon: UserCircleIcon, permission: 'sanctum'},
    {href:"settings.index", label: "Settings", children: [], icon: Cog6ToothIcon, permission: 'sanctum.settings.edit'},
    {href:"translations.index", label: "Translations", children: [], icon: LanguageIcon, permission: 'sanctum.settings.edit'},

    {href:"permissions.index", label: "Permissions", children: [], icon: DocumentTextIcon, permission: 'sanctum.permission.index'},
    {href:"profile.show", label: "Profile", children: [], icon: UserCircleIcon, permission: 'sanctum'},
];




const followingNavItems = allNavItems.filter(item => page.props.premit.includes(item.permission));


const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};


const goToDashboard = (e) => {
  if (e.key === "1" && (e.altKey || e.metaKey)) {
    router.get(route('dashboard'));
  }
};
const goToGroup = (e) => {
  if (e.key === "2" && (e.altKey || e.metaKey)) {
    router.get(route('groups.index'));
  }
};
const goToKeywords = (e) => {
  if (e.key === "3" && (e.altKey || e.metaKey)) {
    router.get(route('keywords.index'));
  }
};
onMounted(
  () => document.addEventListener("keydown", goToDashboard),document.addEventListener("keydown", goToGroup),document.addEventListener("keydown", goToKeywords)

);

onUnmounted(() => {
  document.removeEventListener("keydown", goToDashboard),document.removeEventListener("keydown", goToGroup),document.removeEventListener("keydown", goToKeywords)
});
</script>

<template>
    <ToastList/>
    <div class="flex min-h-screen">
        <Head :title="props.title" />

        <div class="hidden sm:block w-64 shrink-0 bg-white-50 my-shadow border-r border-gray-200 py-4">
            <div class="shrink-0 flex items-center ml-6">
                                <Link :href="route('dashboard')">
                                </Link>
                            </div>
            
            <nav class="mt-8">
                <div class="mb-5">
                    <h3 class="mx-6 mb-2 text-sm text-gray-400 uppercase tracking-widest">Main</h3>
                    <NavItem :item="item" v-for="item in mainNavItems" :key="item.label"></NavItem>
                </div>

                <div class="mb-5">
                    <h3 class="mx-6 mb-2 text-sm text-gray-400 uppercase tracking-widest">Personal</h3>
                    <NavItem :item="item" v-for="item in followingNavItems" :key="item.label"></NavItem>
                </div>
            </nav>
        </div>
        <div class="flex-1 flex flex-col min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between py-6 space-x-6">
                        <GlobalSearch :results="results"/>
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                    Team Settings
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                    Create New Team
                                                </DropdownLink>

                                                <div class="border-t border-gray-100" />

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                    <form @submit.prevent="switchToTeam(team)">
                                                        <DropdownLink as="button">
                                                            <div class="flex items-center">
                                                                <svg
                                                                    v-if="team.id == $page.props.auth.user.current_team_id"
                                                                    class="mr-2 h-5 w-5 text-green-400"
                                                                    fill="none"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </DropdownLink>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-100" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink>
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200" />

                                <!-- Team Switcher -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Switch Teams
                                </div>

                                <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="team.id == $page.props.auth.user.current_team_id"
                                                    class="mr-2 h-5 w-5 text-green-400"
                                                    fill="none"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                ><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white">
                <div class="flex items-center justify-between max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <Banner />
                <Toastmessage />
                <slot />
            </main>
                        <!-- Page Heading -->
            <footer class="bg-white mt-auto">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 md:flex md:items-center md:justify-between md:p-6">
                    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2022 <a href="https://mietwagenparadies.de/" class="hover:underline">mietwagenparadies.com™</a>. All Rights Reserved.
    </span>
    <ul class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
        <li>
            <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
        </li>
    </ul>
                </div>
            </footer>
        </div>
    </div>
</template>
