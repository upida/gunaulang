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
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <v-table>
                        <thead>
                        <tr>
                            <th class="text-left">
                                Tanggal
                            </th>
                            <th class="text-left">
                                Username
                            </th>
                            <th class="text-left">
                                Total
                            </th>
                            <th class="text-left">
                                Status
                            </th>
                            <th class="text-left">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="item in data.order"
                            :key="item.id"
                        >
                            <td>{{ item.created }}</td>
                            <td>{{ item.username }}</td>
                            <td>{{ item.total }}</td>
                            <td>{{ item.status }}</td>
                            <td>
                                <v-btn :href="route('mystore.order.edit', {id: item.id})">Detail</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
