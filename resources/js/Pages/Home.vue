<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import { ref } from "vue";

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
const categories = ref([
    {
        label: "Makan gratis disini!",
        image: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Makan murah",
        image: "https://images.unsplash.com/photo-1606787366850-de6330128bfc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Butuh limbah makanan?",
        image: "https://images.unsplash.com/photo-1553787434-45e1d245bfbb?q=80&w=2020&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Produk olahan limbah makananmu",
        image: "https://images.unsplash.com/photo-1587733761376-3f26fc81d17f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
]);
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-between items-center w-full">
                        <div class="flex items-center space-x-5">
                            <v-icon
                                icon="mdi-map-marker-outline"
                                class="cursor-pointer"
                            ></v-icon>
                            <p>
                                {{ data.address.address }}
                            </p>
                        </div>
                        <v-icon
                            icon="mdi-pencil"
                            class="cursor-pointer text-orange-500"
                        ></v-icon>
                    </div>
                </div>

                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <div class="flex items-center space-x-8">
                        <a
                            v-for="cat in categories"
                            class="rounded-full mx-auto w-36 h-36 cursor-pointer text-center"
                        >
                            <img
                                class="w-36 h-36 object-cover rounded-full mb-3"
                                :src="cat.image"
                            />
                            {{ cat.label }}
                        </a>
                    </div>
                </div>
                <div class="p-4 sm:p-8 sm:rounded-lg grid grid-cols-4 gap-6">
                    <v-card v-for="i in 6" class="mx-auto" max-width="400">
                        <v-img
                            class="align-end text-white"
                            height="200"
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            cover
                        >
                            <!-- <v-card-title
                                >Top 10 Australian beaches</v-card-title
                            > -->
                        </v-img>

                        <v-card-subtitle class="pt-4">
                            Nama Produk
                        </v-card-subtitle>

                        <v-card-text>
                            <div>Deskripsi Produk</div>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn
                                prepend-icon="mdi-cart-plus"
                                color="black"
                                text="Masukkan keranjang"
                                class="w-full px-5"
                                variant="flat"
                            >
                                <template v-slot:prepend>
                                    <v-icon color="white"></v-icon> </template
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
