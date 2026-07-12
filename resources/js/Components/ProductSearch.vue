<script setup>
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
});

const query = ref(props.modelValue);
let debounceTimer = null;

watch(query, (value) => {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
        router.get('/productos', value ? { q: value } : {}, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 350);
});
</script>

<template>
    <div class="relative max-w-md mx-auto">
        <input v-model="query" type="search" placeholder="Buscar productos..."
            class="w-full py-3 pl-11 pr-4 border border-stone-300 rounded-full shadow-sm focus:ring-orange-500 focus:border-orange-500 text-sm" />
        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
</template>
