<script setup>
import { Head, Link, useForm, router, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toggle from "@/Components/Toggle.vue";
import { onMounted } from "vue";
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
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-bold text-lg mb-5 text-uppercase">Keranjang</h1>
                <div class="space-y-6">
                    <v-card
                        v-for="cart in Object.keys(data.cart)"
                        class="w-full py-2"
                    >
                        <v-card-item>
                            <v-card-title>
                                <v-avatar class="mr-3">
                                    <v-img
                                        alt="John"
                                        src="https://cdn.vuetifyjs.com/images/john.jpg"
                                    ></v-img> </v-avatar
                                >{{ cart }}
                            </v-card-title>
                        </v-card-item>
                        <v-divider></v-divider>
                        <v-card-text>
                            <v-list lines="two">
                                <v-list-item
                                    v-for="item in data.cart[cart].product"
                                    rounded="0"
                                    prepend-avatar="https://cdn.vuetifyjs.com/images/lists/2.jpg"
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
                            class="ms-4 text-center justify-center flex"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Checkout ({{ selectedProduct }})
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
