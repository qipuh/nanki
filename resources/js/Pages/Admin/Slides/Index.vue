<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    slides: Array,
});

const destroy = (slide) => {
    if (confirm(`¿Eliminar el slide "${slide.title}"?`)) {
        router.delete(`/admin/slides/${slide.id}`);
    }
};

const positionLabel = { left: 'Izquierda', center: 'Centro', right: 'Derecha' };
</script>

<template>
    <Head title="Admin - Slider" />

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-stone-900">Slider del inicio</h1>
            <p class="text-stone-500 text-sm mt-1">Se muestran en orden en el hero de la página principal.</p>
        </div>
        <Link href="/admin/slides/create" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors">
            + Nuevo slide
        </Link>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="text-left px-6 py-3">Imagen</th>
                    <th class="text-left px-6 py-3">Título</th>
                    <th class="text-left px-6 py-3">Posición texto</th>
                    <th class="text-left px-6 py-3">Orden</th>
                    <th class="text-left px-6 py-3">Estado</th>
                    <th class="text-right px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                <tr v-for="slide in slides" :key="slide.id">
                    <td class="px-6 py-4">
                        <img :src="`/storage/${slide.image}`" class="h-12 w-20 object-cover rounded" />
                    </td>
                    <td class="px-6 py-4 font-medium text-stone-900">{{ slide.title }}</td>
                    <td class="px-6 py-4 text-stone-600">{{ positionLabel[slide.text_position] }}</td>
                    <td class="px-6 py-4 text-stone-600">{{ slide.order }}</td>
                    <td class="px-6 py-4">
                        <span :class="slide.active ? 'bg-green-100 text-green-800' : 'bg-stone-100 text-stone-600'" class="px-2.5 py-1 rounded-full text-xs font-medium">
                            {{ slide.active ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <Link :href="`/admin/slides/${slide.id}/edit`" class="text-orange-600 hover:text-orange-800 font-medium">Editar</Link>
                        <button @click="destroy(slide)" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                    </td>
                </tr>
                <tr v-if="slides.length === 0">
                    <td colspan="6" class="px-6 py-12 text-center text-stone-400">No hay slides todavía. Se mostrará el hero por defecto.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
