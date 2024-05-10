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
import { onMounted, reactive } from "vue";
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
const updateCart = (id, quantity) => {
    axios
        .post(`${route().t.url}/cart/edit`, {
            id: id,
            quantity: quantity,
        })
        .then(function (response) {
            toast.edit = true;
        })
        .catch(function (error) {
            console.log(error);
        });
};

const checkout = () => {
    // Initialize an array to store the transformed data
    const transformedData = [];

    // Iterate through each store in the cart
    for (const storeName in usePage().props.data.cart) {
        const store = usePage().props.data.cart[storeName];
        let total = 0;

        // Initialize an array to store selected products for this store
        const selectedProducts = [];

        // Iterate through each product in the store
        for (const product of store.product) {
            // Check if the product is selected
            if (product.selected) {
                // Calculate the total for this product (quantity * price)
                const productTotal = product.quantity * product.price;
                // Add the product total to the store total
                total += productTotal;
                // Add the selected product to the selectedProducts array
                selectedProducts.push({
                    id: product.id,
                    title: product.title,
                    quantity: product.quantity,
                    price: product.price,
                });
            }
        }

        // If there are selected products for this store, add them to the transformedData array
        if (selectedProducts.length > 0) {
            transformedData.push({
                store: {
                    id: store.store.id,
                },
                total: {
                    all: total,
                },
                products: selectedProducts,
            });
        }
    }
    const payload = JSON.stringify({ products: transformedData }, null, 2);
    axios
        .post(`${route().t.url}/order/add`, payload)
        .then(function (response) {
            toast.checkout = true;
        })
        .catch(function (error) {});
};
const sumTotal = computed(() => {
    let total = 0;

    // Get the cart data
    const cart = usePage().props.data.cart;

    // Iterate through each store in the cart
    for (const store in cart) {
        // Iterate through each product in the store
        for (const product of cart[store].product) {
            // Check if the product is selected
            if (product.selected) {
                // Calculate the subtotal for the selected product (quantity * price)
                const subtotal = product.quantity * product.price;
                // Add the subtotal to the total
                total += subtotal;
            }
        }
    }

    return total;
});
const selectedProduct = computed(() => {
    let count = 0;

    // Get the cart data
    const cart = usePage().props.data.cart;

    // Iterate through each store in the cart
    for (const store in cart) {
        // Iterate through each product in the store
        for (const product of cart[store].product) {
            // Check if the product is selected
            if (product.selected) {
                // Increment the count if the product is selected
                count++;
            }
        }
    }

    return count;
});

const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};
// const datas = ref();
onMounted(() => {
    // Iterate through each store in the cart
    for (const store in usePage().props.data.cart) {
        // Iterate through each product in the store
        for (const product of usePage().props.data.cart[store].product) {
            // Add the 'selected' key with an initial value
            product.selected = false;
        }
    }
});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <h1 class="font-bold text-lg mb-5 text-uppercase">Keranjang</h1>
                <div class="space-y-6">
                    <v-card
                        v-for="cart in Object.keys(data.cart)"
                        class="w-full py-2"
                    >
                        <v-card-item>
                            <v-card-title>
                                <!-- <v-avatar class="mr-3">
                                    <v-img
                                        alt="John"
                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                    ></v-img> </v-avatar
                                > -->
                                {{ cart }}
                            </v-card-title>
                        </v-card-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-list lines="two">
                                <v-list-item
                                    v-for="item in data.cart[cart].product"
                                    rounded="0"
                                    class="items-center"
                                >
                                    <template v-slot:prepend="{ isActive }">
                                        <v-list-item-action start>
                                            <v-checkbox-btn
                                                v-model="item.selected"
                                            ></v-checkbox-btn>
                                        </v-list-item-action>
                                    </template>
                                    <template v-slot:title>
                                        <div
                                            class="flex sm:flex-row flex-col items-center sm:justify-between"
                                        >
                                            <div class="flex items-center">
                                                <!-- <div>
                                                    <v-img
                                                        width="50"
                                                        height="50"
                                                        class=""
                                                        alt="John"
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                    ></v-img>
                                                </div> -->
                                                <p class="ml-4">
                                                    {{ item.title }}
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

                                                <div class="flex items-center">
                                                    <v-icon
                                                        @click="
                                                            item.quantity -= 1;
                                                            updateCart(
                                                                item.id,
                                                                item.quantity
                                                            );
                                                        "
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
                                                        v-model="item.quantity"
                                                        required
                                                        @update:model-value="
                                                            updateCart(
                                                                item.id,
                                                                item.quantity
                                                            )
                                                        "
                                                        autofocus
                                                        autocomplete="username"
                                                    />
                                                    <v-icon
                                                        @click="
                                                            item.quantity += 1;
                                                            updateCart(
                                                                item.id,
                                                                item.quantity
                                                            );
                                                        "
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
                            </v-list>
                        </v-card-text>
                    </v-card>
                    <div
                        class="px-4 py-3 sm:p-8 bg-white shadow sm:rounded-lg flex justify-end space-x-2"
                    >
                        <div class="text-end">
                            <p class="font-semibold text-lg">Total</p>
                            <p class="">Rp {{ moneyFormat(sumTotal) }}</p>
                        </div>
                        <PrimaryButton
                            @click="checkout"
                            class="ms-4 text-center justify-center flex"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="selectedProduct == 0"
                        >
                            Pesan sekarang ({{ selectedProduct }})
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-5">
                <h1 class="font-bold text-lg text-uppercase">Pemesanan</h1>

                <h2 class="font-semibold text-md">Lokasi Penerima</h2>
                <Address />

                <h2 class="font-semibold text-md">Detail Pesanan</h2>

                <div class="space-y-6">
                    <v-card
                        v-for="cart in Object.keys(data.cart)"
                        class="w-full py-2"
                    >
                        <v-card-item>
                            <v-card-title>
                                <div
                                    class="w-full justify-between flex items-center"
                                >
                                    <p>
                                        {{ cart }}
                                    </p>
                                    <p class="text-sm">#5km</p>
                                </div>
                                <!-- <v-avatar class="mr-3">
                                    <v-img
                                        alt="John"
                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                    ></v-img> </v-avatar
                                > -->
                            </v-card-title>
                        </v-card-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-list lines="two">
                                <v-list-item
                                    v-for="item in data.cart[cart].product"
                                    rounded="0"
                                    class="items-center"
                                >
                                    <template v-slot:title>
                                        <div
                                            class="flex sm:flex-row flex-col items-center sm:justify-between"
                                        >
                                            <div class="flex items-center">
                                                <!-- <div>
                                                    <v-img
                                                        width="50"
                                                        height="50"
                                                        class=""
                                                        alt="John"
                                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                                    ></v-img>
                                                </div> -->
                                                <p class="ml-4">
                                                    {{ item.title }}
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
                            <p>Rp {{ moneyFormat(0) }}</p>
                        </v-card-actions>
                    </v-card>
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <h2 class="font-semibold text-md">
                            Merasa Terbantu? Kirim donasi untuk layanan kami
                        </h2>

                        <TextInput class="w-full" />
                    </div>
                    <h2 class="font-semibold text-md">Detail Pembayaran</h2>

                    <div
                        class="p-4 sm:p-8 bg-white shadow sm:rounded-lg grid grid-cols-2 gap-2 items-center"
                    >
                        <p>Subtotal</p>
                        <p class="text-right">Rp {{ moneyFormat(sumTotal) }}</p>
                        <p>Donasi</p>
                        <p class="text-right">Rp {{ moneyFormat(sumTotal) }}</p>
                        <p class="font-bold">Total</p>
                        <p class="text-right font-bold">
                            Rp {{ moneyFormat(sumTotal) }}
                        </p>
                    </div>
                    <PrimaryButton
                        @click="checkout"
                        class="w-full py-3 flex justify-center items-center"
                    >
                        Bayar sekarang
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </BasicLayout>
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-5">
                <h1 class="font-bold text-lg text-uppercase">Pembayaran</h1>
                <div
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
                        Anda telah melakukan transaksi sejumlah Rp
                        {{ moneyFormat(0) }}
                    </p>
                    <h2 class="font-semibold text-md items-start w-full">
                        Metode Pembayaran
                    </h2>
                    <v-list class="w-full">
                        <v-list-group value="Bank">
                            <template v-slot:activator="{ props }">
                                <v-list-item
                                    v-bind="props"
                                    prepend-icon="mdi-bank"
                                    title="Bank"
                                ></v-list-item>
                            </template>
                            <v-list-item
                                v-for="(title, i) in [
                                    'BCA',
                                    'BNI',
                                    'BSI',
                                    'Mandiri',
                                ]"
                                :key="i"
                                :title="title"
                                :value="title"
                            ></v-list-item>
                        </v-list-group>
                        <v-list-group value="E-wallet">
                            <template v-slot:activator="{ props }">
                                <v-list-item
                                    v-bind="props"
                                    prepend-icon="mdi-account"
                                    title="E-wallet"
                                ></v-list-item>
                            </template>
                            <v-list-item
                                v-for="(title, i) in [
                                    'Gopay',
                                    'OVO',
                                    'Shopeepay',
                                ]"
                                :key="i"
                                :title="title"
                                :value="title"
                            ></v-list-item>
                        </v-list-group>
                    </v-list>
                    <PrimaryButton
                        @click="payNow"
                        class="ms-4 text-center justify-center flex"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="selectedProduct == 0"
                    >
                        Lakukan Pembayaran
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </BasicLayout>
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
                        {{ moneyFormat(0) }}
                    </p>
                    <PrimaryButton
                        @click="payNow"
                        class="ms-4 text-center justify-center flex"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="selectedProduct == 0"
                    >
                        Lihat Detail Transaksi
                    </PrimaryButton>
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
