<script setup>
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { onMounted, reactive, ref } from "vue";
import axios from "axios";
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
const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};

const form = reactive({
    id: usePage().props.data.product.id,
    quantity: null,
});
onMounted(() => {});
const addToCart = async () => {
    // console.log()
    axios
        .post(`${route().t.url}/cart/add`, form)
        .then(function (response) {
            success.value = true;
        })
        .catch(function (error) {
            console.log(error);
        });
    // return response.json(); // parses JSON response into native JavaScript objects
    form.quantity = null;
};
const success = ref(false);
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="flex sm:flex-row flex-col sm:space-x-5">
                        <div class="w-full">
                            <v-carousel class="" hide-delimiters>
                                <v-carousel-item
                                    v-for="media in data.product_media"
                                    :src="`${route().t.url}/storage/${
                                        media.path
                                    }`"
                                    cover
                                ></v-carousel-item>
                            </v-carousel>
                        </div>

                        <div class="w-full">
                            <div class="mt-2 space-y-2">
                                <h1 class="font-bold text-lg mb-3">
                                    {{ data.product.title }}
                                </h1>
                                <div class="flex justify-between items-center">
                                    <h2
                                        v-if="data.product.price > 0"
                                        class="font-semibold text-md mb-5"
                                    >
                                        Rp {{ moneyFormat(data.product.price) }}
                                    </h2>
                                    <h2
                                        v-else
                                        class="font-semibold text-md text-green-500 mb-5"
                                    >
                                        Gratis!
                                    </h2>
                                    <small class="text-md mb-5">
                                        {{ data.product.stock }} item tersedia
                                    </small>
                                </div>

                                <small class="text-uppercase text-gray-500"
                                    >Deskripsi</small
                                >
                                <p class="mb-5">
                                    {{ data.product.description }}
                                </p>

                                <small class="text-uppercase text-gray-500"
                                    >Info Toko</small
                                >
                                <div class="items-center flex">
                                    <v-icon
                                        icon="mdi-store-outline"
                                        class="mr-2"
                                    ></v-icon
                                    >{{ data.store.name }} - Kab.
                                    {{ data.store.district }},
                                    {{ data.store.province }}
                                </div>
                                <div>Alamat: {{ data.store.address }}</div>
                                <div class="flex justify-end sm:mt-0 mt-5">
                                    <TextInput
                                        id="quantity"
                                        type="number"
                                        class="mt-1 block"
                                        v-model="form.quantity"
                                    />
                                    <PrimaryButton
                                        @click="addToCart"
                                        class="ms-4 col-span-2 text-center justify-center flex"
                                    >
                                        Masukkan Keranjang
                                    </PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </BasicLayout>
    <v-snackbar v-model="success">
        Dimasukkan ke keranjang
        <template v-slot:actions>
            <v-btn color="pink" variant="text" @click="success = false">
                Tutup
            </v-btn>
        </template>
    </v-snackbar>
</template>
