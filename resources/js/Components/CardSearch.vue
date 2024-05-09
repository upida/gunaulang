<script setup>
import { computed, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import { onMounted } from "vue";

const emit = defineEmits(["search"]);

const props = defineProps({
    modelValue: String,
});
const query = computed({
    get() {
        return props.modelValue;
    },

    set(val) {
        emit('update:modelValue', val);
    },
});
</script>
<template>
    <div class="p-5 sm:rounded-lg bg-white shadow">
        <TextInput
            id="name"
            type="text"
            class="w-full"
            placeholder="Cari"
            autofocus
            autocomplete="name"
            v-model="query"
            @keyup.enter="emit('search', query)"
        />
    </div>
</template>
