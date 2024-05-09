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
    distance: {
        type: [String, Number],
    },
    store_name: {
        type: String,
    },
    image: {
        type: Array,
    },
});
const distanceFormat = (args) => {
    if (args) {
        if (args < 1000) {
            return `${args} M`;
        }
        return `${Math.round(args / 1000)} KM`;
    }
    return `0 M`;
};
</script>
<template>
    <v-card class="" max-width="400">
        <v-img
            class="text-white align-end"
            height="200"
            cover
            :src="`${route().t.url}/storage/${props.image?.[0]?.path}`"
        >
        </v-img>

        <v-card-title class="pt-4"> {{ props.name }} </v-card-title>
        <v-card-text>
            <div>
                {{ distanceFormat(props.distance) }}
            </div>
            <div class="text-green-600 items-center flex cursor-pointer">
                <v-icon icon="mdi-store-outline" class="mr-2"></v-icon
                >{{ props.store_name }}
            </div>
        </v-card-text>
    </v-card>
</template>
