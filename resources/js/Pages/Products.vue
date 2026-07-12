<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';
import ProductSearch from '../Components/ProductSearch.vue';
import KeneMotif from '../Components/KeneMotif.vue';

defineOptions({ layout: AppLayout })

defineProps({
    products: Array,
    search: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <Head title="Productos" />

    <!-- Hero -->
    <div class="relative bg-stone-900 py-20 sm:py-24 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.08]"
             style="background-image: url('/images/bg.jpg'); background-size: 400px; background-repeat: repeat;"></div>
        <KeneMotif class="hidden md:block absolute top-8 right-16 w-16 h-16 text-orange-500 opacity-10 animate-float pointer-events-none select-none" style="animation-delay: 0.9s" />
        <KeneMotif class="hidden md:block absolute bottom-6 left-10 w-14 h-14 text-white opacity-10 animate-float-slow pointer-events-none select-none" style="animation-delay: 1.6s" />

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <h1 class="text-4xl font-bold tracking-wide text-white sm:text-5xl font-outfit">Nuestros Productos</h1>
            <div class="flex items-center justify-center gap-3 mt-6 mb-6">
                <span class="w-10 h-px bg-orange-500"></span>
                <KeneMotif class="w-5 h-5 text-orange-500" />
                <span class="w-10 h-px bg-orange-500"></span>
            </div>
            <p class="text-lg text-stone-300 max-w-xl mx-auto font-light">Salsas amazónicas hechas con tradición y sabor de Loreto.</p>
        </div>
    </div>

    <!-- Catálogo -->
    <section class="py-16 sm:py-20 bg-stone-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto mb-14">
                <ProductSearch :model-value="search" />
            </div>

            <div v-if="products.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="product in products" :key="product.id"
                    class="group bg-white border border-stone-200 hover:border-orange-500 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                    <div class="relative bg-stone-100 aspect-square flex items-center justify-center overflow-hidden">
                        <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name"
                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div v-else class="flex flex-col items-center gap-3 px-6 text-center">
                            <KeneMotif class="w-8 h-8 text-stone-300" />
                            <span class="text-stone-400 font-bold text-base uppercase tracking-widest font-outfit">{{ product.name }}</span>
                        </div>

                        <span v-if="product.price" class="absolute top-3 right-3 bg-stone-900/90 text-white text-sm font-bold px-3 py-1.5 shadow-sm">
                            S/ {{ product.price }}
                        </span>
                    </div>

                    <div class="p-6 flex-1 flex flex-col">
                        <p v-if="product.tagline" class="text-orange-600 text-xs font-semibold uppercase tracking-[0.15em] mb-1.5">{{ product.tagline }}</p>
                        <h3 class="text-lg font-bold text-black tracking-wide mb-2">{{ product.name }}</h3>
                        <p v-if="product.description" class="text-stone-600 font-light text-sm leading-relaxed">{{ product.description }}</p>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-20">
                <KeneMotif class="w-10 h-10 text-stone-300 mx-auto mb-4" />
                <p class="text-stone-500 max-w-sm mx-auto">
                    <template v-if="search">No se encontraron productos para "{{ search }}".</template>
                    <template v-else>Catálogo en construcción. Pronto podrás ver todas nuestras salsas amazónicas aquí.</template>
                </p>
            </div>
        </div>
    </section>
</template>
