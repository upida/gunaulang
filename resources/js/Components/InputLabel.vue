<script setup>
defineProps({
    value: {
        type: String
    },
    required: {
        type: Boolean
    }
});
</script>

<template>
    <label class="block font-medium text-sm text-gray-700" ref="label">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <v-tooltip v-if="required" text="Required">
            <template v-slot:activator="{ props }">
                <span v-bind="props" class="text-red-700"> *</span>
            </template>
        </v-tooltip>
    </label>
</template>
