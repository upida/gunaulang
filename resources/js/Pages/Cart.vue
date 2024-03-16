<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import { ref } from "vue";

const orders = ref([]);

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    carts: {
        type: Array,
    },
});

const form = useForm({
    cart_products: [],
});

const checkout = function () {
    form.cart_products = orders.value;
    form.post(route("order.checkout.page"));
};
</script>

<template>
    <Head title="Cart" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12 cart-main">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg space-y-6">
                    <v-card
                        v-for="cart of carts"
                        :title="cart.store.title"
                        variant="elevated"
                    >
                        <template v-slot:prepend>
                            <v-avatar color="green-darken-2">
                                <v-icon icon="mdi-store"></v-icon>
                            </v-avatar>
                        </template>
                        <v-card-item>
                            <v-list
                                v-model:selected="orders"
                                select-strategy="classic"
                            >
                                <template
                                    v-for="product of cart.products"
                                    :key="product.id"
                                >
                                    <v-list-item
                                        :value="product.product_id"
                                        :title="product.product.title"
                                    >
                                        <template v-slot:prepend="{ isActive }">
                                            <v-list-item-action start>
                                                <v-checkbox-btn
                                                    :model-value="isActive"
                                                ></v-checkbox-btn>
                                            </v-list-item-action>
                                        </template>
                                    </v-list-item>
                                    <v-divider
                                        :thickness="2"
                                        class="border-opacity-50"
                                    ></v-divider>
                                </template>
                            </v-list>
                        </v-card-item>
                    </v-card>
                </div>
            </div>
            <v-sheet class="action d-flex justify-end align-center" border>
                <v-btn @click="checkout" size="large" color="green-lighten-2"
                    >Checkout ({{ orders.length ?? "0" }})</v-btn
                >
            </v-sheet>
        </div>
    </BasicLayout>
</template>

<style scoped>
.cart-main {
    margin-bottom: 100px;
}

.action {
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 100px;
    padding: 30px;
}
</style>
