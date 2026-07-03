<script setup>
import { Head } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

<template>
    <Head title="Prensa" />

    <div class="bg-stone-50 py-20 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold tracking-tight text-stone-900 sm:text-5xl font-outfit uppercase">
                    En los Medios
                </h1>
                <p class="mt-4 text-xl text-stone-600">
                    Reconocimientos y notas de prensa sobre nuestro trabajo en la Amazonía.
                </p>
            </div>

            <!-- Press Article 1 -->
            <article class="bg-white rounded-2xl shadow-xl overflow-hidden mb-12 border border-stone-100 relative group">
                <!-- Decorative border left -->
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-orange-500"></div>
                
                <div class="md:flex">
                    <div class="md:w-1/3 bg-stone-200 min-h-[250px] relative flex items-center justify-center border-r border-stone-100">
                        <div class="absolute inset-0 bg-stone-800 opacity-10"></div>
                        <span class="text-stone-400 font-medium">Revista Voces del Campo</span>
                    </div>
                    <div class="p-8 md:p-12 md:w-2/3 flex flex-col justify-center">
                        <div class="text-sm font-semibold text-green-600 tracking-wider uppercase mb-2">Revista Nº 69 | Lima, Perú</div>
                        <h2 class="text-2xl font-bold font-outfit text-stone-900 mb-4">Emprendedores apuestan por la industrialización de ají charapita</h2>
                        <div class="prose prose-stone text-stone-600 mb-6">
                            <p>
                                Hace siete años, los esposos <strong>Wilfredo Barrantes Nuñera</strong> y <strong>Juana Castro Gómez</strong> decidieron incursionar en el cultivo de cacao y limón Tahití, asociado con especies forestales, así como de ají charapita, en su fundo Rosita Sofía, de 43 hectáreas, mediante prácticas ecológicas.
                            </p>
                            <p>
                                Para dar valor agregado a este último cultivo, recibieron capacitación del CITE Maynas para la elaboración de <strong>salsa de ají charapita</strong>, <strong>crema de ají dulce con charapita</strong> y ajíes deshidratados, que comercializan con la marca "Nanky".
                            </p>
                            <p>
                                Estos productos son elaborados bajo normas sanitarias y mediante prácticas ecológicas, lo que les permitió obtener el <strong>Sello de la Agricultura Familiar</strong>.
                            </p>
                        </div>
                        <div class="mt-auto">
                            <span class="inline-flex items-center text-orange-600 font-medium italic">
                                "Tenemos recién tres meses en el mercado, pero ya hemos ingresado a supermercados de Iquitos con gran aceptación." - Wilfredo Barrantes.
                            </span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Press Article 2 -->
            <article class="bg-white rounded-2xl shadow-xl overflow-hidden border border-stone-100 relative group">
                <!-- Decorative border left -->
                <div class="absolute left-0 top-0 bottom-0 w-2 bg-green-500"></div>
                
                <div class="md:flex flex-row-reverse">
                    <div class="md:w-1/3 bg-stone-200 min-h-[250px] relative flex items-center justify-center border-l border-stone-100">
                        <div class="absolute inset-0 bg-stone-800 opacity-10"></div>
                        <span class="text-stone-400 font-medium">Expoamazónica 2026</span>
                    </div>
                    <div class="p-8 md:p-12 md:w-2/3 flex flex-col justify-center">
                        <div class="text-sm font-semibold text-green-600 tracking-wider uppercase mb-2">Evento Destacado</div>
                        <h2 class="text-2xl font-bold font-outfit text-stone-900 mb-4">Negocio picante en Expoamazónica</h2>
                        <div class="prose prose-stone text-stone-600 mb-6">
                            <p>
                                Esposos Juana Castro Gómez y Wilfredo Barrantes Nureña muestran la variedad de productos elaborados a base de ají charapita, los cuales vienen posicionándose con éxito en el mercado regional a poco tiempo de su lanzamiento.
                            </p>
                            <p>
                                Sus innovadores productos tuvieron gran acogida durante la Expoamazónica 2026, donde despertaron gran interés entre los asistentes.
                            </p>
                        </div>
                    </div>
                </div>
            </article>

        </div>
    </div>
</template>
