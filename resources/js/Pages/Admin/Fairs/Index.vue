<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    fairs: Array,
});

const destroy = (fair) => {
    if (confirm(`¿Eliminar "${fair.title}"? También se borrará su galería.`)) {
        router.delete(`/admin/ferias/${fair.id}`);
    }
};
</script>

<template>
    <Head title="Admin - Ferias" />

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-stone-900">Ferias</h1>
        <Link href="/admin/ferias/create" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors">
            + Nueva feria
        </Link>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-stone-50 text-stone-500 uppercase text-xs tracking-wider">
                <tr>
                    <th class="text-left px-6 py-3">Foto</th>
                    <th class="text-left px-6 py-3">Título</th>
                    <th class="text-left px-6 py-3">Galería</th>
                    <th class="text-left px-6 py-3">Estado</th>
                    <th class="text-right px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-100">
                <tr v-for="fair in fairs" :key="fair.id">
                    <td class="px-6 py-4">
                        <img v-if="fair.image" :src="`/storage/${fair.image}`" class="h-12 w-12 object-cover rounded" />
                        <div v-else class="h-12 w-12 bg-stone-100 rounded flex items-center justify-center text-stone-400 text-xs">N/A</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-stone-900">{{ fair.title }}</td>
                    <td class="px-6 py-4 text-stone-600">{{ fair.images_count }} foto(s)</td>
                    <td class="px-6 py-4">
                        <span :class="fair.active ? 'bg-green-100 text-green-800' : 'bg-stone-100 text-stone-600'" class="px-2.5 py-1 rounded-full text-xs font-medium">
                            {{ fair.active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-3">
                        <Link :href="`/admin/ferias/${fair.id}/edit`" class="text-orange-600 hover:text-orange-800 font-medium">Editar</Link>
                        <button @click="destroy(fair)" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                    </td>
                </tr>
                <tr v-if="fairs.length === 0">
                    <td colspan="5" class="px-6 py-12 text-center text-stone-400">No hay ferias todavía.</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
