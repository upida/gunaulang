<script setup>
import ProductCard from "@/Components/Product/Card.vue";
import { router } from "@inertiajs/vue3";

defineProps({
    products: {
        type: Array,
    }
});

const openProduct = (id) => {
    router.visit(route('donator.product.page', {
        product: id,
    }));
}
</script>

<template>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Your donation
        </h2>
    </header>

    <div
        class="mt-6 space-y-6"
    >
        <v-row>
            <v-col
                v-for="product in products"
                :key="product.id"
                class="grid justify-items-center"
            >
                <ProductCard @click="openProduct(product.id)" :product="product" />
            </v-col>
        </v-row>
    </div>
</template>
