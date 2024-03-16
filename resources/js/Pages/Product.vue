<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import { ref } from "vue";

const quantity = ref(0);

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    store: {
        type: Object,
    },
    product: {
        type: Object,
    },
});

const form = useForm({
    quantity: 0,
});

const add = () => {
    form.quantity = quantity.value;
    form.post(
        route("cart.edit", {
            product: props.product.id,
        })
    );
};

const buy = () => {
    form.quantity = quantity.value;
    form.post(
        route("order.create", {
            product: props.product.id,
        })
    );
};
</script>

<template>
    <Head :title="product.title" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="space-y-6">
                        <v-row>
                            <v-col cols="12" md="4" lg="4" class="">
                                <v-carousel
                                    class="product-image"
                                    hide-delimiters
                                    show-arrows="hover"
                                >
                                    <v-carousel-item
                                        v-for="image of product.images"
                                        class="product-image"
                                    >
                                        <v-img
                                            :aspect-ratio="1"
                                            :src="image"
                                            class="w-100 bg-grey-lighten-3 rounded-lg"
                                        >
                                            <template v-slot:placeholder>
                                                <div
                                                    class="d-flex align-center justify-center fill-height"
                                                >
                                                    <v-progress-circular
                                                        color="grey-lighten-4"
                                                        indeterminate
                                                    ></v-progress-circular>
                                                </div>
                                            </template>
                                        </v-img>
                                    </v-carousel-item>
                                </v-carousel>
                                <v-card
                                    :title="store.title"
                                    :subtitle="store.address"
                                    variant="tonal"
                                    color="green-lighten-2"
                                    class="mt-5"
                                >
                                    <template v-slot:prepend>
                                        <v-avatar color="green-darken-2">
                                            <v-icon icon="mdi-store"></v-icon>
                                        </v-avatar>
                                    </template>
                                </v-card>
                            </v-col>
                            <v-col cols="12" md="4" lg="4">
                                <v-card :title="product.title" variant="flat">
                                    <v-card-text>
                                        {{ product.description }}
                                    </v-card-text>
                                    <v-card-item>
                                        <div class="text-subtitle-2">
                                            Detailed information
                                        </div>
                                        <v-table class="w-full">
                                            <tbody>
                                                <tr>
                                                    <td>Stock</td>
                                                    <td>{{ product.stock }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Condition</td>
                                                    <td class="text-capitalize">
                                                        {{ product.condition }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Food</td>
                                                    <td>
                                                        {{
                                                            product.food
                                                                ? "Yes"
                                                                : "No"
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Danger</td>
                                                    <td>
                                                        {{
                                                            product.danger
                                                                ? "Yes"
                                                                : "No"
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Expired At</td>
                                                    <td>
                                                        {{
                                                            product.expired_at
                                                                ? product.expired_at
                                                                : "No expired"
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Updated At</td>
                                                    <td>
                                                        {{ product.updated_at }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </v-table>
                                    </v-card-item>
                                </v-card>
                            </v-col>
                            <v-col cols="12" md="4" lg="4">
                                <v-card variant="elevated">
                                    <v-card-item>
                                        <v-text-field
                                            v-model="quantity"
                                            type="number"
                                            min="1"
                                            label="Set the order quantity"
                                        >
                                        </v-text-field>
                                    </v-card-item>
                                    <div class="space-y-2 pa-2">
                                        <v-btn
                                            @click="add()"
                                            variant="tonal"
                                            color="green-accent-4"
                                            class="w-full"
                                        >
                                            Add to cart
                                        </v-btn>
                                        <v-btn
                                            @click="buy()"
                                            variant="tonal"
                                            class="w-full"
                                        >
                                            Buy
                                        </v-btn>
                                    </div>
                                </v-card>
                            </v-col>
                        </v-row>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>

<style scoped>
:deep(.v-carousel > .v-window__container),
.product-image {
    max-height: 24rem !important;
}
</style>
