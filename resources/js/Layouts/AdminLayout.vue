<script setup>
import { ref } from 'vue';
import SidebarLink from '@/Components/SidebarLink.vue';

// Reactive state for dropdown visibility
const isDropdownOpen = ref(false);

// Function to toggle dropdown
const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};
</script>

<template>
  <div class="flex">
    <!-- Sidebar -->
    <nav class="w-64 bg-black text-white h-screen fixed">
      <div class="p-4">
        <div class="text-center mb-6">
          <img src="/components/img/logo.png" alt="DOLE Logo" class="mx-auto w-12">
          <h1 class="text-sm mt-2">Department Of Labor and Employment</h1>
          <hr class="border-gray-600 my-4">
        </div>
        <ul class="space-y-4">
          <li>
            <SidebarLink routeName="admin.dashboard" componentName="Admin/Dashboard">
              <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </SidebarLink>
          </li>
          <li>
            <SidebarLink routeName="admin.jobs" componentName="Admin/Jobs">
              <i class="fas fa-briefcase mr-3"></i> Jobs
            </SidebarLink>
          </li>
          <li>
            <SidebarLink routeName="news-create" componentName="Admin/PostNews">
              <i class="fas fa-newspaper mr-3"></i> Post a News
            </SidebarLink>
          </li>
          <li>
            <SidebarLink routeName="admin.jobs.create" componentName="Admin/JobPost">
              <i class="fas fa-paper-plane mr-3"></i> Job Posting
            </SidebarLink>
          </li>
          <li>
            <SidebarLink routeName="admin-create" componentName="Admin/AddAdmin">
              <i class="fas fa-plus mr-3"></i> Add New Admin
            </SidebarLink>
          </li>
        </ul>
        <hr class="border-gray-600 my-6">
        <div class="text-center">
          <p>Login as:</p>
          <img src="/components/img/logo.png" alt="User" class="rounded-full w-10 h-10 mx-auto">
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="ml-64 flex-1">
      <!-- Header -->
      <header class="bg-black text-white py-4 px-6 flex justify-between items-center">
        <div class="w-1/3">
          <input type="text" class="w-full p-2 rounded border text-black border-gray-300" placeholder="Search...">
        </div>
        <div class="relative">
          <!-- Dropdown Toggle -->
          <img
            src="/components/img/background.png"
            alt="profile"
            class="w-12 h-12 rounded-full cursor-pointer"
            @click="toggleDropdown"
          >
          <!-- Dropdown Menu -->
          <ul
            v-if="isDropdownOpen"
            class="absolute right-0 mt-2 bg-white text-black rounded shadow-lg"
          >
            <li>
              <Link :href="route('admin.profile')" class="block px-4 py-2 text-black no-underline hover:bg-gray-100">Profile</Link>
            </li>
            <li>
              <Link :href="route('settings')" class="block px-4 py-2 text-black no-underline hover:bg-gray-100">Settings</Link>
            </li>
            <li>
              <Link :href="route('logout')"
                method="post"
                as="button"
               class="block px-4 py-2 text-black no-underline hover:bg-gray-100">Logout</Link>
            </li>
          </ul>
        </div>
      </header>

      <!-- Dashboard Metrics -->
      <slot />
    </div>
  </div>
</template>
