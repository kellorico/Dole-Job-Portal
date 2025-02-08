<script setup>
import { usePage } from "@inertiajs/vue3";
import NavLink from "../Components/NavLink.vue";
import { computed, ref, onMounted, onUnmounted } from "vue";
import { Link } from "@inertiajs/vue3"; // Ensure Link is imported
import SidebarLink from "@/Components/SidebarLink.vue";

const { url } = usePage();
const page = usePage();
const user = computed(() => page.props.auth.user);

const show = ref(false);

// Toggle dropdown visibility
const toggleDropdown = () => {
    show.value = !show.value;
};

// Close dropdown if clicked outside
const closeDropdown = (event) => {
    if (!event.target.closest(".relative")) {
        show.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", closeDropdown);
});

onUnmounted(() => {
    document.removeEventListener("click", closeDropdown);
});
</script>

<template>
    <!-- Overlay for closing the dropdown when clicked outside -->
    <div v-show="show" @click="show = false" class="fixed inset-0 z-40"></div>

    <!-- Header -->
    <header class="bg-white text-black shadow-md fixed top-0 left-0 right-0 z-50">
        <nav class="container mx-auto flex items-center justify-between p-4">
            <Link
                :href="route('welcome')"
                class="flex items-center text-blue-800 font-bold text-lg no-underline"
            >
                <img
                    src="/components/img/logo.png"
                    alt="DOLE Logo"
                    class="w-12 mr-3"
                />
                DOLE Job Portal
            </Link>
            <div
                class="flex items-center space-x-1 text-blue-800 font-semibold text-sm"
            >
                <!-- User Dropdown -->
                <div v-if="user" class="relative">
                    <div
                        @click="toggleDropdown"
                        class="flex items-center gap-2 px-3 py-1 rounded-lg hover:bg-slate-700 hover:text-white cursor-pointer"
                        :class="{ 'bg-slate-700 text-white': show }"
                    >
                        <p>{{ user.username }}</p>
                        <i class="fa-solid fa-angle-down"></i>
                    </div>

                    <!-- User dropdown menu -->
                    <div
                        v-show="show"
                        class="absolute z-50 top-full mt-2 right-0 bg-white shadow-md text-gray-700 rounded-lg py-2 w-40"
                    >
                        <Link
                            :href="route('profile.edit')"
                            class="block px-6 py-3 no-underline hover:bg-slate-200 text-left"
                            >Profile</Link
                        >
                        <Link
                            :href="route('dashboard')"
                            class="block px-6 py-3 no-underline hover:bg-slate-200 text-left"
                            >Dashboard</Link
                        >
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="block px-6 py-3 hover:bg-slate-200 text-left"
                            >Logout</Link
                        >
                    </div>
                </div>

                <!-- Guest Links (Login/Register) -->
                <div v-else class="space-x-6">
                    <NavLink routeName="login" componentName="Auth/Login"
                        >Login</NavLink
                    >
                    <NavLink routeName="register" componentName="Auth/Register"
                        >Register</NavLink
                    >
                </div>
            </div>
        </nav>
    </header>

    <!-- Layout -->
    <div class="flex pt-16">
        <!-- Sidebar -->
        <aside
            v-if="user && !url.includes('/profile')"
            class="h-screen w-1/4 bg-blue-900 text-white p-6 fixed top-20"
        >
            <h5 class="uppercase font-bold mb-6">Menu</h5>
            <ul class="space-y-4">
                <li>
                    <SidebarLink
                        routeName="dashboard"
                        componentName="Dashboard"
                        icon="fas fa-briefcase"
                    >
                        Matches Job
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        routeName="findjobs"
                        componentName="FindJobs"
                        icon="fas fa-search"
                    >
                        Find Jobs
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        routeName="savejobs"
                        componentName="SaveJobs"
                        icon="fas fa-bookmark"
                    >
                        Saved Jobs
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        routeName="jobapplication"
                        componentName="JobApplication"
                        icon="fas fa-file-alt"
                    >
                        Job Applications
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        routeName="jobinvitation"
                        componentName="JobInvitation"
                        icon="fas fa-user-plus"
                    >
                        Job Invitations
                    </SidebarLink>
                </li>
                <li>
                    <SidebarLink
                        routeName="news"
                        componentName="News"
                        icon="fas fa-newspaper"
                    >
                        News
                    </SidebarLink>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main
            class="p-6 mx-auto max-w-screen-lg ml-auto"
            :class="{ 'w-3/4': user && !url.includes('/profile') }"
        >
            <slot />
        </main>
    </div>
</template>
