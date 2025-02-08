<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    categories: Array // List of categories passed from the server
});

// Initialize form data
const form = useForm({
    news_title: '',        // News title
    category: '',       // Selected category
    publish_date: '',      // Publish date
    image: null,           // Uploaded image
    tags: '',              // Tags for the news
    content: ''            // Content of the news
});

// Submit the form
const submitForm = () => {
    const formData = new FormData();
    formData.append('news_title', form.news_title);
    formData.append('category', form.category);
    formData.append('publish_date', form.publish_date);
    formData.append('tags', form.tags);
    formData.append('content', form.content);

    // If an image is selected, append it to formData
    if (form.image) {
        formData.append('image', form.image);
    }

    // Send the form data with the image
    form.post('/admin/news/store', {
        body: formData,
        preserveScroll: true,
        onSuccess: () => {
            Swal.fire({
                title: 'Success!',
                text: 'News posted successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
            });
            form.reset();
        },
        onError: () => {
            Swal.fire({
                title: 'Error!',
                text: 'Failed to post news. Please check the highlighted fields.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
        },
    });
};
</script>

<template>
    <AdminLayout>
        <div class="mt-8 max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-xl">
            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Post a News</h3>

            <form @submit.prevent="submitForm">
                <!-- News Title -->
                <div class="mb-6">
                    <label for="newsTitle" class="block text-sm font-medium text-gray-700">News Title</label>
                    <input
                        type="text"
                        id="newsTitle"
                        v-model="form.news_title"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter news title"
                        :class="{ 'border-red-500': form.errors.news_title }"
                    />
                    <div v-if="form.errors.news_title" class="text-red-500 text-xs mt-1">{{ form.errors.news_title }}</div>
                </div>

                <!-- News Category -->
                <div class="mb-6">
    <label for="newsCategory" class="block text-sm font-medium text-gray-700">News Category</label>
    <select
        id="newsCategory"
        v-model="form.category"
        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
        :class="{ 'border-red-500': form.errors.category }"
    >
        <option value="" disabled>Select a category</option>
        <option value="technology">Technology</option>
        <option value="sports">Sports</option>
        <option value="health">Health</option>
        <option value="business">Business</option>
        <option value="entertainment">Entertainment</option>
        <option value="politics">Politics</option>
        <option value="science">Science</option>
        <option value="lifestyle">Lifestyle</option>
        <option value="education">Education</option>
        <option value="travel">Travel</option>
    </select>
    <div v-if="form.errors.category" class="text-red-500 text-xs mt-1">{{ form.errors.category }}</div>
</div>

                <!-- Publish Date -->
                <div class="mb-6">
                    <label for="publishDate" class="block text-sm font-medium text-gray-700">Publish Date</label>
                    <input
                        type="date"
                        id="publishDate"
                        v-model="form.publish_date"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.publish_date }"
                    />
                    <div v-if="form.errors.publish_date" class="text-red-500 text-xs mt-1">{{ form.errors.publish_date }}</div>
                </div>

                <!-- Featured Image -->
                <div class="mb-6">
                    <label for="featuredImage" class="block text-sm font-medium text-gray-700">Featured Image</label>
                    <input
                        type="file"
                        id="featuredImage"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        @change="e => form.image = e.target.files[0]"
                    />
                </div>

                <!-- Tags -->
                <div class="mb-6">
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <input
                        type="text"
                        id="tags"
                        v-model="form.tags"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter tags"
                        :class="{ 'border-red-500': form.errors.tags }"
                    />
                    <div v-if="form.errors.tags" class="text-red-500 text-xs mt-1">{{ form.errors.tags }}</div>
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea
                        id="content"
                        v-model="form.content"
                        rows="5"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter news content"
                        :class="{ 'border-red-500': form.errors.content }"
                    ></textarea>
                    <div v-if="form.errors.content" class="text-red-500 text-xs mt-1">{{ form.errors.content }}</div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Post News
                    </button>
                    <button type="reset" @click="form.reset" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
