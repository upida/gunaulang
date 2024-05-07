<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toggle from "@/Components/Toggle.vue";
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-bold text-lg mb-5 text-uppercase">Keranjang</h1>
                <div class="space-y-6">
                    <v-card class="w-full py-2">
                        <v-card-item>
                            <v-card-title>
                                <v-avatar class="mr-3">
                                    <v-img
                                        alt="John"
                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                    ></v-img> </v-avatar
                                >Card title
                            </v-card-title>
                        </v-card-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-list lines="two">
                                <v-list-item
                                    rounded="0"
                                    prepend-avatar="https://cdn.vuetifyjs.com/images/lists/2.jpg"
                                >
                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action start>
                                            <v-checkbox-btn
                                                :model-value="isActive"
                                            ></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                    <template v-slot:title>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div class="flex items-center">
                                                <div>
                                                    <v-img
                                                        width="50"
                                                        height="50"
                                                        class=""
                                                        alt="John"
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                    ></v-img>
                                                </div>
                                                <p class="ml-4">Summer BBQ</p>
                                            </div>
                                            <div
                                                class="flex items-center space-x-5"
                                            >
                                                <p>Rp 80.000</p>
                                                <div class="flex items-center">
                                                    <v-icon
                                                        size="16"
                                                        color="green"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-minus
                                                    </v-icon>
                                                    <TextInput
                                                        id="quantity"
                                                        type="number"
                                                        class="mt-1 block w-16"
                                                        v-model="form.quantity"
                                                        required
                                                        autofocus
                                                        autocomplete="username"
                                                    />
                                                    <v-icon
                                                        color="red"
                                                        size="16"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-plus
                                                    </v-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </v-list-item>

                                <v-divider inset></v-divider>

                                <v-list-item
                                    rounded="0"
                                    prepend-avatar="https://cdn.vuetifyjs.com/images/lists/2.jpg"
                                >
                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action start>
                                            <v-checkbox-btn
                                                :model-value="isActive"
                                            ></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                    <template v-slot:title>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div class="flex items-center">
                                                <div>
                                                    <v-img
                                                        width="50"
                                                        height="50"
                                                        class=""
                                                        alt="John"
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                    ></v-img>
                                                </div>
                                                <p class="ml-4">Summer BBQ</p>
                                            </div>
                                            <div
                                                class="flex items-center space-x-5"
                                            >
                                                <p>Rp 80.000</p>
                                                <div class="flex items-center">
                                                    <v-icon
                                                        size="16"
                                                        color="green"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-minus
                                                    </v-icon>
                                                    <TextInput
                                                        id="quantity"
                                                        type="number"
                                                        class="mt-1 block w-16"
                                                        v-model="form.quantity"
                                                        required
                                                        autofocus
                                                        autocomplete="username"
                                                    />
                                                    <v-icon
                                                        color="red"
                                                        size="16"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-plus
                                                    </v-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </v-list-item>

                                <v-divider inset></v-divider>

                                <v-list-item
                                    rounded="0"
                                    prepend-avatar="https://cdn.vuetifyjs.com/images/lists/2.jpg"
                                >
                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action start>
                                            <v-checkbox-btn
                                                :model-value="isActive"
                                            ></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                    <template v-slot:title>
                                        <div
                                            class="flex items-center justify-between"
                                        >
                                            <div class="flex items-center">
                                                <div>
                                                    <v-img
                                                        width="50"
                                                        height="50"
                                                        class=""
                                                        alt="John"
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                    ></v-img>
                                                </div>
                                                <p class="ml-4">Summer BBQ</p>
                                            </div>
                                            <div
                                                class="flex items-center space-x-5"
                                            >
                                                <p>Rp 80.000</p>
                                                <div class="flex items-center">
                                                    <v-icon
                                                        size="16"
                                                        color="green"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-minus
                                                    </v-icon>
                                                    <TextInput
                                                        id="quantity"
                                                        type="number"
                                                        class="mt-1 block w-16"
                                                        v-model="form.quantity"
                                                        required
                                                        autofocus
                                                        autocomplete="username"
                                                    />
                                                    <v-icon
                                                        color="red"
                                                        size="16"
                                                        class="cursor-pointer"
                                                    >
                                                        mdi-plus
                                                    </v-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                    </v-card>
                    <div
                        class="px-4 py-3 sm:p-8 bg-white shadow sm:rounded-lg flex justify-end space-x-2"
                    >
                        <div class="text-end">
                            <p class="font-semibold text-lg">Total</p>
                            <p class="">Rp 12.000</p>
                        </div>
                        <PrimaryButton
                            class="ms-4 text-center justify-center flex"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Checkout (2)
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
