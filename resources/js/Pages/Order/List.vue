<script setup>
import { Head } from '@inertiajs/vue3';
import BasicLayout from '@/Layouts/BasicLayout.vue'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    orders: {
        type: Array
    }
});

</script>

<template>
    <Head title="Kindness and Sustainability with Goods and Grubs" />
    
    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">{{ orders }}</div>
                </div>
            </div>
        </div>
    </BasicLayout>

</template>
