<script setup>
const model = defineModel();
defineProps({
    label: String,
    icon: String,
    placeholder: {
        type: String,
        default: '',
    },
    type: {
        type: String,
        default: 'text',
    },
    error: {
        type: String,
        default: '',
    },
    required: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <div class="w-full">
        <label
            :for="label"
            class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1.5"
        >
            {{ label }}
            <span v-if="required" class="text-red-500 ml-0.5">*</span>
        </label>

        <div class="relative">
            <div 
                v-if="icon"
                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
            >
                <span class="text-gray-400 dark:text-gray-500">
                    <i :class="`fa-solid fa-${icon}`"></i>
                </span>
            </div>
            <input 
                :type="type"
                :name="label"
                :placeholder="placeholder"
                v-model="model"
                :required="required"
                :aria-invalid="!!error"
                :aria-describedby="error ? `${label}-error` : undefined"
                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 
                       bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100
                       shadow-sm transition-all duration-200
                       placeholder:text-gray-400 dark:placeholder:text-gray-500
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                       disabled:bg-gray-100 dark:disabled:bg-gray-700
                       disabled:cursor-not-allowed
                       pl-9 pr-3 py-2.5 text-sm"
            >
        </div>
        
        <p 
            v-if="error"
            :id="`${label}-error`"
            class="mt-1.5 text-sm text-red-600 dark:text-red-400"
        >
            {{ error }}
        </p>
    </div>
</template>
