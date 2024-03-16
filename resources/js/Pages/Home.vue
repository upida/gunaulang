<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import ProductCard from "@/Components/Product/Card.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    products: {
        type: Array,
    },
});

const openProduct = (id) => {
    router.visit(
        route("product", {
            product: id,
        })
    );
};
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="space-y-6">
                        <v-row>
                            <v-col
                                v-for="product in products"
                                :key="product.id"
                                class="grid justify-items-center"
                            >
                                <ProductCard
                                    @click="openProduct(product.id)"
                                    :product="product"
                                />
                            </v-col>
                        </v-row>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
