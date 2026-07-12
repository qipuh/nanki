<script setup>
import { ref } from 'vue';
import Lightbox from './Lightbox.vue';

const props = defineProps({
    images: {
        type: Array,
        required: true,
    },
});

const lightboxIndex = ref(null);

const openLightbox = (i) => {
    lightboxIndex.value = i % props.images.length;
};
</script>

<template>
    <div class="relative w-full overflow-hidden">
        <div class="flex w-max animate-marquee hover:[animation-play-state:paused]">
            <button v-for="(img, i) in [...images, ...images]" :key="i" @click="openLightbox(i)" type="button"
                class="group relative shrink-0 w-56 sm:w-72 aspect-square overflow-hidden bg-stone-100 cursor-pointer">
                <img :src="img.src" :alt="img.alt" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" loading="lazy" />
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                    <svg class="w-9 h-9 text-white opacity-0 scale-75 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 8v6M8 11h6" />
                    </svg>
                </div>
            </button>
        </div>

        <Lightbox v-if="lightboxIndex !== null" :images="images" :index="lightboxIndex"
            @close="lightboxIndex = null" @update:index="i => lightboxIndex = i" />
    </div>
</template>
