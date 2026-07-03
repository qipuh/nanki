<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
</script>

<template>
    <div class="min-h-screen flex flex-col bg-stone-50 font-sans">
        <!-- Navigation -->
        <nav class="bg-orange-600 shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <Link href="/" class="flex-shrink-0 flex items-center">
                            <span class="text-white text-3xl font-bold tracking-wider font-outfit">NANKI</span>
                        </Link>
                    </div>
                    
                    <!-- Desktop Menu -->
                    <div class="hidden md:flex sm:items-center sm:space-x-8">
                        <Link href="/" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-lg font-medium transition-colors">Inicio</Link>
                        <Link href="/productos" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-lg font-medium transition-colors">Productos</Link>
                        
                        <div class="relative group">
                            <button class="text-white hover:text-green-200 px-3 py-2 rounded-md text-lg font-medium transition-colors inline-flex items-center">
                                Nosotros
                                <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                <div class="py-1" role="menu">
                                    <Link href="/nosotros/historia" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-600">Historia</Link>
                                    <Link href="/nosotros/prensa" class="block px-4 py-2 text-sm text-stone-700 hover:bg-orange-50 hover:text-orange-600">Prensa</Link>
                                </div>
                            </div>
                        </div>

                        <Link href="/ferias" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-lg font-medium transition-colors">Ferias</Link>
                        <Link href="/contacto" class="text-white hover:text-green-200 px-3 py-2 rounded-md text-lg font-medium transition-colors">Contacto</Link>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="toggleMenu" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-green-200 hover:bg-orange-700 focus:outline-none focus:bg-orange-700 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': isMenuOpen, 'inline-flex': !isMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !isMenuOpen, 'inline-flex': isMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': isMenuOpen, 'hidden': !isMenuOpen}" class="md:hidden bg-orange-700">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    <Link href="/" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Inicio</Link>
                    <Link href="/productos" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Productos</Link>
                    <Link href="/nosotros/historia" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Historia</Link>
                    <Link href="/nosotros/prensa" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Prensa</Link>
                    <Link href="/ferias" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Ferias</Link>
                    <Link href="/contacto" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:text-green-200 hover:bg-orange-600">Contacto</Link>
                </div>
            </div>
            
            <!-- Kené Pattern Decorative Border -->
            <div class="h-2 w-full opacity-30" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.2) 10px, rgba(255,255,255,0.2) 20px);"></div>
        </nav>

        <!-- Page Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-stone-900 text-white mt-auto">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-1">
                        <span class="text-3xl font-bold tracking-wider font-outfit text-orange-500 mb-4 block">NANKI</span>
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
    </div>
</template>
