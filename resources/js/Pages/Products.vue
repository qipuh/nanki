<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

<template>
    <Head title="Productos" />
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold font-outfit text-stone-900 mb-8">Nuestros Productos</h1>
        <p class="text-stone-600">Catálogo en construcción. Pronto podrás ver todas nuestras salsas amazónicas aquí.</p>
    </div>
</template>
