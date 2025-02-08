<script setup>
defineProps({
    routeName: String,
    componentName: String,
})
</script>

<template>
    <Link :href="route(routeName)" class="px-3 py-2 rounded-lg hover:bg-slate-700 hover:text-white no-underline"
    :class="{'bg-slate-700 text-white' : $page.component === componentName}">
        <slot/>
    </Link>
</template>
