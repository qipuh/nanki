<script setup>
import { onMounted, onUnmounted } from 'vue';

const props = defineProps({
    images: {
        type: Array,
        required: true,
    },
    index: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(['close', 'update:index']);

const next = () => emit('update:index', (props.index + 1) % props.images.length);
const prev = () => emit('update:index', (props.index - 1 + props.images.length) % props.images.length);

const onKeydown = (e) => {
    if (e.key === 'Escape') emit('close');
    if (e.key === 'ArrowRight') next();
    if (e.key === 'ArrowLeft') prev();
};

onMounted(() => {
    document.addEventListener('keydown', onKeydown);
    document.body.style.overflow = 'hidden';
});

onUnmounted(() => {
    document.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <div class="fixed inset-0 z-[100] bg-black/90 backdrop-blur-sm flex flex-col items-center justify-center p-4 sm:p-8"
            @click.self="$emit('close')">
            <button @click="$emit('close')" aria-label="Cerrar"
                class="absolute top-4 right-4 sm:top-6 sm:right-6 w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <!-- Foto principal -->
            <div class="relative flex-1 min-h-0 w-full flex items-center justify-center">
                <button v-if="images.length > 1" @click.stop="prev" aria-label="Anterior"
                    class="absolute left-0 sm:left-4 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>

                <img :src="images[index].src" :alt="images[index].alt" class="max-w-full max-h-full object-contain select-none" @click.stop />

                <button v-if="images.length > 1" @click.stop="next" aria-label="Siguiente"
                    class="absolute right-0 sm:right-4 top-1/2 -translate-y-1/2 w-11 h-11 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>

            <p v-if="images[index].caption" class="text-white/90 text-sm font-medium tracking-wide text-center px-4 mt-4 shrink-0">
                {{ images[index].caption }}
            </p>

            <!-- Miniaturas -->
            <div v-if="images.length > 1" class="w-full max-w-3xl mt-4 shrink-0" @click.stop>
                <div class="flex gap-2 overflow-x-auto justify-center pb-1">
                    <button v-for="(img, i) in images" :key="i" @click="$emit('update:index', i)"
                        class="shrink-0 w-16 h-16 rounded-md overflow-hidden border-2 transition-colors"
                        :class="i === index ? 'border-orange-500' : 'border-transparent opacity-60 hover:opacity-100'">
                        <img :src="img.src" :alt="img.alt" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>
        </div>
    </Teleport>
</template>
