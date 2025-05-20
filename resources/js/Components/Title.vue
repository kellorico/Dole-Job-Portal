<script setup>
defineProps({
    size: {
        type: String,
        default: 'lg',
        validator: (value) => ['sm', 'md', 'lg', 'xl'].includes(value)
    },
    align: {
        type: String,
        default: 'left',
        validator: (value) => ['left', 'center', 'right'].includes(value)
    },
    color: {
        type: String,
        default: 'default',
        validator: (value) => ['default', 'primary', 'secondary', 'muted'].includes(value)
    }
})
</script>

<template>
    <h1 
        :class="[
            'font-bold tracking-tight',
            {
                'text-xl': size === 'sm',
                'text-2xl': size === 'md',
                'text-3xl': size === 'lg',
                'text-4xl': size === 'xl',
                'text-left': align === 'left',
                'text-center': align === 'center',
                'text-right': align === 'right',
                'text-gray-900 dark:text-white': color === 'default',
                'text-blue-600 dark:text-blue-400': color === 'primary',
                'text-gray-600 dark:text-gray-400': color === 'secondary',
                'text-gray-500 dark:text-gray-500': color === 'muted'
            }
        ]"
    >
        <slot/>
    </h1>
</template>
