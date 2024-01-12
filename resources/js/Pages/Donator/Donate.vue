<script setup>
import { Head } from '@inertiajs/vue3';
import BasicLayout from '@/Layouts/BasicLayout.vue'
import DonatorLayout from '@/Layouts/DonatorLayout.vue'
import ProductCreate from '@/Components/Product/Create.vue'

const data = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    }
});

</script>

<template>
    <Head title="Store - Donator" />
    
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <DonatorLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <ProductCreate class="v-row" />
                    </div>
                </div>
            </div>
        </DonatorLayout>
    </BasicLayout>

</template>
