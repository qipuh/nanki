<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import cart, { removeFromCart, updateQty, clearCart, cartTotal } from '../cart';

defineProps({
    open: {
        type: Boolean,
        default: false,
    },
});

defineEmits(['close']);

const page = usePage();
const whatsapp = computed(() => page.props.site?.whatsapp);

const formatPrice = (n) => `S/ ${Number(n).toFixed(2)}`;

const checkoutUrl = computed(() => {
    if (!whatsapp.value || cart.items.length === 0) return null;

    const lines = cart.items.map((i) => `• ${i.qty} x ${i.name} — ${formatPrice(i.price * i.qty)}`);
    const text = [
        'Hola, quiero hacer este pedido:',
        '',
        ...lines,
        '',
        `Total: ${formatPrice(cartTotal.value)}`,
    ].join('\n');

    const digits = whatsapp.value.replace(/\D/g, '');
    return `https://wa.me/${digits}?text=${encodeURIComponent(text)}`;
});
</script>

<template>
    <Teleport to="body">
        <div v-if="open" class="fixed inset-0 z-[90] bg-black/50 transition-opacity" @click="$emit('close')"></div>

        <div class="fixed top-0 right-0 z-[95] h-full w-full max-w-md bg-white shadow-2xl transition-transform duration-300 flex flex-col"
            :class="open ? 'translate-x-0' : 'translate-x-full'">
            <div class="flex items-center justify-between px-6 py-5 border-b border-stone-100 shrink-0">
                <h2 class="text-lg font-bold text-stone-900">Tu pedido</h2>
                <button @click="$emit('close')" aria-label="Cerrar" class="text-stone-400 hover:text-stone-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-4">
                <div v-if="cart.items.length === 0" class="text-center text-stone-400 py-16 text-sm">
                    Tu carrito está vacío.
                </div>
                <div v-else class="space-y-4">
                    <div v-for="item in cart.items" :key="item.id" class="flex gap-4 items-center border-b border-stone-100 pb-4">
                        <div class="w-16 h-16 bg-stone-100 rounded overflow-hidden shrink-0">
                            <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name" class="w-full h-full object-cover" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-stone-900 text-sm truncate">{{ item.name }}</p>
                            <p class="text-orange-600 text-sm font-semibold">{{ formatPrice(item.price) }}</p>
                            <div class="flex items-center gap-2 mt-1.5">
                                <button @click="updateQty(item.id, item.qty - 1)" class="w-6 h-6 flex items-center justify-center border border-stone-300 rounded text-stone-600 hover:bg-stone-100">−</button>
                                <span class="text-sm w-6 text-center">{{ item.qty }}</span>
                                <button @click="updateQty(item.id, item.qty + 1)" class="w-6 h-6 flex items-center justify-center border border-stone-300 rounded text-stone-600 hover:bg-stone-100">+</button>
                            </div>
                        </div>
                        <button @click="removeFromCart(item.id)" aria-label="Quitar" class="text-stone-400 hover:text-red-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="cart.items.length" class="border-t border-stone-100 px-6 py-5 space-y-3 shrink-0">
                <div class="flex justify-between text-lg font-bold text-stone-900">
                    <span>Total</span>
                    <span>{{ formatPrice(cartTotal) }}</span>
                </div>
                <a v-if="checkoutUrl" :href="checkoutUrl" target="_blank" rel="noopener"
                    class="w-full flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium py-3 rounded-md transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.28-1.38a9.9 9.9 0 004.76 1.21h.01c5.46 0 9.9-4.45 9.9-9.91C21.96 6.45 17.51 2 12.04 2zm0 18.1a8.2 8.2 0 01-4.19-1.15l-.3-.18-3.13.82.84-3.05-.19-.31a8.2 8.2 0 01-1.26-4.4c0-4.53 3.69-8.22 8.23-8.22 4.53 0 8.22 3.69 8.22 8.22 0 4.54-3.69 8.27-8.22 8.27zm4.51-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.25-.64.81-.78.97-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.48-1.39-1.73-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.14.16-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05s.88 2.38 1 2.55c.12.17 1.73 2.64 4.2 3.7.59.25 1.05.4 1.41.51.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.67-1.18.21-.58.21-1.08.15-1.18-.06-.1-.23-.17-.48-.29z"/></svg>
                    Enviar pedido por WhatsApp
                </a>
                <p v-else class="text-xs text-stone-400 text-center">
                    El WhatsApp de pedidos aún no está configurado.
                </p>
                <button @click="clearCart" class="w-full text-xs text-stone-400 hover:text-stone-600 py-1">Vaciar carrito</button>
            </div>
        </div>
    </Teleport>
</template>
