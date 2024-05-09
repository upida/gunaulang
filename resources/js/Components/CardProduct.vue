<script setup>
import { computed } from "vue";

const emit = defineEmits(["edit"]);

const props = defineProps({
    image: {
        type: String,
        default: "",
    },
    name: {
        type: String,
    },
    description: {
        type: String,
    },
    price: {
        type: [String, Number],
    },
    store_name: {
        type: String,
    },
});
const moneyFormat = (args) => {
    if (args !== null && args !== undefined && args > 0) {
        args = Math.round(args);

        // Format the input value in Indonesian currency format
        return args.toLocaleString("id-ID");
    }
    return 0;
};
</script>
<template>
    <v-card class="" max-width="400">
        <v-img
            class="align-end text-white"
            height="200"
            :src="props.image"
            cover
        >
            <!-- <v-card-title
                                >Top 10 Australian beaches</v-card-title
                            > -->
        </v-img>

        <v-card-title class="pt-4"> {{ props.name }} </v-card-title>
        <v-card-subtitle class="pt-4"
            >Rp {{ moneyFormat(props.price) }}</v-card-subtitle
        >

        <v-card-text>
            <div>{{ props.description }}</div>
            <div
                v-if="props.store_name"
                class="text-green-600 items-center flex cursor-pointer"
            >
                <v-icon icon="mdi-store-outline" class="mr-2"></v-icon
                >{{ props.store_name }}
            </div>
        </v-card-text>
    </v-card>
</template>
