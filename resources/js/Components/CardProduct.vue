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
});
</script>
<template>
    <v-card class="" max-width="400">
        <v-img class="align-end text-white" height="200" :src="props.image" cover>
            <!-- <v-card-title
                                >Top 10 Australian beaches</v-card-title
                            > -->
        </v-img>

        <v-card-title class="pt-4"> {{ props.name }} </v-card-title>

        <v-card-text>
            <div>{{ props.description }}</div>
        </v-card-text>
    </v-card>
</template>
