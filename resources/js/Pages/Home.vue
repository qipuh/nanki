<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

<template>
    <Head title="Inicio - Nanki" />

    <!-- Hero Section Minimalista (Imagen Nanki) -->
    <div class="relative bg-white overflow-hidden min-h-[600px] flex flex-col justify-center border-b border-stone-200">
        <!-- Fondo Patrón Rombos SVG sutil -->
        <div class="absolute inset-0 pointer-events-none" 
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'80\' height=\'80\' viewBox=\'0 0 80 80\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' stroke=\'%23f3f4f6\' stroke-width=\'1.5\'%3E%3Cpath d=\'M40 0l40 40-40 40L0 40z\'/%3E%3Cpath d=\'M40 15l25 25-25 25L15 40z\'/%3E%3C/g%3E%3C/svg%3E'); background-size: 80px 80px; background-position: center;">
        </div>

        <div class="relative max-w-7xl mx-auto py-32 px-4 sm:py-40 sm:px-6 lg:px-8 flex flex-col items-center text-center z-10 w-full">
            
            <!-- Logo Text -->
            <h1 class="text-7xl sm:text-8xl md:text-[10rem] font-black tracking-tight text-black font-outfit uppercase leading-none">
                NANKI
            </h1>
            
            <!-- Orange Divider -->
            <div class="w-full max-w-[280px] sm:max-w-[400px] md:max-w-[500px] h-1 bg-orange-500 mt-4 mb-8"></div>
            
            <!-- Subtitle -->
            <p class="text-sm sm:text-lg text-stone-500 font-medium tracking-[0.4em] uppercase">
                Loreto, Perú
            </p>

            <div class="mt-16 sm:flex sm:justify-center gap-6">
                <Link href="/productos" class="flex items-center justify-center px-8 py-4 border border-orange-500 text-sm font-medium rounded-none text-white bg-orange-500 hover:bg-orange-600 hover:border-orange-600 transition-all uppercase tracking-widest shadow-sm">
                    Explorar
                </Link>
                <Link href="/nosotros/historia" class="flex items-center justify-center px-8 py-4 border border-stone-300 text-sm font-medium rounded-none text-stone-600 hover:bg-stone-50 hover:text-black transition-all uppercase tracking-widest mt-4 sm:mt-0 shadow-sm bg-white">
                    Nuestra Raíz
                </Link>
            </div>
        </div>
    </div>

    <!-- About Snippet -->
    <section class="py-24 bg-stone-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-20 items-center">
                <div class="relative group p-4">
                    <!-- Marco sobrio -->
                    <div class="absolute inset-0 bg-stone-200 translate-x-4 translate-y-4"></div>
                    <div class="relative bg-white h-full min-h-[400px] flex items-center justify-center p-8 border border-stone-200 shadow-sm">
                        <div class="absolute inset-0 opacity-5" 
                             style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M0,30 L30,0 L60,30 L30,60 Z M15,30 L30,15 L45,30 L30,45 Z\' stroke=\'%23000000\' stroke-width=\'2\' fill=\'none\'/%3E%3C/svg%3E');">
                        </div>
                        <div class="text-center relative z-10">
                            <span class="text-6xl font-outfit font-black text-black">NANKI</span>
                            <div class="h-0.5 w-full bg-orange-500 my-4"></div>
                            <p class="text-stone-500 mt-2 text-sm font-medium uppercase tracking-[0.3em]">Loreto, Perú</p>
                        </div>
                    </div>
                </div>
                <div class="mt-16 lg:mt-0">
                    <h2 class="text-3xl font-black text-black tracking-tight sm:text-4xl font-outfit uppercase">
                        El Espíritu del <span class="text-orange-500">Bosque</span>
                    </h2>
                    <div class="w-16 h-1 bg-orange-500 mt-6 mb-8"></div>
                    <p class="text-lg text-stone-700 mb-6 font-light">
                        Nanki rinde homenaje a la profunda riqueza cultural de Iquitos. Nuestras salsas de <span class="font-medium text-black">Ají Charapita</span> y <span class="font-medium text-black">Ají Dulce</span> son un viaje sensorial a la selva.
                    </p>
                    <p class="text-lg text-stone-600 mb-10 font-light">
                        Inspirados en la geometría sagrada del Kené, elaboramos cada producto respetando la tierra y la tradición oral que nos conecta con la naturaleza.
                    </p>
                    <Link href="/nosotros/historia" class="inline-flex items-center text-orange-600 font-medium hover:text-orange-700 uppercase tracking-widest text-sm transition-colors group">
                        Conoce más sobre nosotros
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </Link>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos - Estilo Galería Limpia -->
    <section class="py-24 bg-white relative border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                <div class="max-w-2xl">
                    <h2 class="text-orange-500 font-semibold tracking-[0.2em] uppercase text-sm mb-4">La Cosecha</h2>
                    <p class="text-3xl font-black text-black sm:text-4xl font-outfit uppercase tracking-tight">
                        Fuego Amazónico
                    </p>
                </div>
                <Link href="/productos" class="hidden md:inline-flex items-center text-black font-medium uppercase tracking-widest text-sm hover:text-orange-500 transition-colors group">
                    Ver Todos
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </Link>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Product Card 1 -->
                <div class="group cursor-pointer border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                    <div class="relative bg-stone-100 h-64 flex items-center justify-center">
                        <div class="absolute inset-4 border border-dashed border-stone-300"></div>
                        <span class="text-stone-400 font-bold text-lg uppercase tracking-widest font-outfit z-10 group-hover:text-orange-500 transition-colors">Ají Charapita</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-black uppercase tracking-wider mb-2">Tradición Pura</h3>
                        <p class="text-stone-600 font-light text-sm">El inconfundible picor de la selva. 100% fruta entera de origen loretano.</p>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="group cursor-pointer border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                    <div class="relative bg-stone-100 h-64 flex items-center justify-center">
                        <div class="absolute inset-4 border border-dashed border-stone-300"></div>
                        <span class="text-stone-400 font-bold text-lg uppercase tracking-widest font-outfit z-10 group-hover:text-orange-500 transition-colors">Ají Dulce</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-black uppercase tracking-wider mb-2">Suave y Aromático</h3>
                        <p class="text-stone-600 font-light text-sm">Esencia amazónica sin picor, perfecta para realzar el sabor de cualquier plato.</p>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="group cursor-pointer border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                    <div class="relative bg-stone-100 h-64 flex items-center justify-center">
                        <div class="absolute inset-4 border border-dashed border-stone-300"></div>
                        <span class="text-stone-400 font-bold text-lg uppercase tracking-widest font-outfit z-10 text-center px-4 group-hover:text-orange-500 transition-colors">Charapita & Maracuyá</span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-black uppercase tracking-wider mb-2">Fusión Tropical</h3>
                        <p class="text-stone-600 font-light text-sm">Una explosión que combina el picante intenso con un vibrante toque ácido.</p>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center md:hidden">
                <Link href="/productos" class="inline-flex items-center justify-center px-8 py-4 border border-black text-sm font-medium rounded-none text-black hover:bg-black hover:text-white transition-colors uppercase tracking-widest w-full">
                    Ver Todos Los Productos
                </Link>
            </div>
        </div>
    </section>

    <!-- Cultural Identity Section (Kené Pattern Theme) -->
    <section class="py-24 bg-stone-900 text-white relative overflow-hidden">
        <!-- Kené laberinto pattern sobrio -->
        <div class="absolute inset-0 opacity-5" 
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'120\' height=\'120\' viewBox=\'0 0 120 120\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10,10 h100 v100 h-100 v-100 M30,30 h60 v60 h-60 v-60 M50,50 h20 v20 h-20 v-20\' stroke=\'%23ffffff\' stroke-width=\'2\' fill=\'none\' stroke-linejoin=\'miter\'/%3E%3C/svg%3E'); background-size: 60px 60px;">
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-black/80 backdrop-blur-sm border border-stone-800 p-10 md:p-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-block border border-orange-500 text-orange-500 px-4 py-1 mb-6 uppercase tracking-widest text-xs font-medium">Nuestra Esencia</div>
                        <h2 class="text-3xl md:text-4xl font-black font-outfit mb-6 uppercase tracking-tight text-white">
                            El Arte Kené<br/>En Tu Mesa
                        </h2>
                        <p class="text-lg text-stone-300 mb-6 font-light leading-relaxed">
                            Nuestros empaques y filosofía se inspiran en los telares y el diseño de los pueblos Shipibo-Konibo. 
                        </p>
                        <p class="text-base text-stone-400 leading-relaxed border-l-2 border-orange-500 pl-4 font-light">
                            Las líneas sinuosas y patrones geométricos no son solo adornos; representan los ríos, la energía de las plantas maestras y la cosmovisión de una selva viva.
                        </p>
                    </div>
                    <div class="flex justify-center relative">
                        <div class="w-full max-w-xs aspect-square bg-stone-900 border border-stone-800 flex flex-col items-center justify-center p-8 relative">
                            <!-- Simulating a woven pattern visually, completely sober -->
                            <div class="absolute inset-6 border border-stone-700 rotate-45"></div>
                            <div class="absolute inset-10 border border-stone-700 -rotate-45"></div>
                            <div class="w-8 h-8 bg-orange-500 z-10 relative"></div>
                            <span class="text-stone-500 font-medium mt-6 z-10 tracking-[0.2em] uppercase text-xs">Iquitos</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
