<script setup>
import { Head } from '@inertiajs/vue3';
import BasicLayout from '@/Layouts/BasicLayout.vue'
import DonatorLayout from '@/Layouts/DonatorLayout.vue'
import StoreUpdate from '@/Components/Store/Update.vue'
import StoreProduct from '@/Components/Store/Product.vue'
import ProductCreate from '@/Components/Product/Create.vue'

const data = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    store: {
        type: Object
    },
    products: {
        type: Array
    }
});

</script>

<template>
    <Head title="Donator" />
    
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <DonatorLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
    
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <StoreProduct :products="products" class="max-w-xl" />
                    </div>
    
                </div>
            </div>
        </DonatorLayout>
    </BasicLayout>

</template>
