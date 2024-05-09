<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import Address from "@/Components/Address.vue";
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
const query = ref("");
const doSearch = () => {
    router.get("/search", query.value);
    query.value = "";
};
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
            {{data}}
            <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 space-y-8">
                <Address
                    :address="data.address.address"
                    :name="data.address.name"
                />

                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <div class="flex items-center space-x-8 mb-5">
                        <a
                            v-for="cat in categories"
                            class="rounded-full mx-auto w-14 h-14 sm:w-36 sm:h-36 sm:text-md text-sm cursor-pointer text-center"
                        >
                            <img
                                class="w-14 h-14 sm:w-36 sm:h-36 object-cover rounded-full mb-3"
                                :src="cat.image"
                            />
                            {{ cat.label }}
                        </a>
                    </div>
                </div>
                <div class="p-5 mx-20 sm:rounded-lg bg-white shadow">
                    <TextInput
                        id="name"
                        type="text"
                        class="w-full"
                        placeholder="Cari"
                        autofocus
                        autocomplete="name"
                        @keyup.enter="doSearch"
                    />
                </div>
                <div class="p-4 sm:p-8 sm:rounded-lg grid grid-cols-4 gap-6">
                    <v-card v-for="i in 6" class="" max-width="400">
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

                        <v-card-title class="pt-4"> Nama Produk </v-card-title>

                        <v-card-text>
                            <div>Deskripsi Produk</div>
                        </v-card-text>
                    </v-card>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
