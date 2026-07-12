<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '../../../Layouts/AdminLayout.vue';
import ImagePicker from '../../../Components/ImagePicker.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    product: Object,
});

const isEdit = computed(() => !!props.product);

const form = useForm({
    name: props.product?.name ?? '',
    tagline: props.product?.tagline ?? '',
    description: props.product?.description ?? '',
    price: props.product?.price ?? '',
    active: props.product?.active ?? true,
    order: props.product?.order ?? 0,
    image: null,
    _method: isEdit.value ? 'put' : 'post',
});

const submit = () => {
    const url = isEdit.value ? `/admin/productos/${props.product.id}` : '/admin/productos';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <Head :title="isEdit ? 'Admin - Editar producto' : 'Admin - Nuevo producto'" />

    <h1 class="text-2xl font-bold text-stone-900 mb-6">
        {{ isEdit ? 'Editar producto' : 'Nuevo producto' }}
    </h1>

    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-8 max-w-2xl space-y-6">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Nombre</label>
            <input v-model="form.name" type="text" required class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Frase corta (tagline)</label>
            <input v-model="form.tagline" type="text" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Descripción</label>
            <textarea v-model="form.description" rows="4" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Precio (S/)</label>
                <input v-model="form.price" type="number" step="0.01" min="0" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Orden</label>
                <input v-model="form.order" type="number" min="0" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Imagen</label>
            <ImagePicker v-model="form.image" :current="product?.image" image-class="h-32 w-32 object-cover rounded" />
            <p v-if="form.errors.image" class="text-red-600 text-sm mt-1">{{ form.errors.image }}</p>
        </div>

        <label class="flex items-center gap-2">
            <input v-model="form.active" type="checkbox" class="rounded border-stone-300 text-orange-600 focus:ring-orange-500" />
            <span class="text-sm font-medium text-stone-700">Producto activo (visible en la web)</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" :disabled="form.processing" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors disabled:opacity-50">
                Guardar
            </button>
            <a href="/admin/productos" class="px-6 py-2.5 border border-stone-300 text-stone-700 text-sm font-medium rounded-md hover:bg-stone-50 transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</template>
