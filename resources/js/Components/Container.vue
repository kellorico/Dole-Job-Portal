<script setup>
defineProps({
    maxWidth: {
        type: String,
        default: '7xl',
        validator: (value) => ['sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'].includes(value)
    },
    padding: {
        type: String,
        default: 'lg',
        validator: (value) => ['none', 'sm', 'md', 'lg', 'xl'].includes(value)
    }
})
</script>

<template>
    <div 
        :class="[
            'mx-auto w-full bg-white dark:bg-gray-800 rounded-xl shadow-sm',
            'border border-gray-100 dark:border-gray-700',
            {
                'max-w-sm': maxWidth === 'sm',
                'max-w-md': maxWidth === 'md',
                'max-w-lg': maxWidth === 'lg',
                'max-w-xl': maxWidth === 'xl',
                'max-w-2xl': maxWidth === '2xl',
                'max-w-3xl': maxWidth === '3xl',
                'max-w-4xl': maxWidth === '4xl',
                'max-w-5xl': maxWidth === '5xl',
                'max-w-6xl': maxWidth === '6xl',
                'max-w-7xl': maxWidth === '7xl',
                'p-0': padding === 'none',
                'p-4': padding === 'sm',
                'p-6': padding === 'md',
                'p-8': padding === 'lg',
                'p-12': padding === 'xl'
            }
        ]"
    >
        <slot/>
    </div>
</template>
