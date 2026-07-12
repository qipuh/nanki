<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '../../../Layouts/AdminLayout.vue';
import ImagePicker from '../../../Components/ImagePicker.vue';
import FairGalleryManager from '../../../Components/Admin/FairGalleryManager.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    fair: Object,
});

const isEdit = computed(() => !!props.fair);

const form = useForm({
    title: props.fair?.title ?? '',
    description: props.fair?.description ?? '',
    active: props.fair?.active ?? true,
    order: props.fair?.order ?? 0,
    image: null,
    _method: isEdit.value ? 'put' : 'post',
});

const submit = () => {
    const url = isEdit.value ? `/admin/ferias/${props.fair.id}` : '/admin/ferias';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <Head :title="isEdit ? 'Admin - Editar feria' : 'Admin - Nueva feria'" />

    <h1 class="text-2xl font-bold text-stone-900 mb-6">
        {{ isEdit ? 'Editar feria' : 'Nueva feria' }}
    </h1>

    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-8 max-w-2xl space-y-6 mb-8">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Título</label>
            <input v-model="form.title" type="text" required class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            <p v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Descripción corta</label>
            <textarea v-model="form.description" rows="3" maxlength="500" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500"></textarea>
            <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Foto principal</label>
            <ImagePicker v-model="form.image" :current="fair?.image" image-class="h-40 w-full max-w-sm object-cover rounded" />
            <p v-if="form.errors.image" class="text-red-600 text-sm mt-1">{{ form.errors.image }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Orden</label>
            <input v-model="form.order" type="number" min="0" class="w-40 py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
        </div>

        <label class="flex items-center gap-2">
            <input v-model="form.active" type="checkbox" class="rounded border-stone-300 text-orange-600 focus:ring-orange-500" />
            <span class="text-sm font-medium text-stone-700">Feria activa (visible en la web)</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" :disabled="form.processing" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors disabled:opacity-50">
                Guardar
            </button>
            <a href="/admin/ferias" class="px-6 py-2.5 border border-stone-300 text-stone-700 text-sm font-medium rounded-md hover:bg-stone-50 transition-colors">
                Cancelar
            </a>
        </div>
    </form>

    <div v-if="isEdit" class="bg-white rounded-lg shadow p-8 max-w-3xl">
        <h2 class="text-lg font-semibold text-stone-900 mb-1">Galería de la feria</h2>
        <p class="text-stone-500 text-sm mb-5">Si agregas fotos aquí, en la web se mostrará un botón para verlas en una galería modal.</p>
        <FairGalleryManager :fair-id="fair.id" :images="fair.images" />
    </div>
    <div v-else class="bg-stone-100 border border-dashed border-stone-300 rounded-lg p-8 max-w-3xl text-center text-stone-500 text-sm">
        Guarda la feria primero para poder agregarle una galería de fotos.
    </div>
</template>
