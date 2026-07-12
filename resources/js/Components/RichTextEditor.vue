<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },
    placeholder: {
        type: String,
        default: 'Escribe aquí...',
    },
});

const emit = defineEmits(['update:modelValue']);

const editor = ref(null);

const tools = [
    { command: 'bold', icon: 'B', label: 'Negrita', class: 'font-bold' },
    { command: 'italic', icon: 'I', label: 'Cursiva', class: 'italic' },
    { command: 'underline', icon: 'U', label: 'Subrayado', class: 'underline' },
    { command: 'insertUnorderedList', icon: '•', label: 'Lista' },
];

const exec = (command) => {
    document.execCommand(command, false, null);
    editor.value?.focus();
    onInput();
};

const setLink = () => {
    const url = prompt('URL del enlace:');
    if (url) {
        document.execCommand('createLink', false, url);
        onInput();
    }
};

const onInput = () => {
    emit('update:modelValue', editor.value?.innerHTML ?? '');
};

onMounted(() => {
    if (editor.value) {
        editor.value.innerHTML = props.modelValue ?? '';
    }
});

watch(() => props.modelValue, (value) => {
    if (editor.value && value !== editor.value.innerHTML && document.activeElement !== editor.value) {
        editor.value.innerHTML = value ?? '';
    }
});
</script>

<template>
    <div class="border border-stone-300 rounded-md overflow-hidden focus-within:ring-1 focus-within:ring-orange-500 focus-within:border-orange-500">
        <div class="flex items-center gap-1 bg-stone-50 border-b border-stone-300 px-2 py-1.5">
            <button v-for="tool in tools" :key="tool.command" type="button"
                @mousedown.prevent="exec(tool.command)"
                :title="tool.label"
                class="w-8 h-8 flex items-center justify-center rounded hover:bg-stone-200 text-stone-700 text-sm"
                :class="tool.class">
                {{ tool.icon }}
            </button>
            <button type="button" @mousedown.prevent="setLink" title="Enlace"
                class="w-8 h-8 flex items-center justify-center rounded hover:bg-stone-200 text-stone-700 text-sm underline">
                🔗
            </button>
        </div>
        <div ref="editor"
            contenteditable="true"
            class="px-4 py-3 min-h-[120px] text-sm text-stone-800 focus:outline-none prose-sm [&_a]:text-orange-600 [&_a]:underline [&_ul]:list-disc [&_ul]:pl-5"
            :data-placeholder="placeholder"
            @input="onInput"
        ></div>
    </div>
</template>

<style scoped>
[contenteditable][data-placeholder]:empty::before {
    content: attr(data-placeholder);
    color: #a8a29e;
}
</style>
