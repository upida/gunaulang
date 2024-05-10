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

const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};
const sumTotal = computed(() => {
    let totalSum = 0;
    for (const order of usePage().props.data.order) {
        totalSum += order.total;
    }
    return totalSum;
});
const openDetail = (id) => {
    router.get(`/order/${id}`);
};
onMounted(() => {
    console.log(usePage());
});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />
    {{ data }}
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-5">
                <h1 class="font-bold text-lg text-uppercase">
                    Status Pembayaran
                </h1>
                <div
                    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col space-y-5 justify-center items-center"
                >
                    <div
                        class="border-4 border-green-500 p-2 rounded-full w-14 h-14 flex justify-center items-center"
                    >
                        <v-icon
                            icon="mdi-check"
                            class="text-green-500"
                        ></v-icon>
                    </div>
                    <p class="text-gray-400">
                        Anda telah berhasil melakukan pembayaran sejumlah Rp
                        {{ moneyFormat(sumTotal) }}
                    </p>
                    <div
                        v-for="order in data.order"
                        class="rounded-md p-5 border flex justify-between w-full"
                    >
                        <p>
                            {{ order.name }} - Rp {{ moneyFormat(order.total) }}
                        </p>
                        <PrimaryButton
                            @click="openDetail(order.id)"
                            class="ms-4 text-center justify-center flex"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="selectedProduct == 0"
                        >
                            Lihat Detail Transaksi
                        </PrimaryButton>
                    </div>
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
