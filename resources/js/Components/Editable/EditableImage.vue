<script setup>
import { ref, inject, watch } from 'vue';

const props = defineProps({
    settingKey: {
        type: String,
        required: true,
    },
    src: {
        type: String,
        required: true,
    },
    imgClass: {
        type: String,
        default: '',
    },
    wrapperClass: {
        type: String,
        default: '',
    },
    alt: {
        type: String,
        default: '',
    },
});

const emit = defineEmits(['update']);

const editMode = inject('editMode', ref(false));
const fileInput = ref(null);
const localSrc = ref(props.src);
const uploading = ref(false);
const pickerOpen = ref(false);
const media = ref(null);
const loadingMedia = ref(false);

watch(() => props.src, (value) => {
    localSrc.value = value;
});

const openPicker = () => {
    if (!editMode.value) return;
    pickerOpen.value = true;
    if (media.value === null) loadMedia();
};

const loadMedia = async () => {
    loadingMedia.value = true;
    try {
        const { data } = await axios.get('/admin/contenido-inicio/media');
        media.value = data;
    } finally {
        loadingMedia.value = false;
    }
};

const selectExisting = async (item) => {
    pickerOpen.value = false;
    const previous = localSrc.value;
    localSrc.value = item.url;

    try {
        const { data } = await axios.post('/admin/contenido-inicio/imagen', { key: props.settingKey, path: item.path });
        localSrc.value = `/storage/${data.path}`;
        emit('update', data.path);
    } catch (err) {
        alert('No se pudo actualizar la imagen.');
        localSrc.value = previous;
    }
};

const triggerUpload = () => {
    pickerOpen.value = false;
    fileInput.value.click();
};

const onChange = async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const previewUrl = URL.createObjectURL(file);
    localSrc.value = previewUrl;
    uploading.value = true;

    const formData = new FormData();
    formData.append('key', props.settingKey);
    formData.append('image', file);

    try {
        const { data } = await axios.post('/admin/contenido-inicio/imagen', formData);
        localSrc.value = `/storage/${data.path}`;
        emit('update', data.path);
        media.value = null; // force refresh next time picker opens
    } catch (err) {
        alert('No se pudo subir la imagen.');
        localSrc.value = props.src;
    } finally {
        URL.revokeObjectURL(previewUrl);
        uploading.value = false;
        e.target.value = '';
    }
};
</script>

<template>
    <div :class="[wrapperClass, editMode ? 'group cursor-pointer' : '']" @click="openPicker">
        <img :src="localSrc" :alt="alt" :class="imgClass" />
        <div v-if="editMode" class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-colors flex items-center justify-center rounded-sm ring-1 ring-dashed ring-orange-400/70">
            <span class="opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-medium bg-black/70 px-3 py-1.5 rounded-full flex items-center gap-1.5 whitespace-nowrap">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                {{ uploading ? 'Subiendo...' : 'Cambiar imagen' }}
            </span>
        </div>
        <input ref="fileInput" type="file" accept="image/*" class="hidden" @change="onChange" @click.stop />

        <Teleport to="body">
            <div v-if="pickerOpen" class="fixed inset-0 z-[100] bg-black/60 flex items-center justify-center p-4" @click.self="pickerOpen = false">
                <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col" @click.stop>
                    <div class="flex items-center justify-between px-6 py-4 border-b border-stone-100 shrink-0">
                        <h3 class="font-semibold text-stone-900">Elegir imagen</h3>
                        <button @click="pickerOpen = false" class="text-stone-400 hover:text-stone-600" aria-label="Cerrar">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto">
                        <button @click="triggerUpload" type="button"
                            class="w-full mb-5 border-2 border-dashed border-stone-300 hover:border-orange-400 hover:bg-orange-50 rounded-lg py-4 text-sm font-medium text-stone-600 hover:text-orange-600 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Subir imagen nueva
                        </button>

                        <p class="text-xs font-medium text-stone-400 uppercase tracking-wide mb-3">Imágenes guardadas</p>

                        <div v-if="loadingMedia" class="text-center text-stone-400 py-8 text-sm">Cargando...</div>
                        <div v-else-if="media && media.length === 0" class="text-center text-stone-400 py-8 text-sm">
                            No hay imágenes en la galería todavía. Súbelas desde "Galería" en el panel, o usa el botón de arriba.
                        </div>
                        <div v-else class="grid grid-cols-3 sm:grid-cols-4 gap-3">
                            <button v-for="item in media" :key="item.id" @click="selectExisting(item)" type="button"
                                class="aspect-square bg-stone-100 rounded-lg overflow-hidden border-2 border-transparent hover:border-orange-500 transition-colors">
                                <img :src="item.url" class="w-full h-full object-contain" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </div>
</template>
