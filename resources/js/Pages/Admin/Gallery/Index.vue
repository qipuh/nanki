<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AdminLayout from '../../../Layouts/AdminLayout.vue';

defineOptions({ layout: AdminLayout });

const props = defineProps({
    images: Array,
});

const images = ref([...props.images]);
const isDragOver = ref(false);
const uploading = ref(0);
const fileInput = ref(null);
const dragIndex = ref(null);

const uploadFiles = async (fileList) => {
    const files = [...fileList].filter((f) => f.type.startsWith('image/'));

    for (const file of files) {
        uploading.value++;
        const formData = new FormData();
        formData.append('image', file);

        try {
            const { data } = await axios.post('/admin/galeria', formData);
            images.value.push(data);
        } catch (e) {
            alert(`No se pudo subir "${file.name}".`);
        } finally {
            uploading.value--;
        }
    }
};

const onDrop = (e) => {
    isDragOver.value = false;
    uploadFiles(e.dataTransfer.files);
};

const onFilePick = (e) => {
    uploadFiles(e.target.files);
    e.target.value = '';
};

const saveOrder = () => {
    axios.patch('/admin/galeria/reorder', { ids: images.value.map((i) => i.id) });
};

const onDragStart = (index) => {
    dragIndex.value = index;
};

const onDropReorder = (index) => {
    if (dragIndex.value === null || dragIndex.value === index) return;
    const item = images.value.splice(dragIndex.value, 1)[0];
    images.value.splice(index, 0, item);
    dragIndex.value = null;
    saveOrder();
};

const toggleActive = (image) => {
    image.active = !image.active;
    axios.patch(`/admin/galeria/${image.id}`, { active: image.active });
};

const destroy = (image) => {
    if (!confirm('¿Eliminar esta imagen?')) return;
    axios.delete(`/admin/galeria/${image.id}`);
    images.value = images.value.filter((i) => i.id !== image.id);
};
</script>

<template>
    <Head title="Admin - Galería" />

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-stone-900">Galería</h1>
        <p class="text-stone-500 text-sm mt-1">Arrastra imágenes para subirlas. Arrastra las miniaturas para reordenarlas.</p>
    </div>

    <!-- Dropzone -->
    <div
        @dragover.prevent="isDragOver = true"
        @dragleave.prevent="isDragOver = false"
        @drop.prevent="onDrop"
        @click="fileInput.click()"
        class="border-2 border-dashed rounded-xl p-12 text-center cursor-pointer transition-colors mb-8"
        :class="isDragOver ? 'border-orange-500 bg-orange-50' : 'border-stone-300 bg-white hover:border-orange-400 hover:bg-stone-50'"
    >
        <svg class="w-10 h-10 mx-auto mb-3 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p class="text-stone-600 font-medium">Arrastra imágenes aquí o haz clic para elegir</p>
        <p class="text-stone-400 text-sm mt-1">PNG o JPG, hasta 12MB c/u</p>
        <p v-if="uploading > 0" class="text-orange-600 text-sm font-medium mt-3">Subiendo {{ uploading }}...</p>
        <input ref="fileInput" type="file" accept="image/*" multiple class="hidden" @change="onFilePick" />
    </div>

    <div v-if="images.length === 0" class="text-center text-stone-400 py-12">
        No hay imágenes todavía.
    </div>

    <div v-else class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
        <div v-for="(image, index) in images" :key="image.id"
            draggable="true"
            @dragstart="onDragStart(index)"
            @dragover.prevent
            @drop="onDropReorder(index)"
            class="bg-white rounded-lg shadow overflow-hidden cursor-move"
            :class="{ 'opacity-40': dragIndex === index }"
        >
            <div class="relative h-40 bg-stone-100 flex items-center justify-center p-4">
                <img :src="`/storage/${image.image}`" alt="" class="max-h-full max-w-full object-contain pointer-events-none" />
                <button @click.stop="toggleActive(image)"
                    class="absolute top-2 left-2 px-2 py-0.5 rounded-full text-xs font-medium transition-colors"
                    :class="image.active ? 'bg-green-100 text-green-800' : 'bg-stone-200 text-stone-600'">
                    {{ image.active ? 'Activa' : 'Inactiva' }}
                </button>
                <button @click.stop="destroy(image)"
                    class="absolute top-2 right-2 w-7 h-7 flex items-center justify-center rounded-full bg-white/90 text-red-600 hover:bg-red-600 hover:text-white transition-colors shadow">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>
</template>
