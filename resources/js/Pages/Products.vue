<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })

defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Productos" />
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold font-outfit text-stone-900 mb-4 uppercase">Nuestros Productos</h1>
            <p class="text-stone-600">Salsas amazónicas hechas con tradición y sabor de Loreto.</p>
        </div>

        <div v-if="products.length" class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div v-for="product in products" :key="product.id"
                class="group border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                <div class="relative bg-stone-100 h-64 flex items-center justify-center overflow-hidden">
                    <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="h-full w-full object-cover" />
                    <span v-else class="text-stone-400 font-bold text-lg uppercase tracking-widest font-outfit z-10 text-center px-4">{{ product.name }}</span>
                </div>
                <div class="p-8">
                    <h3 class="text-lg font-bold text-black uppercase tracking-wider mb-2">{{ product.name }}</h3>
                    <p v-if="product.tagline" class="text-orange-600 text-sm font-medium mb-2">{{ product.tagline }}</p>
                    <p v-if="product.description" class="text-stone-600 font-light text-sm mb-3">{{ product.description }}</p>
                    <p v-if="product.price" class="text-stone-900 font-bold">S/ {{ product.price }}</p>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-stone-500 py-16">
            Catálogo en construcción. Pronto podrás ver todas nuestras salsas amazónicas aquí.
        </div>
    </div>
</template>
