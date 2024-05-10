<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import CardProduct from "@/Components/CardProduct.vue";
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
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <div class="flex justify-between">
                <div class="flex">
                    <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">Produk</h2>
                    <div class="flex space-x-8"></div>
                </div>
                <div class="flex">
                    <v-btn class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" variant="outlined" rounded="lg" block :href="route('mystore.product.create')">Buat Produk Baru</v-btn>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="mt-2 space-y-6">
                        <div class="grid sm:grid-cols-4 grid-cols-1 gap-6">
                        <!-- @click="openProduct(product.storename, product.title)" -->
                            <CardProduct
                                v-for="product in data.product"
                                :name="product.title"
                                :image="product.media"
                                :store_name="product.name"
                            />
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
