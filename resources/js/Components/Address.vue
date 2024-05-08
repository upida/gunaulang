<script setup>
import { computed } from "vue";

const emit = defineEmits(["edit"]);

const props = defineProps({
    icon: {
        type: String,
        default: "mdi-map-marker-outline",
    },
    name: {
        type: String,
    },
    address: {
        type: String,
    },
});
</script>
<template>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            <div class="flex justify-between items-center w-full">
                <div class="flex items-center space-x-5">
                    <v-icon :icon="props.icon" class="cursor-pointer"></v-icon>
                    <div>
                        <p v-if="props.name">
                            {{ props.name }}
                        </p>
                        <small v-if="props.address" class="text-sm text-gray-500">
                            {{ props.address }}
                        </small>
                    </div>
                </div>
                <v-icon
                    @click="emit('edit')"
                    icon="mdi-pencil"
                    class="cursor-pointer text-orange-500"
                ></v-icon>
            </div>
        </div>
    </div>
</template>
