<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted, provide } from 'vue';
import { cartCount } from '../cart';
import CartDrawer from '../Components/CartDrawer.vue';

const isMenuOpen = ref(false);
const isCartOpen = ref(false);
const scrolled = ref(false);
const page = usePage();

const siteName = computed(() => page.props.site?.name ?? 'Nanki');
const siteLogo = computed(() => page.props.site?.logo ? `/storage/${page.props.site.logo}` : null);
const isHome = computed(() => page.component === 'Home');
const hasHeroImage = computed(() => (page.props.slides?.length ?? 0) > 0);
const navSolid = computed(() => scrolled.value || !isHome.value || isMenuOpen.value || !hasHeroImage.value);

const isAdmin = computed(() => !!page.props.auth?.user);
const editMode = ref(isAdmin.value && new URLSearchParams(window.location.search).get('edit') === '1');
provide('editMode', editMode);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const onScroll = () => {
    scrolled.value = window.scrollY > 40;
};

onMounted(() => {
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<template>
    <div class="min-h-screen flex flex-col bg-stone-50 font-sans">
        <!-- Barra de modo edición -->
        <div v-if="editMode" class="fixed top-0 inset-x-0 z-[60] bg-orange-600 text-white text-sm px-4 py-2 flex items-center justify-center gap-3 shadow-md">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            <span>Modo edición activo — haz clic en cualquier texto o imagen para editarlo.</span>
            <button @click="editMode = false" class="underline font-medium hover:no-underline ml-2">Salir</button>
        </div>

        <!-- Botón flotante para admins -->
        <button v-if="isAdmin && !editMode" @click="editMode = true"
            class="fixed bottom-6 right-6 z-[60] flex items-center gap-2 bg-stone-900 text-white px-4 py-3 rounded-full shadow-lg hover:bg-stone-800 transition-colors text-sm font-medium">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Editar visualmente
        </button>

        <!-- Navigation -->
        <nav class="fixed inset-x-0 z-50 transition-colors duration-300"
            :class="[navSolid ? 'bg-white/95 backdrop-blur-md shadow-sm' : 'bg-transparent', editMode ? 'top-9' : 'top-0']">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between transition-all duration-300"
                    :class="navSolid ? 'h-20 items-center' : 'h-32 items-start pt-6'">
                    <div class="flex items-center">
                        <Link href="/" class="flex-shrink-0 flex items-center">
                            <img v-if="siteLogo" :src="siteLogo" :alt="siteName"
                                class="w-auto transition-all duration-300" :class="navSolid ? 'h-11' : 'h-24'" />
                            <span v-else class="font-bold tracking-wide font-outfit transition-all duration-300"
                                :class="navSolid ? 'text-2xl text-stone-900' : 'text-4xl text-white'">{{ siteName }}</span>
                        </Link>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="hidden md:flex md:items-center md:space-x-1">
                        <Link href="/" class="px-4 py-2 rounded-md text-base font-medium tracking-wide transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:text-orange-600' : 'text-white hover:text-orange-200'">Inicio</Link>
                        <Link href="/productos" class="px-4 py-2 rounded-md text-base font-medium tracking-wide transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:text-orange-600' : 'text-white hover:text-orange-200'">Productos</Link>

                        <div class="relative group">
                            <button class="px-4 py-2 rounded-md text-base font-medium tracking-wide transition-colors inline-flex items-center"
                                :class="navSolid ? 'text-stone-700 hover:text-orange-600' : 'text-white hover:text-orange-200'">
                                Nosotros
                                <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-1 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-1" role="menu">
                                    <Link href="/nosotros/historia" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-600">Historia</Link>
                                    <Link href="/nosotros/prensa" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-600">Prensa</Link>
                                </div>
                            </div>
                        </div>

                        <Link href="/ferias" class="px-4 py-2 rounded-md text-base font-medium tracking-wide transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:text-orange-600' : 'text-white hover:text-orange-200'">Ferias</Link>
                        <Link href="/contacto"
                            class="ml-2 px-5 py-2 rounded-md text-base font-medium tracking-wide border transition-colors"
                            :class="navSolid ? 'border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white' : 'border-white text-white hover:bg-white hover:text-stone-900'">Contacto</Link>

                        <button @click="isCartOpen = true" aria-label="Ver carrito"
                            class="relative ml-1 p-2 rounded-md transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:bg-stone-100' : 'text-white hover:bg-white/10'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            <span v-if="cartCount > 0" class="absolute -top-0.5 -right-0.5 w-4.5 h-4.5 min-w-[18px] flex items-center justify-center rounded-full bg-orange-500 text-white text-[10px] font-bold px-1">
                                {{ cartCount }}
                            </span>
                        </button>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center gap-1 md:hidden">
                        <button @click="isCartOpen = true" aria-label="Ver carrito"
                            class="relative p-2 rounded-md transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:bg-stone-100' : 'text-white hover:bg-white/10'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            <span v-if="cartCount > 0" class="absolute -top-0.5 -right-0.5 w-4.5 h-4.5 min-w-[18px] flex items-center justify-center rounded-full bg-orange-500 text-white text-[10px] font-bold px-1">
                                {{ cartCount }}
                            </span>
                        </button>
                        <button @click="toggleMenu" type="button" class="inline-flex items-center justify-center p-2 rounded-md transition-colors"
                            :class="navSolid ? 'text-stone-700 hover:bg-stone-100' : 'text-white hover:bg-white/10'">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': isMenuOpen, 'inline-flex': !isMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !isMenuOpen, 'inline-flex': isMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': isMenuOpen, 'hidden': !isMenuOpen}" class="md:hidden bg-white border-t border-stone-100 shadow-sm">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <Link href="/" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Inicio</Link>
                    <Link href="/productos" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Productos</Link>
                    <Link href="/nosotros/historia" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Historia</Link>
                    <Link href="/nosotros/prensa" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Prensa</Link>
                    <Link href="/ferias" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Ferias</Link>
                    <Link href="/contacto" class="block px-3 py-2 rounded-md text-base font-medium text-stone-700 hover:bg-orange-50 hover:text-orange-600">Contacto</Link>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow" :class="[isHome && hasHeroImage ? '' : 'pt-20', editMode ? 'mt-9' : '']">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-stone-900 text-white mt-auto">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-1">
                        <img v-if="siteLogo" :src="siteLogo" :alt="siteName" class="h-12 w-auto mb-4 brightness-0 invert" />
                        <span v-else class="text-3xl font-bold tracking-wider font-outfit text-orange-500 mb-4 block uppercase">{{ siteName }}</span>
                        <p class="text-stone-400 text-sm">Tradición, naturaleza y sabor en cada plato. La Amazonía en tu mesa.</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-green-500 tracking-wider uppercase mb-4">Enlaces</h3>
                        <ul class="space-y-2">
                            <li><Link href="/" class="text-stone-300 hover:text-white transition">Inicio</Link></li>
                            <li><Link href="/productos" class="text-stone-300 hover:text-white transition">Productos</Link></li>
                            <li><Link href="/nosotros/historia" class="text-stone-300 hover:text-white transition">Historia</Link></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-green-500 tracking-wider uppercase mb-4">Contacto</h3>
                        <ul class="space-y-2 text-stone-300 text-sm">
                            <li>Calle Liberacion 349</li>
                            <li>Fransisco Secada Vignetta</li>
                            <li>San Juan Bautista - Iquitos</li>
                            <li class="pt-2">
                                <a href="tel:+51980098175" class="hover:text-white">980 098 175</a> / <a href="tel:+51947216934" class="hover:text-white">947 216 934</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-green-500 tracking-wider uppercase mb-4">Síguenos</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-stone-400 hover:text-white transition">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-stone-400 hover:text-white transition">
                                <span class="sr-only">Instagram</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-stone-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-stone-500 text-sm">
                        &copy; {{ new Date().getFullYear() }} Nanki Iquitos. Todos los derechos reservados.
                    </p>
                </div>
            </div>
            <!-- Bottom decorative border -->
            <div class="h-3 w-full bg-orange-600" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,0,0,0.1) 10px, rgba(0,0,0,0.1) 20px);"></div>
        </footer>

        <CartDrawer :open="isCartOpen" @close="isCartOpen = false" />
    </div>
</template>
