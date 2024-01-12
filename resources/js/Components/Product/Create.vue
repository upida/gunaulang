<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from 'vue'

const previewImages = ref([]);
const openExpiredDate = ref(false)
const fileInput = ref(null)

const form = useForm({
    title: "",
    description: "",
    stock: 0,
    condition: "",
    expired_at: null,
    status: true,
    food: false,
    danger: false,
    images: null
});


const formatDate = function(date) {
    date = new Date(date);
    const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
    return date.toLocaleDateString([], options);
}

const openFileInput = () => {
    if (fileInput.value) {
        fileInput.value.click();
    }
};

const handleFileChange = (event) => {
    for (const file of event.target.files) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImages.value.push({
                url: e.target.result,
                file,
            });
            form.images = previewImages;
        };
        reader.readAsDataURL(file);
    }
}

const deletePreviewImages = (index) => {
    previewImages.value.splice(index, 1);
    form.images = previewImages;
}


</script>

<template>
    <header class="v-col-12">
        <h2 class="text-lg font-medium text-gray-900">
            What will you donate today?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            One thing <b>from you</b>, one smile <b>for them</b>.
        </p>
    </header>

    <form
        @submit.prevent="form.post(route('donator.donate'))"
        class="v-row mt-6 space-y-6"
    >
        <v-col cols="12" sm="6" md="6" lg="6" class="space-y-6">
            <div>
                <InputLabel for="title" value="Title" />
    
                <v-text-field
                    placeholder="Title"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="title"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.title"
                    required
                    autofocus
                    autocomplete="title"
                ></v-text-field>
    
                <InputError class="mt-2" :message="form.errors.title" />
            </div>
    
            <div>
                <InputLabel for="description" value="Description" />
    
                <v-text-field
                    placeholder="Description"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="description"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.description"
                    required
                    autocomplete="description"
                ></v-text-field>
    
                <InputError class="mt-2" :message="form.errors.description" />
            </div>
    
            <div>
                <InputLabel for="stock" value="Stock" />
    
                <v-text-field
                    placeholder="Stock"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="phone"
                    type="number"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.stock"
                    required
                    autocomplete="stock"
                ></v-text-field>
    
                <InputError class="mt-2" :message="form.errors.stock" />
            </div>
    
            <div>
                <InputLabel for="condition" value="Condition" />
    
                <v-text-field
                    placeholder="Condition"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="cover"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.condition"
                    required
                    autocomplete="condition"
                ></v-text-field>
    
                <InputError class="mt-2" :message="form.errors.condition" />
            </div>
    
            <div>
                <InputLabel for="expired_at" value="Expired At" />
    
                <v-menu v-model="openExpiredDate" :close-on-content-click="false">
                    <template v-slot:activator="{ props }">
                        <v-text-field
                            v-bind="props"
                            placeholder="Expired at"
                            variant="outlined"
                            single-line
                            hide-details
                            density="compact"
                            id="cover"
                            type="text"
                            class="text-teal-600 mt-1 block w-full"
                            :value="form.expired_at ? formatDate(form.expired_at) : ''"
                            readonly
                            prepend-icon="mdi-calendar"
                            autocomplete="expired_at"
                        ></v-text-field>
                    </template>
    
                    <v-date-picker show-adjacent-months no-title scrollable v-model="form.expired_at">
                        <template #actions>
                            <v-btn
                                text
                                color="teal-lighten-2"
                                @click="openExpiredDate = false"
                            >
                                Close
                            </v-btn>
                        </template>
                    </v-date-picker>
                </v-menu>
    
                <InputError class="mt-2" :message="form.errors.expired_at" />
            </div>
    
            <div>
                <InputLabel for="status" value="Status" />
    
                <v-switch
                    v-model="form.status"
                    hide-details
                    inset
                    color="teal-lighten-2"
                    :label="form.status ? 'Active' : 'Inactive'"
                ></v-switch>
    
                <InputError class="mt-2" :message="form.errors.status" />
            </div>
    
            <div>
                <InputLabel for="food" value="Food" />
    
                <v-switch
                    v-model="form.food"
                    hide-details
                    inset
                    color="teal-lighten-2"
                    :label="form.food ? 'Yes' : 'No'"
                ></v-switch>
    
                <InputError class="mt-2" :message="form.errors.food" />
            </div>
    
            <div>
                <InputLabel for="danger" value="Danger" />
    
                <v-switch
                    v-model="form.danger"
                    hide-details
                    inset
                    color="teal-lighten-2"
                    :label="form.danger ? 'Yes' : 'No'"
                ></v-switch>
    
                <InputError class="mt-2" :message="form.errors.danger" />
            </div>
        </v-col>

        <v-col cols="12" sm="6" md="6" lg="6">
            <input
                type="file"
                accept="image/*"
                multiple
                @change="handleFileChange"
                ref="fileInput"
                style="display: none"
                name="images"
            />
            <v-row>
                <v-col v-for="(file, index) in previewImages" :key="index" cols="4">
                    <v-hover v-slot="{ isHovering, props }">
                        <v-card v-bind="props" class="preview-upload">
                            <v-img
                                :src="file.url"
                                contain
                                height="150"
                            ></v-img>
                            <v-overlay
                                :model-value="isHovering"
                                contained
                                scrim="#036358"
                                class="align-center justify-center"
                            >
                                <v-btn @click="deletePreviewImages(index)" icon variant="text"><v-icon size="large" color="red">mdi-trash-can</v-icon></v-btn>
                            </v-overlay>
                        </v-card>
                    </v-hover>
                </v-col>
                <v-col cols="4">
                    <v-card @click="openFileInput" class="button-upload d-flex items-center justify-center">
                        <v-icon size="48" class="">mdi-plus</v-icon>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>

        <v-col cols="12" class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing"
                >Create</PrimaryButton
            >

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p
                    v-if="form.recentlySuccessful"
                    class="text-sm text-gray-600"
                >
                    Created.
                </p>
            </Transition>
        </v-col>
    </form>
</template>
<style scoped>
.button-upload {
    cursor: pointer;
    border: 2px dashed #757575;
    border-radius: 8px;
    height:150px;
}

.preview-upload {
    border: 2px solid #757575;
    border-radius: 8px;
}
</style>