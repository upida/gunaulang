<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import ProductCard from "@/Components/Product/Card.vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    searchResults: Array,
    q: String,
});

const searchQuery = ref("");
const filterOption = ref([]);
const isFilterModalOpen = ref(false);

if (router.page.props.q) searchQuery.value = router.page.props.q;

const groupedFilterOptions = [
    {
        text: "Group 1",
        items: ["Filter Option 1A", "Filter Option 1B", "Filter Option 1C"],
    },
    {
        text: "Group 2",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
    {
        text: "Group 3",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
    {
        text: "Group 4",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
    {
        text: "Group 5",
        items: ["Filter Option 1A", "Filter Option 1B", "Filter Option 1C"],
    },
    {
        text: "Group 6",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
    {
        text: "Group 7",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
    {
        text: "Group 8",
        items: ["Filter Option 2A", "Filter Option 2B", "Filter Option 2C"],
    },
];

const handleSearch = () => {
    router.visit(
        route("search", {
            q: searchQuery.value,
        })
    );
};

const resetFilters = () => {
    filterOption.value = "";
    searchQuery.value = "";
};

const openFilterModal = () => {
    isFilterModalOpen.value = true;
};

const closeFilterModal = () => {
    isFilterModalOpen.value = false;
};

const openProduct = (id) => {
    router.visit(
        route("product", {
            product: id,
        })
    );
};
</script>

<template>
    <Head title="Search" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <v-row class="items-center">
                <v-col>
                    <!-- Search and Filter Section -->
                    <v-text-field
                        class="sm:flex text-green-600"
                        v-model="searchQuery"
                        variant="outlined"
                        density="compact"
                        single-line
                        hide-details
                        autofocus
                        clearable
                        rounded
                        prepend-inner-icon="mdi-magnify"
                        append-inner-icon="mdi-chevron-right"
                        append-icon="mdi-filter"
                        @click:append="openFilterModal"
                        @click:appendInner="handleSearch"
                        @keyup.enter="handleSearch"
                    ></v-text-field>
                </v-col>
            </v-row>
            <!-- Filter Modal -->
            <v-dialog v-model="isFilterModalOpen" max-width="500px">
                <v-card>
                    <v-card-title>Filters</v-card-title>
                    <v-card-text>
                        <!-- Membuat v-select untuk setiap grup -->
                        <v-row>
                            <v-col
                                v-for="group in groupedFilterOptions"
                                :key="group.text"
                                cols="12"
                            >
                                <v-select
                                    v-model="filterOption[group.text]"
                                    :items="group.items"
                                    :label="group.text"
                                    variant="outlined"
                                    multiple
                                ></v-select>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="closeFilterModal" color="primary"
                            >Apply</v-btn
                        >
                        <v-btn @click="resetFilters" color="error">Reset</v-btn>
                        <v-btn @click="closeFilterModal">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <v-row>
                    <v-col
                        v-for="product in searchResults"
                        :key="product.id"
                        class="grid justify-items-center"
                    >
                        <ProductCard
                            @click="openProduct(product.id)"
                            :product="product"
                        />
                    </v-col>
                </v-row>
            </div>
        </div>
    </BasicLayout>
</template>

<style scoped>
.v-card {
    height: 370px;
}

.v-card-title {
    height: 45px;
}

.v-card-subtitle {
    height: 20px;
}

.card-actions-bottom {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
}
</style>
