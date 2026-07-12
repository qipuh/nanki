<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, computed, onMounted, onUnmounted } from 'vue';

const props = defineProps({
    slides: {
        type: Array,
        default: () => [],
    },
    autoplayMs: {
        type: Number,
        default: 6000,
    },
});

const current = ref(0);
let timer = null;

const hasSlides = computed(() => props.slides.length > 0);

const go = (index) => {
    current.value = (index + props.slides.length) % props.slides.length;
};

const next = () => go(current.value + 1);
const prev = () => go(current.value - 1);

const startAutoplay = () => {
    stopAutoplay();
    if (props.slides.length > 1) {
        timer = setInterval(next, props.autoplayMs);
    }
};

const stopAutoplay = () => {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
};

onMounted(startAutoplay);
onUnmounted(stopAutoplay);

const positionClass = {
    left: 'items-center justify-start text-left',
    center: 'items-center justify-center text-center',
    right: 'items-center justify-end text-right',
};

const alignClass = {
    left: 'text-left items-start',
    center: 'text-center items-center',
    right: 'text-right items-end',
};

const isExternal = (link) => /^https?:\/\//.test(link ?? '');

const overlayGradient = {
    left: 'linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.35) 30%, rgba(0,0,0,0) 60%)',
    right: 'linear-gradient(to left, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.35) 30%, rgba(0,0,0,0) 60%)',
    center: 'radial-gradient(ellipse at center, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 30%, rgba(0,0,0,0) 60%)',
};

const overlayStyle = (position) => ({
    backgroundImage: overlayGradient[position] ?? overlayGradient.center,
});
</script>

<template>
    <!-- Slider dinámico -->
    <div v-if="hasSlides" class="relative min-h-[75vh] overflow-hidden border-b border-stone-200"
        @mouseenter="stopAutoplay" @mouseleave="startAutoplay">
        <div v-for="(slide, index) in slides" :key="slide.id"
            class="absolute inset-0 bg-cover bg-center transition-opacity duration-700"
            :class="index === current ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'"
            :style="{ backgroundImage: `url('/storage/${slide.image}')` }">
            <div class="absolute inset-0" :style="overlayStyle(slide.text_position)"></div>

            <div class="relative z-10 h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex"
                :class="positionClass[slide.text_position] ?? positionClass.center">
                <div class="max-w-2xl flex flex-col"
                    :class="alignClass[slide.text_align] ?? alignClass.center">
                    <h2 class="text-4xl sm:text-5xl md:text-6xl font-black font-outfit tracking-wide text-white leading-tight mb-4">
                        {{ slide.title }}
                    </h2>
                    <div v-if="slide.description" class="text-white/90 text-lg font-light mb-8 prose-sm [&_a]:underline"
                        v-html="slide.description"></div>
                    <component v-if="slide.button_text && slide.button_link"
                        :is="isExternal(slide.button_link) ? 'a' : Link"
                        :href="slide.button_link"
                        :target="isExternal(slide.button_link) ? '_blank' : undefined"
                        :rel="isExternal(slide.button_link) ? 'noopener' : undefined"
                        class="inline-flex items-center justify-center px-8 py-4 border border-orange-500 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 hover:border-orange-600 transition-all uppercase tracking-widest shadow-sm w-fit">
                        {{ slide.button_text }}
                    </component>
                </div>
            </div>
        </div>

        <!-- Controles -->
        <template v-if="slides.length > 1">
            <button @click="prev" aria-label="Anterior"
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 text-white rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="next" aria-label="Siguiente"
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/40 text-white rounded-full transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                <button v-for="(slide, index) in slides" :key="slide.id" @click="go(index)"
                    class="w-2.5 h-2.5 rounded-full transition-all"
                    :class="index === current ? 'bg-white w-8' : 'bg-white/50 hover:bg-white/80'"
                    :aria-label="`Ir al slide ${index + 1}`"></button>
            </div>
        </template>
    </div>

    <!-- Hero por defecto (sin slides configurados) -->
    <div v-else class="relative bg-white overflow-hidden min-h-[75vh] flex flex-col justify-center border-b border-stone-200">
        <div class="absolute inset-0 pointer-events-none"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'80\' height=\'80\' viewBox=\'0 0 80 80\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' stroke=\'%23f3f4f6\' stroke-width=\'1.5\'%3E%3Cpath d=\'M40 0l40 40-40 40L0 40z\'/%3E%3Cpath d=\'M40 15l25 25-25 25L15 40z\'/%3E%3C/g%3E%3C/svg%3E'); background-size: 80px 80px; background-position: center;">
        </div>

        <div class="relative max-w-7xl mx-auto py-32 px-4 sm:py-40 sm:px-6 lg:px-8 flex flex-col items-center text-center z-10 w-full">
            <h1 class="text-7xl sm:text-8xl md:text-[10rem] font-black tracking-wide text-black font-outfit leading-none">
                NANKI
            </h1>
            <div class="w-full max-w-[280px] sm:max-w-[400px] md:max-w-[500px] h-1 bg-orange-500 mt-4 mb-8"></div>
            <p class="text-sm sm:text-lg text-stone-500 font-medium tracking-[0.4em] uppercase">
                Loreto, Perú
            </p>
            <div class="mt-16 sm:flex sm:justify-center gap-6">
                <Link href="/productos" class="flex items-center justify-center px-8 py-4 border border-orange-500 text-sm font-medium rounded-none text-white bg-orange-500 hover:bg-orange-600 hover:border-orange-600 transition-all uppercase tracking-widest shadow-sm">
                    Explorar
                </Link>
                <Link href="/nosotros/historia" class="flex items-center justify-center px-8 py-4 border border-stone-300 text-sm font-medium rounded-none text-stone-600 hover:bg-stone-50 hover:text-black transition-all uppercase tracking-widest mt-4 sm:mt-0 shadow-sm bg-white">
                    Nuestra Raíz
                </Link>
            </div>
        </div>
    </div>
</template>
