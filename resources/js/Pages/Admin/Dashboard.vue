<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    stats: Object,
});

const page = usePage();
const userName = computed(() => page.props.auth.user?.name ?? 'Administrador');

const cards = computed(() => [
    { label: 'Productos', value: props.stats.products, href: '/admin/productos' },
    { label: 'Productos activos', value: props.stats.activeProducts, href: '/admin/productos' },
    { label: 'Mensajes sin leer', value: props.stats.unreadMessages, href: '/admin/mensajes', highlight: props.stats.unreadMessages > 0 },
    { label: 'Mensajes totales', value: props.stats.totalMessages, href: '/admin/mensajes' },
]);

const quickLinks = [
    { href: '/?edit=1', label: 'Editar página de inicio', description: 'Edita textos e imágenes directo sobre la web.' },
    { href: '/admin/productos/create', label: 'Nuevo producto', description: 'Agrega un producto al catálogo.' },
    { href: '/admin/marca', label: 'Editar marca', description: 'Cambia el nombre y logo de la web.' },
    { href: '/admin/mensajes', label: 'Ver mensajes', description: 'Revisa los mensajes de contacto.' },
];
</script>

<template>
    <Head title="Admin - Inicio" />

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-stone-900">Bienvenido, {{ userName }}</h1>
        <p class="text-stone-500 mt-1">Este es el resumen de tu web hoy.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
        <Link v-for="card in cards" :key="card.label" :href="card.href"
            class="bg-white rounded-lg shadow p-6 hover:shadow-md transition-shadow"
            :class="card.highlight ? 'border-l-4 border-orange-500' : ''">
            <p class="text-sm text-stone-500">{{ card.label }}</p>
            <p class="text-3xl font-bold text-stone-900 mt-2">{{ card.value }}</p>
        </Link>
    </div>

    <h2 class="text-lg font-bold text-stone-900 mb-4">Accesos rápidos</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <Link v-for="link in quickLinks" :key="link.href" :href="link.href"
            class="bg-white rounded-lg shadow p-6 hover:shadow-md hover:border-orange-500 border border-transparent transition-all">
            <p class="font-semibold text-stone-900">{{ link.label }}</p>
            <p class="text-sm text-stone-500 mt-1">{{ link.description }}</p>
        </Link>
    </div>
</template>
