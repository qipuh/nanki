<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { reactive, inject, ref } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';
import KeneMotif from '../Components/KeneMotif.vue';
import BrandCaption from '../Components/BrandCaption.vue';
import EditableText from '../Components/Editable/EditableText.vue';
import EditableImage from '../Components/Editable/EditableImage.vue';

defineOptions({ layout: AppLayout })

const props = defineProps({
    content: {
        type: Object,
        default: () => ({}),
    },
});

const c = reactive({ ...props.content });

const img = (key, fallback) => c[key] ? `/storage/${c[key]}` : fallback;

const editMode = inject('editMode', ref(false));
</script>

<template>
    <Head title="Nuestra Historia" />

    <!-- Hero Section -->
    <div class="relative bg-stone-900 py-28 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.08]"
             style="background-image: url('/images/bg.jpg'); background-size: 400px; background-repeat: repeat;"></div>

        <KeneMotif class="hidden md:block absolute top-10 right-16 w-20 h-20 text-orange-500 opacity-10 animate-float pointer-events-none select-none" style="animation-delay: 0.9s" />
        <KeneMotif class="hidden md:block absolute bottom-8 left-10 w-16 h-16 text-white opacity-10 animate-float-slow pointer-events-none select-none" style="animation-delay: 1.6s" />

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
            <EditableText setting-key="historia_hero_title" v-model="c.historia_hero_title" tag="h1"
                class="block text-4xl font-extrabold tracking-wide text-white sm:text-5xl font-outfit" />
            <div class="flex items-center justify-center gap-3 mt-6 mb-6">
                <span class="w-10 h-px bg-orange-500"></span>
                <KeneMotif class="w-5 h-5 text-orange-500" />
                <span class="w-10 h-px bg-orange-500"></span>
            </div>
            <EditableText setting-key="historia_hero_subtitle" v-model="c.historia_hero_subtitle" tag="p"
                class="block text-lg text-stone-300 max-w-2xl mx-auto font-light" />
        </div>
    </div>

    <!-- Separador Kené -->
    <div class="w-full h-[120px] max-h-[120px] bg-white opacity-15"
        style="background-image: url('/images/patron.png'); background-repeat: repeat-x; background-size: auto 120px; background-position: top center;
               -webkit-mask-image: linear-gradient(to bottom, black 0%, black 40%, transparent 90%);
               mask-image: linear-gradient(to bottom, black 0%, black 40%, transparent 90%);"></div>

    <!-- ¿Qué es Nanki? -->
    <section class="pb-20 bg-stone-50 relative overflow-hidden -mt-10">
        <EditableImage setting-key="historia_planta_float_image" :src="img('historia_planta_float_image', '/images/planta.png')"
            wrapper-class="hidden 2xl:block absolute top-10 right-6 w-32 animate-float" img-class="w-full drop-shadow-xl pointer-events-none select-none" style="animation-delay: 0.4s" />

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-20">
                <h2 class="text-3xl font-bold font-outfit tracking-wide text-stone-900 mb-6 flex items-center gap-4">
                    <KeneMotif class="w-8 h-8 text-orange-500 shrink-0" />
                    <EditableText setting-key="historia_que_es_title" v-model="c.historia_que_es_title" />
                </h2>
                <div class="prose prose-stone prose-lg max-w-none text-stone-600">
                    <EditableText setting-key="historia_que_es_paragraph_1" v-model="c.historia_que_es_paragraph_1" tag="p" class="block mb-4 font-light" />
                    <EditableText setting-key="historia_que_es_paragraph_2" v-model="c.historia_que_es_paragraph_2" tag="p" class="block mb-8 font-light" />
                    <div class="bg-stone-900 text-white rounded-none border-l-4 border-orange-500 p-6 not-italic">
                        <EditableText setting-key="historia_que_es_quote" v-model="c.historia_que_es_quote" tag="p" class="block m-0 text-stone-200 font-light leading-relaxed" />
                    </div>
                </div>
            </div>

            <!-- Nuestros Inicios -->
            <div>
                <h2 class="text-3xl font-bold font-outfit tracking-wide text-stone-900 mb-6 flex items-center gap-4">
                    <KeneMotif class="w-8 h-8 text-orange-500 shrink-0" />
                    <EditableText setting-key="historia_inicios_title" v-model="c.historia_inicios_title" />
                </h2>

                <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-start mb-10">
                    <div class="relative h-72 lg:h-full min-h-[320px] border border-stone-200 shadow-sm overflow-hidden mb-8 lg:mb-0">
                        <EditableImage setting-key="historia_inicios_image" :src="img('historia_inicios_image', '/images/hand.png')"
                            alt="Cosecha de ají charapita en Iquitos" wrapper-class="absolute inset-0" img-class="w-full h-full object-cover" />
                        <BrandCaption :subtitle="c.historia_inicios_image_caption" />
                    </div>
                    <div class="prose prose-stone prose-lg max-w-none text-stone-600">
                        <EditableText setting-key="historia_inicios_paragraph_1" v-model="c.historia_inicios_paragraph_1" tag="p" class="block mb-4 font-light" />
                        <EditableText setting-key="historia_inicios_paragraph_2" v-model="c.historia_inicios_paragraph_2" tag="p" class="block mb-4 font-light" />
                    </div>
                </div>

                <div class="prose prose-stone prose-lg max-w-none text-stone-600">
                    <EditableText setting-key="historia_inicios_paragraph_3" v-model="c.historia_inicios_paragraph_3" tag="p" class="block mb-4 font-light" />

                    <div class="bg-orange-50 border border-orange-200 p-6 my-8 flex gap-4 items-start">
                        <KeneMotif class="w-8 h-8 text-orange-500 shrink-0 mt-1" />
                        <div>
                            <EditableText setting-key="historia_cert_title" v-model="c.historia_cert_title" tag="h3"
                                class="block text-xl font-bold text-orange-800 mb-2 font-outfit tracking-wide" />
                            <EditableText setting-key="historia_cert_text" v-model="c.historia_cert_text" tag="p" class="block text-orange-900 m-0 font-light" />
                        </div>
                    </div>

                    <EditableText setting-key="historia_inicios_paragraph_4" v-model="c.historia_inicios_paragraph_4" tag="p" class="block mb-4 font-light" />
                    <EditableText setting-key="historia_inicios_paragraph_5" v-model="c.historia_inicios_paragraph_5" tag="p" class="block font-medium text-stone-800" />
                </div>
            </div>

            <div class="mt-16 text-center">
                <component :is="editMode ? 'span' : Link" :href="editMode ? undefined : '/productos'"
                    class="inline-flex items-center justify-center px-8 py-4 border border-orange-500 text-sm font-medium text-white bg-orange-500 hover:bg-orange-600 hover:border-orange-600 transition-all uppercase tracking-widest shadow-sm">
                    <EditableText setting-key="historia_cta_text" v-model="c.historia_cta_text" />
                </component>
            </div>
        </div>
    </section>
</template>
