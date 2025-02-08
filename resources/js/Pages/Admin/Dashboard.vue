<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, reactive } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    news: Array,
    users: Array,
    categories: Array,
    jobs: Array
});

const form = useForm({
    news_title: '',
    category_id: '',
    publish_date: '',
    image: null,
    tags: '',
    content: '',
});

const isExpanded = reactive({});

// Method to toggle content visibility
const toggleContent = (index) => {
    isExpanded[index] = !isExpanded[index];
};

const currentNewsId = ref(null);
const showModal = ref(false);

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

    if (!currentNewsId.value) {
        Swal.fire({
            title: 'Error!',
            text: 'No news selected for update.',
            icon: 'error',
            confirmButtonText: 'OK',
        });
        return;
    }

    const url = `/admin/dashboard/update/${currentNewsId.value}`;

    axios.put(url, formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
        .then(() => {
            Swal.fire({
                title: 'Success!',
                text: 'News updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK',
            });
            form.reset();
            currentNewsId.value = null;
            showModal.value = false;
        })
        .catch((error) => {
            const errors = error.response?.data?.errors || {};
            Swal.fire({
                title: 'Error!',
                text: 'Failed to update news. Please check the highlighted fields.',
                icon: 'error',
                confirmButtonText: 'OK',
            });
            form.errors = errors.response.data.errors;
        });
};

const editNews = (newsItem) => {
    form.news_title = newsItem.news_title;
    form.category_id = newsItem.category_id;
    form.publish_date = newsItem.publish_date;
    form.tags = newsItem.tags;
    form.content = newsItem.content;
    currentNewsId.value = newsItem.id;
    showModal.value = true;
};

const deleteNews = (newsId) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(`/admin/dashboard/delete/${newsId}`, {
                onSuccess: () => {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Your news has been deleted.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    });
                },
                onError: () => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete news.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                    });
                },
            });
        }
    });
};

</script>

<template>
    <AdminLayout>
        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6">
            <!-- Users Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-2xl transition duration-300">
                <i class="fas fa-users fa-3x text-blue-600 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800">Total Users</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ props.users.length }}</p>
                <Link :href="route('admin.users')" class="bg-indigo-500 hover:bg-indigo-600 text-white no-underline py-1 px-2 rounded-md">View</Link>
            </div>
            <!-- Applicants Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-2xl transition duration-300">
                <i class="fas fa-user-check fa-3x text-yellow-600 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800">Total Applicants</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">56</p>
            </div>
            <!-- Jobs Card -->
            <div class="bg-white p-6 rounded-lg shadow-lg text-center hover:shadow-2xl transition duration-300">
                <i class="fas fa-briefcase fa-3x text-green-600 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800">Total Jobs</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">{{ props.jobs.length }}</p>
            </div>
        </div>

        <!-- News Section -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-2xl font-semibold mb-4 text-center text-gray-800">What's New?</h2>
            <hr class="border-t border-gray-300 mb-4">

            <!-- No News Message -->
            <div v-if="!props.news.length" class="text-center text-gray-600">
                <p>No news available.</p>
            </div>

            <!-- News List -->
            <div v-else>
                <div v-for="(item, index) in props.news" :key="index" class="mb-6 p-6 bg-gray-50 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">{{ item.news_title }}</h3>
                            <p class="text-sm mt-2 text-gray-600">
                                <strong>Category:</strong> {{ item.category }}<br>
                                <strong>Tags:</strong> {{ item.tags }}
                            </p>
                        </div>
                        <img v-if="item.image_path" :src="`/storage/${item.image_path}`" alt="News Image" class="w-24 h-24 object-cover rounded-lg shadow-md">
                    </div>
                    <p class="text-sm mt-2 text-gray-600">
                        {{ isExpanded[index] ? item.content : item.content.substring(0, 150) + '...' }}
                        <button class="text-blue-500 ml-1" @click="toggleContent(index)">
                            {{ isExpanded[index] ? 'See less' : 'See more' }}
                        </button>
                    </p>
                    <div class="flex justify-end mt-2 space-x-2">
                        <button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition duration-200" @click="editNews(item)">Edit</button>
                        <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition duration-200" @click="deleteNews(item.id)">Delete</button>
                    </div>
                    <p class="text-sm mt-3 text-gray-500">
                       posted at <strong>{{ item.publish_date }} </strong>
                    </p>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Edit News</h3>
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <form @submit.prevent="submitForm" class="mt-4">
                    <div class="mb-4">
                        <label for="newsTitle" class="block text-sm font-medium">News Title</label>
                        <input id="newsTitle" type="text" v-model="form.news_title" class="w-full mt-1 p-2 border rounded-lg" :class="{ 'border-red-500': form.errors.news_title }">
                        <div v-if="form.errors.news_title" class="text-red-500 text-sm mt-1">{{ form.errors.news_title }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="newsCategory" class="block text-sm font-medium">News Category</label>
                        <select id="newsCategory" v-model="form.category_id" class="w-full mt-1 p-2 border rounded-lg" :class="{ 'border-red-500': form.errors.category_id }">
                            <option value="" disabled>Select a category</option>
                            <option v-for="category in props.categories" :key="category.id" :value="category.id">{{ category.category_name }}</option>
                        </select>
                        <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="publishDate" class="block text-sm font-medium">Publish Date</label>
                        <input id="publishDate" type="date" v-model="form.publish_date" class="w-full mt-1 p-2 border rounded-lg" :class="{ 'border-red-500': form.errors.publish_date }">
                        <div v-if="form.errors.publish_date" class="text-red-500 text-sm mt-1">{{ form.errors.publish_date }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="featuredImage" class="block text-sm font-medium">Featured Image</label>
                        <input id="featuredImage" type="file" @change="e => form.image = e.target.files[0]" class="w-full mt-1 p-2 border rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="tags" class="block text-sm font-medium">Tags</label>
                        <input id="tags" type="text" v-model="form.tags" class="w-full mt-1 p-2 border rounded-lg" :class="{ 'border-red-500': form.errors.tags }">
                        <div v-if="form.errors.tags" class="text-red-500 text-sm mt-1">{{ form.errors.tags }}</div>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium">Content</label>
                        <textarea id="content" v-model="form.content" rows="4" class="w-full mt-1 p-2 border rounded-lg" :class="{ 'border-red-500': form.errors.content }"></textarea>
                        <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600" @click="showModal = false">Cancel</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
