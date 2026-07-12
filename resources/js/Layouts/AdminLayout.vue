<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const sidebarOpen = ref(false);
const collapsed = ref(localStorage.getItem('admin-sidebar-collapsed') === '1');

const toggleCollapsed = () => {
    collapsed.value = !collapsed.value;
    localStorage.setItem('admin-sidebar-collapsed', collapsed.value ? '1' : '0');
};

const siteName = computed(() => page.props.site?.name ?? 'Nanki');
const siteLogo = computed(() => page.props.site?.logo ? `/storage/${page.props.site.logo}` : null);

const nav = [
    {
        href: '/admin/dashboard', label: 'Inicio',
        icon: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    },
    {
        href: '/admin/slides', label: 'Slider',
        icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16v16H4V4z',
    },
    {
        href: '/admin/productos', label: 'Productos',
        icon: 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
    },
    {
        href: '/admin/galeria', label: 'Galería',
        icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2zM9 9a1 1 0 11-2 0 1 1 0 012 0z',
    },
    {
        href: '/admin/ferias', label: 'Ferias',
        icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
    },
    {
        href: '/admin/marca', label: 'Marca',
        icon: 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
    },
    {
        href: '/admin/mensajes', label: 'Mensajes',
        icon: 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.86 9.86 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z',
    },
];

const currentLabel = computed(() => nav.find((item) => page.url.startsWith(item.href))?.label ?? 'Panel');

const userInitial = computed(() => (page.props.auth.user?.name ?? page.props.auth.user?.email ?? 'A').charAt(0).toUpperCase());

const logout = () => {
    router.post('/admin/logout');
};
</script>

<template>
    <div class="min-h-screen flex bg-stone-50 font-sans">
        <!-- Overlay móvil -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

        <aside
            class="bg-white border-r border-stone-200 flex flex-col shrink-0 fixed inset-y-0 left-0 z-40 transition-all duration-200 lg:relative lg:translate-x-0 w-64"
            :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', collapsed ? 'lg:w-20' : 'lg:w-64']"
        >
            <button @click="toggleCollapsed" :title="collapsed ? 'Expandir' : 'Contraer'"
                class="hidden lg:flex absolute top-10 -translate-y-1/2 -right-3 w-6 h-6 items-center justify-center rounded-full bg-white border border-stone-200 shadow text-stone-500 hover:text-orange-600 hover:border-orange-300 transition-colors z-50">
                <svg class="w-3.5 h-3.5 shrink-0 transition-transform" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <div class="h-20 px-6 flex items-center justify-between border-b border-stone-100" :class="{ 'lg:px-0 lg:justify-center': collapsed }">
                <Link href="/admin/dashboard" class="flex items-center gap-2 min-w-0" @click="sidebarOpen = false">
                    <img v-if="siteLogo" :src="siteLogo" :alt="siteName" class="h-9 w-auto shrink-0" />
                    <span v-else class="text-xl font-bold tracking-wide text-orange-600 truncate" :class="{ 'lg:hidden': collapsed }">{{ siteName }}</span>
                </Link>
                <button @click="sidebarOpen = false" class="lg:hidden text-stone-400 hover:text-stone-600 p-1" aria-label="Cerrar menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto overflow-x-hidden">
                <Link
                    v-for="item in nav"
                    :key="item.href"
                    :href="item.href"
                    :title="item.label"
                    @click="sidebarOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors border-l-2"
                    :class="[page.url.startsWith(item.href)
                        ? 'bg-orange-50 text-orange-600 border-orange-500'
                        : 'text-stone-600 border-transparent hover:bg-stone-50 hover:text-stone-900',
                        collapsed ? 'lg:justify-center' : '']"
                >
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" :d="item.icon" />
                    </svg>
                    <span :class="{ 'lg:hidden': collapsed }">{{ item.label }}</span>
                </Link>
            </nav>

            <div class="px-3 py-3 border-t border-stone-100">
                <div class="flex items-center gap-3 px-3 py-2 mb-1" :class="{ 'lg:justify-center lg:px-0': collapsed }">
                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-700 flex items-center justify-center text-sm font-bold shrink-0">
                        {{ userInitial }}
                    </div>
                    <p class="text-xs text-stone-500 truncate" :class="{ 'lg:hidden': collapsed }">{{ page.props.auth.user?.email }}</p>
                </div>
                <button @click="logout" :title="collapsed ? 'Cerrar sesión' : null" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-stone-500 hover:bg-red-50 hover:text-red-600 transition-colors" :class="{ 'lg:justify-center': collapsed }">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span :class="{ 'lg:hidden': collapsed }">Cerrar sesión</span>
                </button>
            </div>
        </aside>

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-16 sm:h-20 bg-white border-b border-stone-200 flex items-center gap-3 px-4 sm:px-8 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden text-stone-500 hover:text-stone-700 p-1 -ml-1" aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-semibold text-stone-900">{{ currentLabel }}</h1>
            </header>

            <div v-if="page.props.flash?.success" class="bg-green-50 border-b border-green-200 text-green-800 px-4 sm:px-8 py-3 text-sm font-medium">
                {{ page.props.flash.success }}
            </div>

            <main class="flex-1 p-4 sm:p-8 overflow-x-auto">
                <slot />
            </main>
        </div>
    </div>
</template>
