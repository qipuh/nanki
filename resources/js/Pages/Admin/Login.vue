<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/admin/login', {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Admin - Iniciar sesión" />
    <div class="min-h-screen flex items-center justify-center bg-stone-900 px-4">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <span class="text-4xl font-black font-outfit tracking-wider text-orange-500">NANKI</span>
                <p class="text-stone-400 text-sm mt-2 uppercase tracking-widest">Panel de administración</p>
            </div>
            <form @submit.prevent="submit" class="bg-white rounded-lg shadow-xl p-8 space-y-5">
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
                <button type="submit" :disabled="form.processing"
                    class="w-full py-3 px-4 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-md transition-colors disabled:opacity-50">
                    Ingresar
                </button>
            </form>
        </div>
    </div>
</template>
