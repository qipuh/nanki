<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import KeneMotif from '../Components/KeneMotif.vue';
import Lightbox from '../Components/Lightbox.vue';

defineOptions({ layout: AppLayout })

const props = defineProps({
    fairs: {
        type: Array,
        default: () => [],
    },
});

const openFair = ref(null);
const lightboxIndex = ref(null);

const galleryImages = computed(() => {
    if (!openFair.value) return [];
    return openFair.value.images.map((img) => ({
        src: `/storage/${img.image}`,
        alt: openFair.value.title,
    }));
});

const openGallery = (fair) => {
    if (!fair.images.length) return;
    openFair.value = fair;
    lightboxIndex.value = 0;
};

const closeGallery = () => {
    lightboxIndex.value = null;
    openFair.value = null;
};
</script>

<template>
    <Head title="Ferias" />

    <!-- Hero -->
    <div class="relative bg-stone-900 py-24 sm:py-28 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.08]"
             style="background-image: url('/images/bg.jpg'); background-size: 400px; background-repeat: repeat;"></div>
        <KeneMotif class="hidden md:block absolute top-10 right-16 w-20 h-20 text-orange-500 opacity-10 animate-float pointer-events-none select-none" style="animation-delay: 0.9s" />
        <KeneMotif class="hidden md:block absolute bottom-8 left-10 w-16 h-16 text-white opacity-10 animate-float-slow pointer-events-none select-none" style="animation-delay: 1.6s" />

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <h1 class="text-4xl font-extrabold tracking-wide text-white sm:text-5xl font-outfit">Ferias</h1>
            <div class="flex items-center justify-center gap-3 mt-6 mb-6">
                <span class="w-10 h-px bg-orange-500"></span>
                <KeneMotif class="w-5 h-5 text-orange-500" />
                <span class="w-10 h-px bg-orange-500"></span>
            </div>
            <p class="text-lg text-stone-300 max-w-2xl mx-auto font-light">
                Nos encontramos en eventos de la región y a nivel nacional llevando el sabor amazónico.
            </p>
        </div>
    </div>

    <!-- Listado -->
    <section class="py-20 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div v-if="fairs.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <div v-for="fair in fairs" :key="fair.id"
                    class="group border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                    <div class="relative bg-stone-100 h-56 flex items-center justify-center overflow-hidden">
                        <img v-if="fair.image" :src="`/storage/${fair.image}`" :alt="fair.title" class="h-full w-full object-cover" />
                        <span v-else class="text-stone-400 font-bold uppercase tracking-widest font-outfit text-center px-4">{{ fair.title }}</span>

                        <button v-if="fair.images.length" @click="openGallery(fair)" type="button"
                            class="absolute inset-0 bg-black/0 hover:bg-black/40 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-medium bg-black/70 px-4 py-2 rounded-full flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Ver galería ({{ fair.images.length }})
                            </span>
                        </button>
                    </div>
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-black tracking-wider mb-2">{{ fair.title }}</h3>
                        <p v-if="fair.description" class="text-stone-600 font-light text-sm">{{ fair.description }}</p>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white p-10 rounded-2xl shadow-xl max-w-2xl mx-auto border-t-4 border-orange-500 relative text-center">
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-orange-500 rounded-full p-3 shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-stone-800 mt-4 mb-2">¡Nos estamos preparando!</h2>
                <p class="text-stone-600 mb-6">
                    Actualmente estamos coordinando nuestra participación en los próximos eventos de la región y a nivel nacional. Pronto publicaremos el calendario para que puedas visitarnos y degustar el auténtico sabor amazónico en persona.
                </p>
                <Link href="/contacto" class="inline-block bg-stone-100 hover:bg-stone-200 text-stone-800 font-medium py-2 px-6 rounded-full transition-colors border border-stone-300">
                    Contáctanos
                </Link>
            </div>
        </div>
    </section>

    <Lightbox v-if="lightboxIndex !== null" :images="galleryImages" :index="lightboxIndex"
        @close="closeGallery" @update:index="i => lightboxIndex = i" />
</template>
