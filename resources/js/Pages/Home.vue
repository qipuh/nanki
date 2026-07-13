<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed, reactive, inject, ref } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import HeroSlider from '../Components/HeroSlider.vue';
import KeneMotif from '../Components/KeneMotif.vue';
import BrandCaption from '../Components/BrandCaption.vue';
import ImageGallery from '../Components/ImageGallery.vue';
import EditableText from '../Components/Editable/EditableText.vue';
import EditableImage from '../Components/Editable/EditableImage.vue';
import { addToCart } from '../cart';

defineOptions({ layout: AppLayout })

const props = defineProps({
    slides: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
    gallery: {
        type: Array,
        default: () => [],
    },
    content: {
        type: Object,
        default: () => ({}),
    },
});

const galleryImages = computed(() => props.gallery.map((item) => ({
    src: `/storage/${item.image}`,
    alt: item.alt ?? '',
    caption: item.caption ?? '',
})));

const c = reactive({ ...props.content });

const justAdded = reactive(new Set());

const add = (product) => {
    addToCart(product);
    justAdded.add(product.id);
    setTimeout(() => justAdded.delete(product.id), 1500);
};

const img = (key, fallback) => c[key] ? `/storage/${c[key]}` : fallback;

const editMode = inject('editMode', ref(false));
</script>

<template>
    <Head title="Inicio - Nanki" />

    <!-- Hero Slider -->
    <HeroSlider :slides="slides" />

    <!-- Separador Kené -->
    <div class="w-full h-[250px] max-h-[250px] bg-white opacity-15"
        style="background-image: url('/images/patron.png'); background-repeat: repeat-x; background-size: auto 250px; background-position: top center;
               -webkit-mask-image: linear-gradient(to bottom, black 0%, black 40%, transparent 90%);
               mask-image: linear-gradient(to bottom, black 0%, black 40%, transparent 90%);"></div>

    <!-- About Snippet -->
    <section class="py-24 relative overflow-hidden -mt-64">
        <KeneMotif class="hidden md:block absolute top-16 -left-6 w-28 h-28 text-stone-900 opacity-[0.06] animate-float pointer-events-none select-none" />
        <KeneMotif class="hidden md:block absolute bottom-10 right-8 w-20 h-20 text-orange-500 opacity-[0.08] animate-float-slow pointer-events-none select-none" style="animation-delay: 1.2s" />
        <EditableImage setting-key="home_about_float_image" :src="img('home_about_float_image', '/images/1.png')"
            wrapper-class="hidden 2xl:block absolute top-20 right-6 w-36 animate-float" img-class="w-full drop-shadow-xl pointer-events-none select-none" style="animation-delay: 0.4s" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-2 lg:gap-20 items-center">
                <div class="relative group p-4">
                    <!-- Marco sobrio -->
                    <div class="absolute inset-0 bg-stone-200 translate-x-4 translate-y-4"></div>
                    <div class="relative h-full min-h-[400px] border border-stone-200 shadow-sm overflow-hidden">
                        <EditableImage setting-key="home_about_image" :src="img('home_about_image', '/images/1.png')"
                            alt="Ají charapita" wrapper-class="absolute inset-0" img-class="w-full h-full object-cover" />
                        <BrandCaption />
                    </div>
                </div>
                <div class="mt-16 lg:mt-0">
                    <h2 class="text-3xl font-black text-black tracking-wide sm:text-4xl font-outfit">
                        <EditableText setting-key="home_about_title" v-model="c.home_about_title" />
                        <EditableText setting-key="home_about_title_highlight" v-model="c.home_about_title_highlight" class="text-orange-500" />
                    </h2>
                    <div class="flex items-center gap-3 mt-6 mb-8">
                        <span class="w-10 h-px bg-orange-500"></span>
                        <KeneMotif class="w-5 h-5 text-orange-500" />
                        <span class="w-10 h-px bg-orange-500"></span>
                    </div>
                    <EditableText setting-key="home_about_paragraph_1" v-model="c.home_about_paragraph_1" tag="p" class="block text-lg text-stone-700 mb-6 font-light" />
                    <EditableText setting-key="home_about_paragraph_2" v-model="c.home_about_paragraph_2" tag="p" class="block text-lg text-stone-600 mb-10 font-light" />
                    <component :is="editMode ? 'span' : Link" :href="editMode ? undefined : (c.home_about_link_url || '/nosotros/historia')"
                        class="inline-flex items-center text-orange-600 font-medium hover:text-orange-700 uppercase tracking-widest text-sm transition-colors group">
                        <EditableText setting-key="home_about_link_text" v-model="c.home_about_link_text" />
                        <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </component>
                </div>
            </div>
        </div>
    </section>
    <div class="hidden md:block relative z-20 max-w-7xl mx-auto px-6">
        <EditableImage setting-key="home_jar_float_image" :src="img('home_jar_float_image', '/images/5.png')"
            wrapper-class="absolute -top-14 left-0 -translate-x-[calc(50%+50px)] w-40 animate-float" img-class="w-full drop-shadow-1xl pointer-events-none select-none" />
    </div>
    <!-- Productos - Estilo Galería Limpia -->
    <section class="py-24 bg-white relative border-t border-stone-100 overflow-hidden">
        <KeneMotif class="hidden lg:block absolute top-24 right-10 w-24 h-24 text-orange-500 opacity-[0.07] animate-float pointer-events-none select-none" style="animation-delay: 0.6s" />
        <KeneMotif class="hidden lg:block absolute bottom-16 -left-8 w-32 h-32 text-stone-900 opacity-[0.05] animate-float-slow pointer-events-none select-none" style="animation-delay: 2s" />
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16">
                <div class="max-w-2xl">
                    <h2 class="text-orange-500 font-semibold tracking-[0.2em] uppercase text-sm mb-4 flex items-center gap-2">
                        <KeneMotif class="w-4 h-4" />
                        <EditableText setting-key="home_products_eyebrow" v-model="c.home_products_eyebrow" />
                    </h2>
                    <EditableText setting-key="home_products_title" v-model="c.home_products_title" tag="p" class="block text-3xl font-black text-black sm:text-4xl font-outfit tracking-tight" />
                </div>
                <Link href="/productos" class="hidden md:inline-flex items-center text-black font-medium uppercase tracking-widest text-sm hover:text-orange-500 transition-colors group">
                    Ver Todos
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="square" stroke-linejoin="miter" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </Link>
            </div>
            
            <div v-if="products.length" class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div v-for="product in products" :key="product.id"
                    class="group border border-stone-200 hover:border-orange-500 transition-colors bg-white shadow-sm hover:shadow-md">
                    <div class="relative bg-stone-100 h-64 flex items-center justify-center overflow-hidden">
                        <img v-if="product.image" :src="`/storage/${product.image}`" :alt="product.name" class="h-full w-full object-cover" />
                        <template v-else>
                            <div class="absolute inset-4 border border-dashed border-stone-300"></div>
                            <span class="text-stone-400 font-bold text-lg uppercase tracking-widest font-outfit z-10 text-center px-4 group-hover:text-orange-500 transition-colors">{{ product.name }}</span>
                        </template>
                        <span v-if="product.price" class="absolute top-3 right-3 bg-stone-900/90 text-white text-sm font-bold px-3 py-1.5 shadow-sm">
                            S/ {{ product.price }}
                        </span>
                    </div>
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-black uppercase tracking-wider mb-2">{{ product.tagline ?? product.name }}</h3>
                        <p class="text-stone-600 font-light text-sm mb-4">{{ product.description }}</p>
                        <button v-if="product.price" @click="add(product)"
                            class="w-full flex items-center justify-center gap-2 py-2.5 text-sm font-medium uppercase tracking-widest transition-colors"
                            :class="justAdded.has(product.id) ? 'bg-green-600 text-white' : 'bg-stone-900 hover:bg-orange-600 text-white'">
                            <svg v-if="justAdded.has(product.id)" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m-10 0a2 2 0 100 4 2 2 0 000-4zm10 0a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            {{ justAdded.has(product.id) ? 'Agregado' : 'Agregar' }}
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="text-center text-stone-500 py-8">
                Catálogo en construcción. Pronto verás nuestras salsas amazónicas aquí.
            </div>

            <div class="mt-12 text-center md:hidden">
                <Link href="/productos" class="inline-flex items-center justify-center px-8 py-4 border border-black text-sm font-medium rounded-none text-black hover:bg-black hover:text-white transition-colors uppercase tracking-widest w-full">
                    Ver Todos Los Productos
                </Link>
            </div>
        </div>
    </section>

    <!-- Galería con Lightbox -->
    <section v-if="galleryImages.length" class="py-20 bg-stone-50 border-t border-stone-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
            <h2 class="text-orange-500 font-semibold tracking-[0.2em] uppercase text-sm mb-4 flex items-center gap-2">
                <KeneMotif class="w-4 h-4" />
                Galería
            </h2>
            <p class="text-3xl font-black text-black sm:text-4xl font-outfit tracking-wide">
                De la Chacra al Frasco
            </p>
        </div>

        <ImageGallery :images="galleryImages" />
    </section>

    <!-- Cultural Identity Section (Kené Pattern Theme) -->
    <section class="py-24 bg-stone-900 text-white relative overflow-hidden">
        <!-- Textura Kené real -->
        <div class="absolute inset-0 opacity-[0.08]"
             style="background-image: url('/images/bg.jpg'); background-size: 400px; background-repeat: repeat;">
        </div>

        <KeneMotif class="hidden md:block absolute top-10 right-16 w-20 h-20 text-orange-500 opacity-10 animate-float pointer-events-none select-none" style="animation-delay: 0.9s" />
        <KeneMotif class="hidden md:block absolute bottom-8 left-10 w-16 h-16 text-white opacity-10 animate-float-slow pointer-events-none select-none" style="animation-delay: 1.6s" />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-black/80 backdrop-blur-sm border border-stone-800 p-10 md:p-16">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 border border-orange-500 text-orange-500 px-4 py-1 mb-6 uppercase tracking-widest text-xs font-medium">
                            <KeneMotif class="w-3.5 h-3.5" />
                            <EditableText setting-key="home_kene_badge" v-model="c.home_kene_badge" />
                        </div>
                        <h2 class="text-3xl md:text-4xl font-black font-outfit mb-6 tracking-wide text-white flex items-center gap-4">
                            <KeneMotif class="w-8 h-8 text-orange-500 shrink-0 hidden sm:block" />
                            <span>
                                <EditableText setting-key="home_kene_title_line1" v-model="c.home_kene_title_line1" /><br/>
                                <EditableText setting-key="home_kene_title_line2" v-model="c.home_kene_title_line2" />
                            </span>
                        </h2>
                        <EditableText setting-key="home_kene_paragraph_1" v-model="c.home_kene_paragraph_1" tag="p" class="block text-lg text-stone-300 mb-6 font-light leading-relaxed" />
                        <EditableText setting-key="home_kene_paragraph_2" v-model="c.home_kene_paragraph_2" tag="p" class="block text-base text-stone-400 leading-relaxed border-l-2 border-orange-500 pl-4 font-light" />
                    </div>
                    <div class="flex justify-center relative">
                        <div class="w-full max-w-xs relative overflow-hidden">
                            <EditableImage setting-key="home_kene_box_image" :src="img('home_kene_box_image', '/images/molido.png')"
                                alt="Salsa de ají charapita Nanki" wrapper-class="relative" img-class="w-full h-auto block" />
                            <div class="absolute inset-x-0 bottom-0 z-10 bg-gradient-to-t from-black/80 via-black/30 to-transparent pt-16 pb-5 px-4 text-center">
                                <EditableText setting-key="home_kene_box_label" v-model="c.home_kene_box_label"
                                    class="text-white font-medium tracking-[0.2em] uppercase text-xs" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
