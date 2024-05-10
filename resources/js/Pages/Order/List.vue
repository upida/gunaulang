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
const detail = (id) => {
    router.get(`/order/${id}`);
};
onMounted(() => {
    console.log(usePage());
});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-5">
                <h1 class="font-bold text-lg text-uppercase">
                    Daftar Transaksi
                </h1>
                <div
                    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col space-y-5 justify-center items-center"
                >
                    <div
                        v-for="order in data.order"
                        class="rounded-md p-5 border flex justify-between w-full"
                    >
                        <p>
                            {{ order.created }}
                        </p>
                        <p>
                            {{ order.store_name }}
                        </p>
                        <p>
                            {{ order.status }}
                        </p>
                        <p>
                            Rp {{ moneyFormat(order.total) }}
                        </p>
                        <PrimaryButton
                            @click="detail(order.id)"
                            class="ms-4 text-center justify-center flex"
                            :class="{ 'opacity-25': form.processing }"
                        >
                            Lihat Detail Transaksi
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
