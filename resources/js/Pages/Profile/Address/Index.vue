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
                <h1 class="font-bold text-lg text-uppercase">Alamat Utama</h1>
                <Address
                    :address="data.active.address"
                    :name="data.active.name"
                />
                <h1 class="font-bold text-lg mt-14 text-uppercase">
                    Alamat Lainnya
                </h1>
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
