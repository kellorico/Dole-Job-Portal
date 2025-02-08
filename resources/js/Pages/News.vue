<script setup>
import { ref } from 'vue';
import Main from '@/Layouts/Main.vue';

const props = defineProps({
    news: Array,
});

// Create a reactive reference to track the expanded state for each news item
const isExpanded = ref(props.news.map(() => false));

function toggleContent(index) {
    isExpanded.value[index] = !isExpanded.value[index];
}
</script>

<template>
    <Main>
        <div class="flex">
            <!-- Content -->
            <div class="flex-1 absolute top-20 left-96 p-6">
                <h1 class="text-2xl font-bold mb-6 text-blue-900">Latest News</h1>

                <!-- News Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="(newsItem, index) in news"
                        :key="newsItem.id"
                        class="bg-white shadow-md rounded-lg p-6 border border-gray-200 hover:shadow-lg"
                    >
                        <!-- Image -->
                        <img
                            v-if="newsItem.image_path"
                            :src="`/storage/${newsItem.image_path}`"
                            :alt="newsItem.news_title"
                            class="w-full h-48 object-cover rounded-md mb-4"
                        />

                        <!-- News Content -->
                        <h2 class="text-lg font-semibold text-blue-800 mb-2">{{ newsItem.title }}</h2>

                        <div class="text-sm text-gray-500 mb-3">
                            <span class="mr-2">
                                Category: <span class="font-medium text-gray-700">{{ newsItem.category }}</span>
                            </span>
                            <span>
                                Tags:
                                <span

                                    class="inline-block bg-blue-100 text-blue-600 text-xs font-medium px-2 py-0.5 rounded-full mr-1"
                                >
                                    {{ newsItem.tags }}
                                </span>
                            </span>
                        </div>

                        <!-- Description with See More / See Less -->
                        <p class="text-sm mt-2 text-gray-600">
                            {{ isExpanded[index] ? newsItem.content : newsItem.content.substring(0, 150) + '...' }}
                            <button class="text-blue-500 ml-1" @click="toggleContent(index)">
                                {{ isExpanded[index] ? 'See less' : 'See more' }}
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>
