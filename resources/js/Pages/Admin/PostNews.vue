<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const props = defineProps({
    categories: Array
});

const form = useForm({
    news_title: '',
    category_id: '',
    publish_date: '',
    image: null,
    tags: '',
    content: '',
});

const imagePreview = ref(null);

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submitForm = () => {
    const formData = new FormData();
    formData.append('news_title', form.news_title);
    formData.append('category_id', form.category_id);
    formData.append('publish_date', form.publish_date);
    formData.append('tags', form.tags);
    formData.append('content', form.content);

    if (form.image) {
        formData.append('image', form.image);
    }

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
            imagePreview.value = null;
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

const formatDate = (date) => {
    return new Date(date).toISOString().split('T')[0];
};
</script>

<template>
    <AdminLayout>
        <div class="mt-8 max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-gray-700">Post a News</h3>
                <Link
                    :href="route('admin.dashboard')"
                    class="px-4 py-2 bg-blue-600 text-white no-underline text-sm font-medium rounded hover:bg-blue-700"
                >
                    Back to Dashboard
                </Link>
            </div>

            <form @submit.prevent="submitForm" class="space-y-6">
                <!-- News Title -->
                <div>
                    <label for="newsTitle" class="block text-sm font-medium text-gray-700">News Title</label>
                    <input
                        type="text"
                        id="newsTitle"
                        v-model="form.news_title"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter news title"
                        :class="{ 'border-red-500': form.errors.news_title }"
                    />
                    <p v-if="form.errors.news_title" class="mt-1 text-sm text-red-600">{{ form.errors.news_title }}</p>
                </div>

                <!-- News Category -->
                <div>
                    <label for="newsCategory" class="block text-sm font-medium text-gray-700">News Category</label>
                    <select
                        id="newsCategory"
                        v-model="form.category_id"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.category_id }"
                    >
                        <option value="" disabled>Select a category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </option>
                    </select>
                    <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-600">{{ form.errors.category_id }}</p>
                </div>

                <!-- Publish Date -->
                <div>
                    <label for="publishDate" class="block text-sm font-medium text-gray-700">Publish Date</label>
                    <input
                        type="date"
                        id="publishDate"
                        v-model="form.publish_date"
                        :min="formatDate(new Date())"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': form.errors.publish_date }"
                    />
                    <p v-if="form.errors.publish_date" class="mt-1 text-sm text-red-600">{{ form.errors.publish_date }}</p>
                </div>

                <!-- Featured Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Featured Image</label>
                    <div class="mt-2 flex items-center space-x-4">
                        <div class="relative">
                            <img
                                v-if="imagePreview"
                                :src="imagePreview"
                                alt="Preview"
                                class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300"
                            />
                            <div
                                v-else
                                class="w-32 h-32 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center"
                            >
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                            <label
                                for="featuredImage"
                                class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700"
                            >
                                <i class="fas fa-camera"></i>
                            </label>
                            <input
                                type="file"
                                id="featuredImage"
                                class="hidden"
                                accept="image/*"
                                @change="handleImageUpload"
                            />
                        </div>
                        <p class="text-sm text-gray-500">Click the camera icon to upload an image</p>
                    </div>
                    <p v-if="form.errors.image" class="mt-1 text-sm text-red-600">{{ form.errors.image }}</p>
                </div>

                <!-- Tags -->
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                    <input
                        type="text"
                        id="tags"
                        v-model="form.tags"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter tags (comma-separated)"
                        :class="{ 'border-red-500': form.errors.tags }"
                    />
                    <p v-if="form.errors.tags" class="mt-1 text-sm text-red-600">{{ form.errors.tags }}</p>
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea
                        id="content"
                        v-model="form.content"
                        rows="8"
                        class="mt-2 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter news content"
                        :class="{ 'border-red-500': form.errors.content }"
                    ></textarea>
                    <p v-if="form.errors.content" class="mt-1 text-sm text-red-600">{{ form.errors.content }}</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <button
                        type="button"
                        @click="form.reset()"
                        class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition"
                    >
                        Reset
                    </button>
                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Posting...</span>
                        <span v-else>Post News</span>
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
