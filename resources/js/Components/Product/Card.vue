<script setup>
defineProps({
    product: {
        type: Object,
    }
});

const conditionColor = (condition) => {
    const color = {
        'new': 'blue',
        'like new': 'green',
        'pre loved': 'light-green',
        'slightly used': 'yellow',
        'gently used': 'orange',
        'worn': 'red',
        'expired': 'red',
    }
    return color[condition.toLowerCase()] ?? null;
}
</script>

<template>
    <v-card class="w-48 md:w-56">
        <v-img class="w-48 h-48 md:w-56 md:h-56 flex items-end" cover :aspect-ratio="1/1" :src="product.image ?? '#'" :alt="product.title">
            <template v-slot:placeholder>
                <div class="d-flex align-center justify-center fill-height">
                    <v-progress-circular
                    color="grey-lighten-4"
                    indeterminate
                    ></v-progress-circular>
                </div>
            </template>
        </v-img>
        <v-chip class="relative ml-1 mt-1" size="small" :color="conditionColor(product.condition)">{{ product.condition }}</v-chip>

        <v-card-title>{{ product.title }}</v-card-title>
        <v-card-subtitle v-if="product.expired_at" class="mb-2">
            {{ 'Expired at ' + product.expired_at }}
        </v-card-subtitle>
        
        <v-card-actions class="card-actions-bottom">
            <v-spacer></v-spacer>
            <v-chip variant="text">Stock: {{ product.stock ?? 0 }}</v-chip>
        </v-card-actions>
    </v-card>
</template>