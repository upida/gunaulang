<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Address from "@/Components/Address.vue";
import CardProduct from "@/Components/CardProduct.vue";
import CardSearch from "@/Components/CardSearch.vue";
import { ref } from "vue";
import { onMounted } from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    data: {
        type: Object,
    },
});
const doSearch = (params) => {
    router.get("/search", params);
};
const openProduct = (store, title) => {
    router.get(`/${store}/${title}`);
};
const categories = ref([
    {
        label: "Makan gratis disini!",
        image: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {
            doSearch({
                is_new: 1,
                is_food: 1,
                price_start: 0,
                price_end: 0,
                expired_at_start: new Date(),
            });
        },
    },
    {
        label: "Makan murah",
        image: "https://images.unsplash.com/photo-1606787366850-de6330128bfc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {
            doSearch({
                is_new: 1,
                is_food: 1,
                price_start: 1,
                expired_at_start: new Date(),
            });
        },
    },
    {
        label: "Butuh limbah makanan?",
        image: "https://images.unsplash.com/photo-1553787434-45e1d245bfbb?q=80&w=2020&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {
            doSearch({ is_food: 1, expired_at_end: new Date() });
        },
    },
    {
        label: "Produk olahan limbah makananmu",
        image: "https://images.unsplash.com/photo-1587733761376-3f26fc81d17f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {
            doSearch({ is_new: 1, is_food: 0 });
        },
    },
]);
const distanceFormat = (args) => {
    if (args < 1000) {
        return `${args} M`;
    }
    return `${Math.round(args / 1000)} KM`;
};
onMounted(() => {
    console.log(route().t.url);
});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 space-y-8">
                <Address
                    :address="data.address.address"
                    :name="data.address.name"
                />
                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <div class="flex items-center space-x-8 mb-5">
                        <div
                            v-for="cat in categories"
                            @click="cat.action"
                            class="rounded-full mx-auto w-14 h-14 sm:w-36 sm:h-36 sm:text-md text-sm cursor-pointer text-center"
                        >
                            <img
                                class="w-14 h-14 sm:w-36 sm:h-36 object-cover rounded-full mb-3"
                                :src="cat.image"
                            />
                            {{ cat.label }}
                        </div>
                    </div>
                </div>
                <CardSearch @search="doSearch" class="mx-20" />
                <div v-if="data.product.free_food.length > 0" class="pa-4">
                    <div class="flex justify-between items-center">
                        <h1 class="font-bold text-lg text-uppercase">
                            Makanan Gratis
                        </h1>
                        <p
                            @click="doSearch({ is_new: 1, is_food: 1 })"
                            class="text-green-600 items-center cursor-pointer"
                        >
                            Lihat Semua
                            <v-icon icon="mdi-chevron-right" class=""></v-icon>
                        </p>
                    </div>
                    <v-slide-group class="!p-0 !m-0" center-active show-arrows>
                        <v-slide-item
                            v-for="(product, i) in data.product.free_food"
                            @click="
                                openProduct(product.storename, product.title)
                            "
                            class=""
                        >
                            <v-card class="ma-2" width="300">
                                <!-- /storage/Media/1/1VmhBcBE8I4khRAhzYKZT2pT3RfLLoJ49gY1nekP.webp -->
                                <v-img
                                    class="text-white align-end"
                                    height="200"
                                    cover
                                    :src="`${route().t.url}/storage/${
                                        product.media?.[0]?.path
                                    }`"
                                >
                                </v-img>

                                <v-card-title class="pt-4">{{
                                    product.title
                                }}</v-card-title>

                                <v-card-text class="">
                                    <div>
                                        {{ distanceFormat(product.distance) }}
                                    </div>
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-slide-item>
                    </v-slide-group>
                </div>
                <div v-if="data.product.cheap_food.length > 0" class="pa-4">
                    <div class="flex justify-between items-center">
                        <h1 class="font-bold text-lg text-uppercase">
                            Makanan Murah
                        </h1>
                        <p
                            @click="doSearch({ is_new: 1, is_food: 1 })"
                            class="text-green-600 items-center cursor-pointer"
                        >
                            Lihat Semua
                            <v-icon icon="mdi-chevron-right" class=""></v-icon>
                        </p>
                    </div>
                    <v-slide-group class="!p-0 !m-0" center-active show-arrows>
                        <v-slide-item
                            v-for="(product, i) in data.product.cheap_food"
                            @click="
                                openProduct(product.storename, product.title)
                            "
                            class=""
                        >
                            <v-card class="ma-2" width="300">
                                <v-img
                                    class="text-white align-end"
                                    height="200"
                                    cover
                                    :src="`${route().t.url}/storage/${
                                        product.media?.[0]?.path
                                    }`"
                                >
                                </v-img>

                                <v-card-title class="pt-4">{{
                                    product.title
                                }}</v-card-title>

                                <v-card-text class="">
                                    <div>
                                        {{ distanceFormat(product.distance) }}
                                    </div>
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-slide-item>
                    </v-slide-group>
                </div>
                <div v-if="data.product.food_waste.length > 0" class="pa-4">
                    <div class="flex justify-between items-center">
                        <h1 class="font-bold text-lg text-uppercase">
                            Limbah Makanan
                        </h1>
                        <p
                            @click="doSearch({ is_new: 1, is_food: 1 })"
                            class="text-green-600 items-center cursor-pointer"
                        >
                            Lihat Semua
                            <v-icon icon="mdi-chevron-right" class=""></v-icon>
                        </p>
                    </div>
                    <v-slide-group class="!p-0 !m-0" center-active show-arrows>
                        <v-slide-item
                            @click="
                                openProduct(product.storename, product.title)
                            "
                            v-for="(product, i) in data.product.food_waste"
                            class=""
                        >
                            <v-card class="ma-2" width="300">
                                <v-img
                                    class="text-white align-end"
                                    height="200"
                                    cover
                                    :src="`${route().t.url}/storage/${
                                        product.media?.[0]?.path
                                    }`"
                                >
                                </v-img>

                                <v-card-title class="pt-4">{{
                                    product.title
                                }}</v-card-title>

                                <v-card-text class="">
                                    <div>
                                        {{ distanceFormat(product.distance) }}
                                    </div>
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-slide-item>
                    </v-slide-group>
                </div>
                <div
                    v-if="data.product.processed_waste.length > 0"
                    class="pa-4"
                >
                    <div class="flex justify-between items-center">
                        <h1 class="font-bold text-lg text-uppercase">
                            Produk Olahan Limbah
                        </h1>
                        <p
                            @click="doSearch({ is_new: 1, is_food: 1 })"
                            class="text-green-600 items-center cursor-pointer"
                        >
                            Lihat Semua
                            <v-icon icon="mdi-chevron-right" class=""></v-icon>
                        </p>
                    </div>
                    <v-slide-group class="!p-0 !m-0" center-active show-arrows>
                        <v-slide-item
                            v-for="(product, i) in data.product.processed_waste"
                            class=""
                        >
                            <v-card class="ma-2" width="300">
                                <v-img
                                    class="text-white align-end"
                                    height="200"
                                    cover
                                    :src="`${route().t.url}/storage/${
                                        product.media?.[0]?.path
                                    }`"
                                >
                                </v-img>

                                <v-card-title class="pt-4">{{
                                    product.title
                                }}</v-card-title>

                                <v-card-text class="">
                                    <div>
                                        {{ distanceFormat(product.distance) }}
                                    </div>
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-slide-item>
                    </v-slide-group>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
