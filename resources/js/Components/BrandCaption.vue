<script setup>
defineProps({
    subtitle: {
        type: String,
        default: 'Loreto, Perú',
    },
});
</script>

<template>
    <div class="absolute inset-x-0 bottom-0 z-10 bg-gradient-to-t from-black/80 via-black/40 to-transparent pt-16 pb-6 px-6 text-center">
        <p class="text-white/80 text-xs font-medium uppercase tracking-[0.3em]">{{ subtitle }}</p>
    </div>
</template>
