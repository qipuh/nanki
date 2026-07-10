<script setup>
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

defineProps({
    messages: Array,
});

const markRead = (message) => {
    if (!message.read_at) {
        router.patch(`/admin/mensajes/${message.id}`, {}, { preserveScroll: true });
    }
};

const destroy = (message) => {
    if (confirm('¿Eliminar este mensaje?')) {
        router.delete(`/admin/mensajes/${message.id}`, { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Admin - Mensajes de contacto" />

    <h1 class="text-2xl font-bold text-stone-900 font-outfit mb-6">Mensajes de contacto</h1>

    <div class="space-y-3">
        <div v-for="message in messages" :key="message.id"
            @click="markRead(message)"
            class="bg-white rounded-lg shadow p-6 cursor-pointer"
            :class="!message.read_at ? 'border-l-4 border-orange-500' : ''">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="font-semibold text-stone-900">
                        {{ message.name }}
                        <span v-if="!message.read_at" class="ml-2 text-xs font-medium bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full">Nuevo</span>
                    </p>
                    <p class="text-sm text-stone-500">{{ message.email }}<span v-if="message.phone"> · {{ message.phone }}</span></p>
                </div>
                <div class="flex items-center gap-3 shrink-0">
                    <span class="text-xs text-stone-400">{{ new Date(message.created_at).toLocaleString('es-PE') }}</span>
                    <button @click.stop="destroy(message)" class="text-red-600 hover:text-red-800 text-sm font-medium">Eliminar</button>
                </div>
            </div>
            <p class="text-stone-700 text-sm whitespace-pre-line">{{ message.message }}</p>
        </div>

        <div v-if="messages.length === 0" class="bg-white rounded-lg shadow p-12 text-center text-stone-400">
            No hay mensajes todavía.
        </div>
    </div>
</template>
