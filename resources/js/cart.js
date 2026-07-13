import { reactive, watch, computed } from 'vue';

const STORAGE_KEY = 'nanki_cart';

function load() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        const items = raw ? JSON.parse(raw) : [];
        return Array.isArray(items) ? items : [];
    } catch (e) {
        return [];
    }
}

const state = reactive({
    items: load(),
});

watch(() => state.items, (items) => {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
}, { deep: true });

export function addToCart(product, qty = 1) {
    const existing = state.items.find((i) => i.id === product.id);
    if (existing) {
        existing.qty += qty;
    } else {
        state.items.push({
            id: product.id,
            name: product.name,
            price: Number(product.price),
            image: product.image ?? null,
            qty,
        });
    }
}

export function removeFromCart(id) {
    state.items = state.items.filter((i) => i.id !== id);
}

export function updateQty(id, qty) {
    const item = state.items.find((i) => i.id === id);
    if (!item) return;
    if (qty <= 0) {
        removeFromCart(id);
    } else {
        item.qty = qty;
    }
}

export function clearCart() {
    state.items = [];
}

export const cartCount = computed(() => state.items.reduce((sum, i) => sum + i.qty, 0));
export const cartTotal = computed(() => state.items.reduce((sum, i) => sum + i.qty * i.price, 0));

export default state;
