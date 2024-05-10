<script setup>
import { computed, ref } from "vue";
import TextInput from "@/Components/TextInput.vue";
import { onMounted } from "vue";

const emit = defineEmits(["search", "update:modelValue"]);

const props = defineProps({
    modelValue: String,
});

onMounted(() => {});
</script>
<template>
    <div class="p-5 sm:rounded-lg bg-white shadow">
        <TextInput
            id="name"
            type="text"
            class="w-full"
            placeholder="Cari"
            autofocus
            :value="props.modelValue"
            @input="(e) => emit('update:modelValue', e.target.value)"
            autocomplete="off"
            @keyup.enter="(e) => emit('search', e.target.value)"
        />
    </div>
</template>
