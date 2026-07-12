<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '../../../Layouts/AdminLayout.vue';
import RichTextEditor from '../../../Components/RichTextEditor.vue';
import ImagePicker from '../../../Components/ImagePicker.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    slide: Object,
});

const isEdit = computed(() => !!props.slide);

const positions = [
    { value: 'left', label: 'Izquierda' },
    { value: 'center', label: 'Centro' },
    { value: 'right', label: 'Derecha' },
];

const form = useForm({
    title: props.slide?.title ?? '',
    description: props.slide?.description ?? '',
    button_text: props.slide?.button_text ?? '',
    button_link: props.slide?.button_link ?? '',
    text_position: props.slide?.text_position ?? 'center',
    text_align: props.slide?.text_align ?? 'center',
    active: props.slide?.active ?? true,
    order: props.slide?.order ?? 0,
    image: null,
    _method: isEdit.value ? 'put' : 'post',
});

const submit = () => {
    const url = isEdit.value ? `/admin/slides/${props.slide.id}` : '/admin/slides';
    form.post(url, { forceFormData: true });
};
</script>

<template>
    <Head :title="isEdit ? 'Admin - Editar slide' : 'Admin - Nuevo slide'" />

    <h1 class="text-2xl font-bold text-stone-900 mb-6">
        {{ isEdit ? 'Editar slide' : 'Nuevo slide' }}
    </h1>

    <form @submit.prevent="submit" class="bg-white rounded-lg shadow p-8 max-w-3xl space-y-6">
        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Título</label>
            <input v-model="form.title" type="text" required class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            <p v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Descripción</label>
            <RichTextEditor v-model="form.description" placeholder="Descripción del slide..." />
            <p v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Texto del botón <span class="text-stone-400 font-normal">(opcional)</span></label>
                <input v-model="form.button_text" type="text" placeholder="Ej. Explorar" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Enlace del botón <span class="text-stone-400 font-normal">(opcional)</span></label>
                <input v-model="form.button_link" type="text" placeholder="/productos" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
                <p class="text-xs text-stone-400 mt-1">Ruta interna (/productos, /contacto) o URL externa. Si dejas alguno vacío, no se muestra botón.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-2">Posición del texto</label>
                <div class="flex gap-2">
                    <button v-for="pos in positions" :key="pos.value" type="button"
                        @click="form.text_position = pos.value"
                        class="flex-1 py-2 px-3 text-sm rounded-md border transition-colors"
                        :class="form.text_position === pos.value ? 'bg-orange-600 border-orange-600 text-white' : 'border-stone-300 text-stone-600 hover:bg-stone-50'">
                        {{ pos.label }}
                    </button>
                </div>
                <p class="text-xs text-stone-400 mt-1">En qué parte de la imagen aparece el bloque de texto.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-2">Alineación del texto</label>
                <div class="flex gap-2">
                    <button v-for="pos in positions" :key="pos.value" type="button"
                        @click="form.text_align = pos.value"
                        class="flex-1 py-2 px-3 text-sm rounded-md border transition-colors"
                        :class="form.text_align === pos.value ? 'bg-orange-600 border-orange-600 text-white' : 'border-stone-300 text-stone-600 hover:bg-stone-50'">
                        {{ pos.label }}
                    </button>
                </div>
                <p class="text-xs text-stone-400 mt-1">Alineación del título y descripción dentro del bloque.</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-stone-700 mb-1">Orden</label>
                <input v-model="form.order" type="number" min="0" class="w-full py-2.5 px-3 border border-stone-300 rounded-md focus:ring-orange-500 focus:border-orange-500" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-stone-700 mb-1">Imagen de fondo</label>
            <ImagePicker v-model="form.image" :current="slide?.image" image-class="h-40 w-full max-w-md object-cover rounded" />
            <p v-if="form.errors.image" class="text-red-600 text-sm mt-1">{{ form.errors.image }}</p>
        </div>

        <label class="flex items-center gap-2">
            <input v-model="form.active" type="checkbox" class="rounded border-stone-300 text-orange-600 focus:ring-orange-500" />
            <span class="text-sm font-medium text-stone-700">Slide activo (visible en el inicio)</span>
        </label>

        <div class="flex gap-3 pt-2">
            <button type="submit" :disabled="form.processing" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-md transition-colors disabled:opacity-50">
                Guardar
            </button>
            <a href="/admin/slides" class="px-6 py-2.5 border border-stone-300 text-stone-700 text-sm font-medium rounded-md hover:bg-stone-50 transition-colors">
                Cancelar
            </a>
        </div>
    </form>
</template>
