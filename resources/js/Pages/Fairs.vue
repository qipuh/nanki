<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })
</script>

<template>
    <Head title="Ferias" />
    <div class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center min-h-[60vh] flex flex-col justify-center">
        <h1 class="text-4xl font-extrabold font-outfit text-stone-900 mb-8 uppercase tracking-wide">Próximas Ferias</h1>
        <div class="bg-white p-10 rounded-2xl shadow-xl max-w-2xl mx-auto border-t-4 border-orange-500 relative">
            <!-- Decorative icon -->
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-orange-500 rounded-full p-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            
            <h2 class="text-2xl font-bold text-stone-800 mt-4 mb-2">¡Nos estamos preparando!</h2>
            <p class="text-stone-600 mb-6">
                Actualmente estamos coordinando nuestra participación en los próximos eventos de la región y a nivel nacional. Pronto publicaremos el calendario para que puedas visitarnos y degustar el auténtico sabor amazónico en persona.
            </p>
            <p class="text-sm font-medium text-green-600">
                Participamos recientemente en Expoamazónica con gran éxito. ¡Mantente atento a nuestras novedades!
            </p>
            
            <div class="mt-8">
                <Link href="/contacto" class="inline-block bg-stone-100 hover:bg-stone-200 text-stone-800 font-medium py-2 px-6 rounded-full transition-colors border border-stone-300">
                    Contáctanos
                </Link>
            </div>
        </div>
    </div>
</template>
