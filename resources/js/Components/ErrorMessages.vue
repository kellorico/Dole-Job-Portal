<script setup>
defineProps({
    errors: Object,
    title: {
        type: String,
        default: 'Please fix the following errors:'
    }
})
</script>

<template>
    <div 
        v-if="Object.keys(errors).length"
        class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20
               border border-red-200 dark:border-red-800
               animate-fade-in"
    >
        <div class="flex items-center gap-2 mb-2">
            <i class="fa-solid fa-circle-exclamation text-red-500"></i>
            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                {{ title }}
            </h3>
        </div>
        
        <ul class="ml-6 space-y-1">
            <li 
                v-for="(error, index) in errors" 
                :key="index"
                class="text-sm text-red-700 dark:text-red-300
                       flex items-center gap-2"
            >
                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                {{ error }}
            </li>
        </ul>
    </div>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
