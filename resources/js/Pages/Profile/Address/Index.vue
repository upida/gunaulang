<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
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
                    <div class="space-y-6">
                        {{ data }}
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
