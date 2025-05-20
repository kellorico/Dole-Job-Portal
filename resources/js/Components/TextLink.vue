<script setup>
defineProps({
    routeName: String,
    label: String,
    variant: {
        type: String,
        default: 'primary',
        validator: (value) => ['primary', 'secondary', 'danger'].includes(value)
    },
    size: {
        type: String,
        default: 'md',
        validator: (value) => ['sm', 'md', 'lg'].includes(value)
    }
})
</script>

<template>
    <Link 
        :href="route(routeName)" 
        class="inline-flex items-center transition-colors duration-200 font-medium
               hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
               rounded-sm"
        :class="[
            {
                'text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300': variant === 'primary',
                'text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300': variant === 'secondary',
                'text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300': variant === 'danger',
                'text-sm': size === 'sm',
                'text-base': size === 'md',
                'text-lg': size === 'lg'
            }
        ]"
    >
        {{ label }}
    </Link>
</template>
