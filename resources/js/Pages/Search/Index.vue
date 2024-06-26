<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, reactive } from "vue";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import CardSearch from "@/Components/CardSearch.vue";
import CardProduct from "@/Components/CardProduct.vue";
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

const formatDate = (date) => {
    const options = {
        weekday: "long", // Full day name (e.g., "Kamis")
        day: "numeric", // Day of the month (e.g., "16")
        month: "long", // Full month name (e.g., "Februari")
        year: "numeric", // Full year (e.g., "2024")
    };

    // Convert date to Indonesian local time format
    return date.toLocaleDateString("id-ID", options);
};
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
};
let params = reactive({
    price_start: "",
    price_end: "",
    keyword: "",
    expired_at_start: null,
    expired_at_end: null,
    is_new: false,
    is_food: false,
});
const is_new = ref(false);
const is_food = ref(false);

const openProduct = (store, title) => {
    router.get(`/${store}/${title}`);
};
const doFilter = (val = "") => {
    params.expired_at_start = dateRange.value?.[0] ?? undefined;
    params.expired_at_end = dateRange.value?.[1] ?? undefined;
    params.price_start = priceRange.value?.[0] ?? undefined;
    params.price_end = priceRange.value?.[1] ?? undefined;
    params.is_new = is_new.value;
    params.is_food = is_food.value;
    params.keyword = val ?? undefined;
    router.get("/search", params);
};
const priceRange = ref([0, 100000]);
const dateRange = ref();
onMounted(() => {
    params.keyword = route().params.keyword;
    params = { ...params, ...route().params };
    dateRange.value = [params.expired_at_start, params.expired_at_end];
    is_new.value = params.is_new === "true";
    is_food.value = params.is_food === "true";
});
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">
                <div class="flex space-x-5 items-center">
                    <CardSearch
                        v-model="params.keyword"
                        @search="(val) => doFilter(val)"
                        class="w-full"
                    />
                    <v-dialog max-width="600">
                        <template v-slot:activator="{ props: activatorProps }">
                            <div class="bg-white rounded-lg shadow p-6">
                                <v-icon
                                    v-bind="activatorProps"
                                    icon="mdi-filter-outline"
                                    class="cursor-pointer"
                                ></v-icon>
                            </div>
                        </template>

                        <template v-slot:default="{ isActive }">
                            <v-card title="Filter">
                                <v-card-text
                                    class="py-6 flex flex-col space-y-6"
                                >
                                    <div>
                                        <label for="">Rentang harga</label>
                                        <v-range-slider
                                            v-model="priceRange"
                                            :min="0"
                                            :max="100000"
                                            thumb-label="always"
                                            hide-details
                                            strict
                                        ></v-range-slider>
                                    </div>
                                    <div>
                                        <label for=""
                                            >Rentang tanggal kadaluwarsa</label
                                        >
                                        <VueDatePicker
                                            class="z-50 relative"
                                            v-model="dateRange"
                                            range
                                            auto-apply
                                            :enable-time-picker="false"
                                            :auto-position="false"
                                            teleport-center
                                        />
                                    </div>
                                    <div>
                                        <Toggle
                                            v-model:checked="is_new"
                                            label="Kondisi baru"
                                        />
                                    </div>
                                    <div>
                                        <Toggle
                                            v-model:checked="is_food"
                                            label="Makanan"
                                        />
                                    </div>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <PrimaryButton
                                        @click="
                                            isActive.value = false;
                                            doFilter();
                                        "
                                        class="ms-4"
                                        :class="{
                                            'opacity-25': form.processing,
                                        }"
                                        :disabled="form.processing"
                                    >
                                        Tampilkan
                                    </PrimaryButton>
                                </v-card-actions>
                            </v-card>
                        </template>
                    </v-dialog>
                </div>
                <h1 class="font-bold text-lg mb-5 text-uppercase">
                    {{ data.product?.length }} Hasil Pencarian
                </h1>
                <div class="grid sm:grid-cols-4 grid-cols-1 gap-6">
                    <CardProduct
                        v-for="product in data.product"
                        :name="product.title"
                        @click="openProduct(product.storename, product.title)"
                        :image="product.media"
                        :distance="product.distance"
                        :store_name="product.name"
                        :province="product.province"
                        :price="product.price"
                    />
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
