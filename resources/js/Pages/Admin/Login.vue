<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const siteName = computed(() => page.props.site?.name ?? 'Nanki');
const siteLogo = computed(() => page.props.site?.logo ? `/storage/${page.props.site.logo}` : null);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/admin', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin - Iniciar sesión" />

    <div class="min-h-screen flex bg-stone-50 font-sans">
        <!-- Brand panel -->
        <div class="hidden lg:flex lg:w-1/2 bg-stone-900 text-white relative overflow-hidden flex-col justify-between p-16">
            <div class="absolute inset-0 opacity-5"
                 style="background-image: url('data:image/svg+xml,%3Csvg width=\'120\' height=\'120\' viewBox=\'0 0 120 120\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M10,10 h100 v100 h-100 v-100 M30,30 h60 v60 h-60 v-60 M50,50 h20 v20 h-20 v-20\' stroke=\'%23ffffff\' stroke-width=\'2\' fill=\'none\' stroke-linejoin=\'miter\'/%3E%3C/svg%3E'); background-size: 60px 60px;">
            </div>

            <div class="relative z-10">
                <img v-if="siteLogo" :src="siteLogo" :alt="siteName" class="h-14 w-auto" />
                <span v-else class="text-3xl font-black tracking-wider text-orange-500 uppercase">{{ siteName }}</span>
            </div>

            <div class="relative z-10">
                <div class="w-16 h-1 bg-orange-500 mb-8"></div>
                <h1 class="text-4xl xl:text-5xl font-black uppercase leading-tight mb-6">
                    Bienvenido<br />de vuelta
                </h1>
                <p class="text-stone-400 text-lg font-light max-w-sm">
                    Gestiona productos, marca y mensajes de {{ siteName }} desde un solo lugar.
                </p>
            </div>

            <div class="relative z-10 text-stone-500 text-xs uppercase tracking-[0.3em]">
                Loreto, Perú
            </div>
        </div>

        <!-- Form panel -->
        <div class="flex-1 flex items-center justify-center px-6 py-16 sm:px-12">
            <div class="w-full max-w-sm">
                <div class="lg:hidden text-center mb-10">
                    <img v-if="siteLogo" :src="siteLogo" :alt="siteName" class="h-12 w-auto mx-auto mb-3" />
                    <span v-else class="text-3xl font-black tracking-wider text-orange-500 uppercase">{{ siteName }}</span>
                </div>

                <h2 class="text-2xl font-bold text-stone-900 mb-1">Iniciar sesión</h2>
                <p class="text-stone-500 text-sm mb-8">Ingresa tus credenciales para acceder al panel.</p>

                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Correo electrónico</label>
                        <input v-model="form.email" type="email" required autofocus
                            class="w-full py-2.5 px-3 border border-stone-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                        <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-stone-700 mb-1">Contraseña</label>
                        <input v-model="form.password" type="password" required
                            class="w-full py-2.5 px-3 border border-stone-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500" />
                        <p v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</p>
                    </div>

                    <label class="flex items-center gap-2">
                        <input v-model="form.remember" type="checkbox" class="rounded border-stone-300 text-orange-600 focus:ring-orange-500" />
                        <span class="text-sm text-stone-600">Recordarme</span>
                    </label>

                    <button type="submit" :disabled="form.processing"
                        class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-md transition-colors disabled:opacity-50 uppercase tracking-widest text-sm">
                        Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
