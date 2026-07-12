<script setup>
import { ref } from 'vue';

const props = defineProps({
    fairId: {
        type: Number,
        required: true,
    },
    images: {
        type: Array,
        default: () => [],
    },
});

const items = ref([...props.images]);
const isDragOver = ref(false);
const uploading = ref(0);
const fileInput = ref(null);
const dragIndex = ref(null);

const base = () => `/admin/ferias/${props.fairId}/imagenes`;

const uploadFiles = async (fileList) => {
    const files = [...fileList].filter((f) => f.type.startsWith('image/'));

    for (const file of files) {
        uploading.value++;
        const formData = new FormData();
        formData.append('image', file);

        try {
            const { data } = await axios.post(base(), formData);
            items.value.push(data);
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
    axios.patch(`${base()}/reorder`, { ids: items.value.map((i) => i.id) });
};

const onDragStart = (index) => {
    dragIndex.value = index;
};

const onDropReorder = (index) => {
    if (dragIndex.value === null || dragIndex.value === index) return;
    const item = items.value.splice(dragIndex.value, 1)[0];
    items.value.splice(index, 0, item);
    dragIndex.value = null;
    saveOrder();
};

const destroy = (image) => {
    if (!confirm('¿Eliminar esta imagen de la galería?')) return;
    axios.delete(`${base()}/${image.id}`);
    items.value = items.value.filter((i) => i.id !== image.id);
};
</script>

<template>
    <div>
        <div
            @dragover.prevent="isDragOver = true"
            @dragleave.prevent="isDragOver = false"
            @drop.prevent="onDrop"
            @click="fileInput.click()"
            class="border-2 border-dashed rounded-xl p-8 text-center cursor-pointer transition-colors mb-6"
            :class="isDragOver ? 'border-orange-500 bg-orange-50' : 'border-stone-300 bg-white hover:border-orange-400 hover:bg-stone-50'"
        >
            <svg class="w-8 h-8 mx-auto mb-2 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <p class="text-stone-600 text-sm font-medium">Arrastra fotos aquí o haz clic para elegir</p>
            <p v-if="uploading > 0" class="text-orange-600 text-sm font-medium mt-2">Subiendo {{ uploading }}...</p>
            <input ref="fileInput" type="file" accept="image/*" multiple class="hidden" @change="onFilePick" />
        </div>

        <div v-if="items.length" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
            <div v-for="(image, index) in items" :key="image.id"
                draggable="true"
                @dragstart="onDragStart(index)"
                @dragover.prevent
                @drop="onDropReorder(index)"
                class="relative aspect-square bg-stone-100 rounded-lg overflow-hidden cursor-move group"
                :class="{ 'opacity-40': dragIndex === index }"
            >
                <img :src="`/storage/${image.image}`" class="w-full h-full object-cover pointer-events-none" />
                <button @click.stop="destroy(image)"
                    class="absolute top-1.5 right-1.5 w-6 h-6 flex items-center justify-center rounded-full bg-white/90 text-red-600 opacity-0 group-hover:opacity-100 hover:bg-red-600 hover:text-white transition-all shadow">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <p v-else class="text-stone-400 text-sm">Sin fotos en la galería todavía.</p>
    </div>
</template>
