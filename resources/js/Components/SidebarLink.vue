<script setup>
defineProps({
    routeName: String,
    componentName: String,
    icon: String // Add icon as a prop
});
</script>

<template>
    <Link
        :href="route(routeName)"
        class="flex items-center px-3 py-2 rounded-lg text-white hover:bg-slate-700 no-underline"
        :class="{'bg-slate-700 text-white': $page.component === componentName}"
    >
        <!-- Display the icon dynamically -->
        <i :class="icon" class="mr-2"></i>
        <slot />
    </Link>
</template>
