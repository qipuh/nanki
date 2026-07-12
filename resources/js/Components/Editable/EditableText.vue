<script setup>
import { ref, inject } from 'vue';

const props = defineProps({
    settingKey: {
        type: String,
        required: true,
    },
    modelValue: {
        type: String,
        default: '',
    },
    tag: {
        type: String,
        default: 'span',
    },
});

const emit = defineEmits(['update:modelValue']);

defineOptions({ inheritAttrs: false });

const editMode = inject('editMode', ref(false));
const el = ref(null);
const saving = ref(false);
const saved = ref(false);

const onBlur = async () => {
    const value = el.value.innerHTML.trim();
    if (value === (props.modelValue ?? '')) return;

    saving.value = true;
    try {
        await axios.post('/admin/contenido-inicio/texto', { key: props.settingKey, value });
        emit('update:modelValue', value);
        saved.value = true;
        setTimeout(() => (saved.value = false), 1500);
    } catch (e) {
        el.value.innerHTML = props.modelValue ?? '';
        alert('No se pudo guardar.');
    } finally {
        saving.value = false;
    }
};

const onKeydown = (e) => {
    if (e.key === 'Enter' && !e.shiftKey && props.tag !== 'p') {
        e.preventDefault();
        el.value.blur();
    }
};
</script>

<template>
    <component :is="tag" ref="el"
        :contenteditable="editMode"
        spellcheck="false"
        @blur="editMode && onBlur()"
        @keydown="editMode && onKeydown($event)"
        @click="(e) => editMode && e.preventDefault()"
        :class="[$attrs.class, 'outline-none', editMode ? 'ring-1 ring-dashed ring-orange-400 hover:ring-2 hover:ring-solid hover:bg-orange-50/40 focus:ring-2 focus:ring-orange-500 focus:bg-orange-50/60 rounded-sm cursor-text transition-all' : '']"
        v-html="modelValue"
    ></component>
    <span v-if="editMode && saving" class="text-xs text-stone-400 ml-1">guardando…</span>
    <span v-if="editMode && saved" class="text-xs text-green-600 ml-1">✓ guardado</span>
</template>
