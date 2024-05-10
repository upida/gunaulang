<script setup>
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toggle from "@/Components/Toggle.vue";
import Address from "@/Components/Address.vue";
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

const form = useForm({
    is_active: false,
    name: "",
    phone: "",
    address: "",
    subdistrict: "",
    district: "",
    city: "",
    province: "",
    latitude: "",
    longitude: "",
    gmaps_point: "",
    notes: "",
});
const toast = reactive({
    edit: false,
    checkout: false,
});

const payNow = () => {};

const donate = ref(null);
const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};

onMounted(() => {});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-5">
                <h1 class="font-bold text-lg text-uppercase">
                    Detail Transaksi
                </h1>

                <h2 class="font-semibold text-md">Lokasi Penerima</h2>
                <Address
                    :address="data.address.address"
                    :name="data.address.name"
                    :show-icon="false"
                />

                <h2 class="font-semibold text-md">Detail Pesanan</h2>

                <div class="space-y-6">
                    <v-card class="w-full py-2">
                        <v-card-item>
                            <v-card-title>
                                <div
                                    class="w-full justify-between flex items-center"
                                >
                                    <p>
                                        {{ data.store.name }}
                                    </p>
                                    <p class="text-sm">
                                        {{ data.store.province }}
                                    </p>
                                </div>
                            </v-card-title>
                        </v-card-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-list lines="two">
                                <v-list-item
                                    v-for="item in data.products"
                                    rounded="0"
                                    class="items-center"
                                >
                                    <template v-slot:title>
                                        <div
                                            class="flex sm:flex-row flex-col items-center sm:justify-between"
                                        >
                                            <div class="flex items-center">
                                                <p class="ml-4">
                                                    {{ item.product_title }}
                                                </p>
                                            </div>
                                            <div
                                                class="flex items-center space-x-5"
                                            >
                                                <p>
                                                    Rp
                                                    {{
                                                        moneyFormat(item.price)
                                                    }}
                                                </p>
                                                <p>x {{ item.quantity }}</p>
                                            </div>
                                        </div>
                                    </template>
                                </v-list-item>

                                <v-divider inset></v-divider>
                            </v-list>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions class="flex justify-end space-x-5 px-8">
                            <h1 class="font-bold">Total:</h1>
                            <p>Rp {{ moneyFormat(data.payment.total) }}</p>
                        </v-card-actions>
                    </v-card>
                </div>
            </div>
        </div>
    </BasicLayout>
    <v-snackbar v-model="toast.edit">
        Berhasil mengubah jumlah
        <template v-slot:actions>
            <v-btn color="pink" variant="text" @click="toast.edit = false">
                Tutup
            </v-btn>
        </template>
    </v-snackbar>
    <v-snackbar v-model="toast.checkout">
        Berhasil checkout
        <template v-slot:actions>
            <v-btn color="pink" variant="text" @click="toast.edit = false">
                Tutup
            </v-btn>
        </template>
    </v-snackbar>
</template>
