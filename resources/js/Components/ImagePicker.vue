<script setup>
import { ref, computed, onBeforeUnmount } from 'vue';

const props = defineProps({
    modelValue: {
        type: [File, null],
        default: null,
    },
    current: {
        type: String,
        default: null,
    },
    imageClass: {
        type: String,
        default: 'h-24 w-40 object-cover rounded',
    },
});

const emit = defineEmits(['update:modelValue']);

const previewUrl = ref(null);

const displayUrl = computed(() => previewUrl.value ?? (props.current ? `/storage/${props.current}` : null));

const onChange = (event) => {
    const file = event.target.files[0] ?? null;

    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
        previewUrl.value = null;
    }

    if (file) {
        previewUrl.value = URL.createObjectURL(file);
    }

    emit('update:modelValue', file);
};

onBeforeUnmount(() => {
    if (previewUrl.value) {
        URL.revokeObjectURL(previewUrl.value);
    }
});
</script>

<template>
    <div>
        <img v-if="displayUrl" :src="displayUrl" :class="imageClass" class="mb-2 bg-stone-100" />
        <input @change="onChange" type="file" accept="image/*" class="w-full text-sm" />
    </div>
</template>
