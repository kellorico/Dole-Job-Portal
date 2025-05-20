<script setup>
defineProps({
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
    <button 
        :class="[
            'font-medium transition-all duration-200 ease-in-out transform hover:scale-[1.02] active:scale-[0.98]',
            {
                'bg-blue-600 hover:bg-blue-700 text-white': variant === 'primary',
                'bg-gray-200 hover:bg-gray-300 text-gray-800': variant === 'secondary',
                'bg-red-600 hover:bg-red-700 text-white': variant === 'danger',
                'px-4 py-1.5 text-sm': size === 'sm',
                'px-6 py-2.5': size === 'md',
                'px-8 py-3 text-lg': size === 'lg'
            },
            'rounded-lg shadow-sm hover:shadow-md disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100'
        ]"
    >
        <slot/>
    </button>
</template>
