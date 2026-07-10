<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '../Layouts/AppLayout.vue';

defineOptions({ layout: AppLayout })

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
});

const submit = () => {
    form.post('/contacto', {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Contacto" />
    <div class="bg-stone-50 py-20 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold tracking-tight text-stone-900 sm:text-5xl font-outfit uppercase">
                    Contacto
                </h1>
                <p class="mt-4 text-xl text-stone-600">
                    Estamos para atenderte. Comunícate con nosotros.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-white rounded-3xl shadow-xl overflow-hidden">
                <!-- Contact Info -->
                <div class="bg-orange-600 text-white p-10 md:p-16 flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#fff 2px, transparent 2px), radial-gradient(#fff 2px, transparent 2px); background-size: 32px 32px; background-position: 0 0, 16px 16px;"></div>
                    
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold font-outfit mb-8">Información de Contacto</h2>
                        
                        <div class="space-y-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-6 w-6 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Ubicación</h3>
                                    <p class="mt-1 text-orange-100">Calle Liberación 349<br>Fransisco Secada Vignetta<br>San Juan Bautista - Iquitos</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-6 w-6 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Teléfono / WhatsApp</h3>
                                    <p class="mt-1 text-orange-100">
                                        <a href="tel:+51980098175" class="hover:text-white transition">980 098 175</a><br>
                                        <a href="tel:+51947216934" class="hover:text-white transition">947 216 934</a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-1">
                                    <svg class="h-6 w-6 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-white">Redes Sociales</h3>
                                    <p class="mt-1 text-orange-100 flex flex-col space-y-1">
                                        <span>FB: Nanki Iquitos</span>
                                        <span>TikTok: @nanki.iquitos</span>
                                        <span>IG: @nanki_iquitos</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Form (Visual only for now) -->
                <div class="p-10 md:p-16">
                    <h3 class="text-2xl font-bold font-outfit text-stone-900 mb-6">Envíanos un mensaje</h3>

                    <div v-if="page.props.flash?.success" class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-md px-4 py-3 text-sm">
                        {{ page.props.flash.success }}
                    </div>

                    <form class="space-y-6" @submit.prevent="submit">
                        <div>
                            <label for="name" class="block text-sm font-medium text-stone-700">Nombre completo</label>
                            <div class="mt-1">
                                <input v-model="form.name" type="text" id="name" required class="py-3 px-4 block w-full shadow-sm focus:ring-orange-500 focus:border-orange-500 border-stone-300 rounded-md bg-stone-50 border">
                            </div>
                            <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-stone-700">Correo electrónico</label>
                            <div class="mt-1">
                                <input v-model="form.email" type="email" id="email" required class="py-3 px-4 block w-full shadow-sm focus:ring-orange-500 focus:border-orange-500 border-stone-300 rounded-md bg-stone-50 border">
                            </div>
                            <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-stone-700">Teléfono (opcional)</label>
                            <div class="mt-1">
                                <input v-model="form.phone" type="text" id="phone" class="py-3 px-4 block w-full shadow-sm focus:ring-orange-500 focus:border-orange-500 border-stone-300 rounded-md bg-stone-50 border">
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-stone-700">Mensaje</label>
                            <div class="mt-1">
                                <textarea v-model="form.message" id="message" rows="4" required class="py-3 px-4 block w-full shadow-sm focus:ring-orange-500 focus:border-orange-500 border-stone-300 rounded-md bg-stone-50 border"></textarea>
                            </div>
                            <p v-if="form.errors.message" class="text-red-600 text-sm mt-1">{{ form.errors.message }}</p>
                        </div>
                        <div>
                            <button type="submit" :disabled="form.processing" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors disabled:opacity-50">
                                Enviar Mensaje
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
