<script setup>
defineProps({
    status: String,
    type: {
        type: String,
        default: 'success',
        validator: (value) => ['success', 'info', 'warning'].includes(value)
    }
})
</script>

<template>
    <div 
        v-if="status"
        class="mb-6 p-4 rounded-lg animate-fade-in"
        :class="{
            'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800': type === 'success',
            'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800': type === 'info',
            'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800': type === 'warning'
        }"
    >
        <div class="flex items-center gap-2">
            <i 
                :class="[
                    'text-lg',
                    {
                        'fa-solid fa-circle-check text-green-500': type === 'success',
                        'fa-solid fa-circle-info text-blue-500': type === 'info',
                        'fa-solid fa-triangle-exclamation text-yellow-500': type === 'warning'
                    }
                ]"
            ></i>
            <p 
                class="text-sm font-medium"
                :class="{
                    'text-green-800 dark:text-green-200': type === 'success',
                    'text-blue-800 dark:text-blue-200': type === 'info',
                    'text-yellow-800 dark:text-yellow-200': type === 'warning'
                }"
            >
                {{ status }}
            </p>
        </div>
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
