<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';

const page = usePage();

const nav = [
    { href: '/admin/productos', label: 'Productos' },
    { href: '/admin/marca', label: 'Marca' },
    { href: '/admin/mensajes', label: 'Mensajes de contacto' },
];

const logout = () => {
    router.post('/admin/logout');
};
</script>

<template>
    <div class="min-h-screen flex bg-stone-100 font-sans">
        <aside class="w-64 bg-stone-900 text-white flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-stone-800">
                <span class="text-2xl font-bold font-outfit tracking-wider text-orange-500">NANKI</span>
                <p class="text-xs text-stone-400 mt-1">Panel de administración</p>
            </div>
            <nav class="flex-1 px-3 py-6 space-y-1">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    class="block px-4 py-2.5 rounded-md text-sm font-medium transition-colors"
                    :class="page.url.startsWith(item.href) ? 'bg-orange-600 text-white' : 'text-stone-300 hover:bg-stone-800 hover:text-white'"
                >
                    {{ item.label }}
                </Link>
            </nav>
            <div class="px-3 py-4 border-t border-stone-800">
                <p class="px-4 text-xs text-stone-500 mb-2 truncate">{{ page.props.auth.user?.email }}</p>
                <button @click="logout" class="w-full text-left px-4 py-2.5 rounded-md text-sm font-medium text-stone-300 hover:bg-stone-800 hover:text-white transition-colors">
                    Cerrar sesión
                </button>
            </div>
        </aside>

        <main class="flex-1 min-w-0">
            <div v-if="page.props.flash?.success" class="bg-green-50 border-b border-green-200 text-green-800 px-8 py-3 text-sm font-medium">
                {{ page.props.flash.success }}
            </div>
            <div class="p-8">
                <slot />
            </div>
        </main>
    </div>
</template>
