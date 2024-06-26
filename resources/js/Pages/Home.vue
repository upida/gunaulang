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
const query = ref("");
const doSearch = (params) => {
    router.get("/search", params);
};
const openProduct = (store, title) => {
    router.get(`/${store}/${title}`);
};
const categories = ref([
    {
        label: "Makan gratis disini!",
        image: route().t.url + "/assets/free%20food.jpg",
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
        image: route().t.url + "/assets/cheap%20food.jpg",
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
        image: route().t.url + "/assets/food%20waste.jpg",
        action: () => {
            doSearch({ is_food: 1, expired_at_end: new Date() });
        },
    },
    {
        label: "Produk olahan limbah makananmu",
        image: route().t.url + "/assets/processed%20waste.jpg",
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
const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};
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
                    <div
                        class="grid sm:grid-cols-4 grid-cols-2 gap-8 items-center sm:mb-5 mb-20"
                    >
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
                <CardSearch
                    v-model="query"
                    @search="(val) => doSearch({ keyword: val })"
                    class="sm:mx-20 mx-5"
                />
                <div v-if="data.product.free_food.length > 0" class="pa-4">
                    <div class="flex justify-between items-center">
                        <h1 class="font-bold text-lg text-uppercase">
                            Makanan Gratis
                        </h1>
                        <p
                            @click="
                                doSearch({
                                    is_new: 1,
                                    is_food: 1,
                                    price_start: 0,
                                    price_end: 0,
                                    expired_at_start: new Date(),
                                })
                            "
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
                                <v-card-subtitle
                                    v-if="product.price"
                                    class="pt-4"
                                >
                                    Rp
                                    {{
                                        moneyFormat(product.price)
                                    }}</v-card-subtitle
                                >
                                <v-card-subtitle
                                    v-else
                                    class="pt-4 text-green-500"
                                >
                                    Gratis!</v-card-subtitle
                                >
                                <v-card-text
                                    class="flex justify-between w-full"
                                >
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                    <div>
                                        {{
                                            product.distance
                                                ? distanceFormat(
                                                      product.distance
                                                  )
                                                : product.province
                                        }}
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
                            @click="
                                doSearch({
                                    is_new: 1,
                                    is_food: 1,
                                    price_start: 1,
                                    expired_at_start: new Date(),
                                })
                            "
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
                                <v-card-subtitle
                                    v-if="product.price"
                                    class="pt-4"
                                >
                                    Rp
                                    {{
                                        moneyFormat(product.price)
                                    }}</v-card-subtitle
                                >
                                <v-card-subtitle
                                    v-else
                                    class="pt-4 text-green-500"
                                >
                                    Gratis!</v-card-subtitle
                                >
                                <v-card-text
                                    class="flex justify-between w-full"
                                >
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                    <div>
                                        {{
                                            product.distance
                                                ? distanceFormat(
                                                      product.distance
                                                  )
                                                : product.province
                                        }}
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
                            @click="
                                doSearch({
                                    is_food: 1,
                                    expired_at_end: new Date(),
                                })
                            "
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
                                <v-card-subtitle
                                    v-if="product.price"
                                    class="pt-4"
                                >
                                    Rp
                                    {{
                                        moneyFormat(product.price)
                                    }}</v-card-subtitle
                                >
                                <v-card-subtitle
                                    v-else
                                    class="pt-4 text-green-500"
                                >
                                    Gratis!</v-card-subtitle
                                >
                                <v-card-text
                                    class="flex justify-between w-full"
                                >
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                    <div>
                                        {{
                                            product.distance
                                                ? distanceFormat(
                                                      product.distance
                                                  )
                                                : product.province
                                        }}
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
                            Produk Olahan Limbah Makanan
                        </h1>
                        <p
                            @click="doSearch({ is_new: 1, is_food: 0 })"
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
                                <v-card-subtitle
                                    v-if="product.price"
                                    class="pt-4"
                                >
                                    Rp
                                    {{
                                        moneyFormat(product.price)
                                    }}</v-card-subtitle
                                >
                                <v-card-subtitle
                                    v-else
                                    class="pt-4 text-green-500"
                                >
                                    Gratis!</v-card-subtitle
                                >

                                <v-card-text
                                    class="flex justify-between w-full"
                                >
                                    <div
                                        class="text-green-600 items-center flex cursor-pointer"
                                    >
                                        <v-icon
                                            icon="mdi-store-outline"
                                            class="mr-2"
                                        ></v-icon
                                        >{{ product.name }}
                                    </div>
                                    <div>
                                        {{
                                            product.distance
                                                ? distanceFormat(
                                                      product.distance
                                                  )
                                                : product.province
                                        }}
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
