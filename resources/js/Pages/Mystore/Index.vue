<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
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
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <div class="flex justify-between">
                <div class="flex">
                    <h2 class="flex font-semibold text-xl text-gray-800 leading-tight">Informasi Toko</h2>
                    <div class="flex space-x-8"></div>
                </div>
                <div class="flex">
                    <v-btn class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150" variant="outlined" rounded="lg" block :href="route('mystore.product')">Produk Toko</v-btn>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-xl">
                        <div
                            class="mt-2 space-y-6"
                        >
                            <div>
                                <span class="block font-medium text-sm text-gray-700">storename</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['storename'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">name</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['name'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">description</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['description'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">logo</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['logo'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">cover</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['cover'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">phone</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['phone'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">address</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['address'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">subdistrict</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['subdistrict'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">district</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['district'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">city</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['city'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">province</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['province'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">latitude</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['latitude'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">longitude</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['longitude'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">gmaps_point</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['gmaps_point'] }}
                                </p>
                            </div>
                            <div>
                                <span class="block font-medium text-sm text-gray-700">notes</span>
                                <p
                                    class="border-gray-300 mt-1 block w-full"
                                >
                                    {{ data.store['notes'] }}
                                </p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
