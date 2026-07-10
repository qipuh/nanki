<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    settings: Object,
});

const form = useForm({
    site_name: props.settings.site_name,
    logo: null,
    remove_logo: false,
    _method: 'post',
});

const submit = () => {
    form.post('/admin/marca', { forceFormData: true });
};
</script>

<template>
    <Head title="Admin - Marca" />

    <h1 class="text-2xl font-bold text-stone-900 font-outfit mb-6">Marca</h1>

    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-8 max-w-2xl space-y-6">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Nombre de la web</label>
            <input v-model="form.site_name" type="text" required class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            <p v-if="form.errors.site_name" class="text-red-600 text-sm mt-1">{{ form.errors.site_name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-2">Logo</label>
            <div class="flex items-center gap-4 mb-3">
                <img v-if="settings.site_logo" :src="`/storage/${settings.site_logo}`" class="h-16 w-16 object-contain bg-stone-100 rounded p-1" />
                <span v-else class="text-stone-400 text-sm">Sin logo (se muestra el nombre en texto)</span>
            </div>
            <input @input="form.logo = $event.target.files[0]" type="file" accept="image/*" class="w-full text-sm" />
            <p v-if="form.errors.logo" class="text-red-600 text-sm mt-1">{{ form.errors.logo }}</p>

            <label v-if="settings.site_logo" class="flex items-center gap-2 mt-3">
                <input v-model="form.remove_logo" type="checkbox" class="rounded border-stone-300 text-orange-600 focus:ring-orange-500" />
                <span class="text-sm text-stone-600">Quitar logo actual</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" :disabled="form.processing" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors disabled:opacity-50">
                Guardar cambios
            </button>
        </div>
    </form>
</template>
