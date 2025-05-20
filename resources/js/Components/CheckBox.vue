<script setup>
const model = defineModel();

defineProps({
    name: String,
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    error: {
        type: String,
        default: ''
    }
});
</script>

<template>
    <div class="flex items-start gap-3">
        <div class="flex items-center h-5">
            <input 
                type="checkbox"
                v-model="model"
                :id="name"
                :disabled="disabled"
                :required="required"
                :aria-invalid="!!error"
                :aria-describedby="error ? `${name}-error` : undefined"
                class="h-4 w-4 rounded border-gray-300 text-blue-600 
                       focus:ring-2 focus:ring-blue-500 focus:ring-offset-0
                       disabled:opacity-50 disabled:cursor-not-allowed
                       dark:border-gray-600 dark:bg-gray-800
                       transition-colors duration-200"
            />
        </div>
        <div class="flex flex-col gap-1">
            <label 
                :for="name"
                class="text-sm font-medium text-gray-700 dark:text-gray-200 
                       cursor-pointer select-none"
            >
                <slot/>
                <span v-if="required" class="text-red-500 ml-0.5">*</span>
            </label>
            <p 
                v-if="error"
                :id="`${name}-error`"
                class="text-sm text-red-600 dark:text-red-400"
            >
                {{ error }}
            </p>
        </div>
    </div>
</template>
