<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import Address from "@/Components/Address.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

const submit = () => {
    router.post("/profile/address/create", form);
    form.reset();
    // form.post(route("/profile/address/create"), {
    //     onFinish: () => ,
    // });
};
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col space-y-6"
            >
                <h1 v-if="data.active" class="font-bold text-lg text-uppercase">
                    Alamat Utama
                </h1>
                <Address
                    v-if="data.active"
                    :address="data.active.address"
                    :name="data.active.name"
                />
                <h1
                    v-if="
                        data.address &&
                        data.address.filter((addr) => addr.id != data.active.id)
                            .length > 0
                    "
                    class="font-bold text-lg mt-14 text-uppercase"
                >
                    Alamat Lainnya
                </h1>
                <div
                    v-if="!data.active && data.address.length == 0"
                    class="p-4 sm:p-8 bg-white shadow sm:rounded-lg flex flex-col space-y-5 justify-center items-center"
                >
                    <div
                        class="border-4 border-gray-500 p-2 rounded-full w-14 h-14 flex justify-center items-center"
                    >
                        <v-icon
                            icon="mdi-exclamation"
                            class="text-gray-500"
                        ></v-icon>
                    </div>
                    <p class="text-gray-400">
                        Anda belum memiliki alamat, harap tambah alamat untuk
                        melakukan transaksi
                    </p>
                </div>
                <Address
                    v-for="address in data.address.filter(
                        (addr) => addr.id != data.active.id
                    )"
                    :address="address.address"
                    :name="address.name"
                />
                <PrimaryButton
                    @click="router.get(route('address.create'))"
                    class="text-center justify-center flex"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Tambah Alamat
                </PrimaryButton>
            </div>
        </div>
    </BasicLayout>
</template>
