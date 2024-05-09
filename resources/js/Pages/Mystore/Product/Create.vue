<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toggle from "@/Components/Toggle.vue";
import { ref } from "vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    data: {
        type: Object,
    },
});

const previewImages = ref([]);
const openExpiredDate = ref(false);
const fileInput = ref(null);

const form = useForm({
    title: "",
    description: "",
    stock: 1,
    is_new: true,
    is_food: false,
    price: 0,
    expired_at: null,
    media: [],
});

const submit = () => {
    router.post("/mystore/product/create", form);
    form.reset();
};

const formatDate = function (date) {
    date = new Date(date);
    const options = { day: "numeric", month: "numeric", year: "numeric" };
    return date.toLocaleDateString([], options);
};

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
                file: file,
            });
            form.media = previewImages;
        };
        reader.readAsDataURL(file);
    }
};

const deletePreviewImages = (index) => {
    previewImages.value.splice(index, 1);
    form.images = previewImages;
};
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Produk Baru</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="mt-6 space-y-6"
                        >
                            <div>
                                <InputLabel for="title" value="Nama" />
                                <TextInput
                                    id="title"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.title"
                                    required
                                    autofocus
                                    autocomplete="title"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>
                            <div>
                                <InputLabel for="description" value="Deskripsi" />
                                <TextInput
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    autocomplete="description"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.description"
                                />
                            </div>
                            <div>
                                <InputLabel for="stock" value="Stok" />
                                <TextInput
                                    id="stock"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.stock"
                                    required
                                    autocomplete="stock"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.stock"
                                />
                            </div>
                            <div>
                                <InputLabel for="price" value="Harga" />
                                <TextInput
                                    id="price"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.price"
                                    required
                                    autocomplete="price"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.price"
                                />
                            </div>
                            <div>
                                <InputLabel for="expired_at" value="Tanggal kadaluarsa" />
                                <v-menu
                                    v-model="openExpiredDate"
                                    :close-on-content-click="false"
                                >
                                    <template v-slot:activator="{ props }">
                                        <TextInput
                                            class="mt-1 block w-full"
                                            v-bind="props"
                                            id="expired_at"
                                            type="text"
                                            :value="
                                                form.expired_at
                                                    ? formatDate(form.expired_at)
                                                    : ''
                                            "
                                            readonly
                                        />
                                    </template>

                                    <v-date-picker
                                        show-adjacent-months
                                        no-title
                                        scrollable
                                        v-model="form.expired_at"
                                    >
                                        <template #actions>
                                            <v-btn
                                                text
                                                color="green-lighten-2"
                                                @click="openExpiredDate = false"
                                            >
                                                Close
                                            </v-btn>
                                        </template>
                                    </v-date-picker>
                                </v-menu>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.expired_at"
                                />
                            </div>
                            <div>
                                <Toggle
                                    v-model:checked="form.is_new"
                                    label="Kondisi baru"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.is_new"
                                />
                            </div>
                            <div>
                                <Toggle
                                    v-model:checked="form.is_food"
                                    label="Makanan"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.is_food"
                                />
                            </div>
                            <div>
                                <InputLabel for="media" value="Media" />
                                <input
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    @change="handleFileChange"
                                    ref="fileInput"
                                    style="display: none"
                                    name="media"
                                />
                                <v-row>
                                    <v-col
                                        v-for="(file, index) in previewImages"
                                        :key="index"
                                        cols="4"
                                    >
                                        <v-hover v-slot="{ isHovering, props }">
                                            <v-card v-bind="props" class="preview-upload">
                                                <v-img :src="file.url" contain height="150"></v-img>
                                                <v-overlay
                                                    :model-value="isHovering"
                                                    contained
                                                    scrim="#036358"
                                                    class="align-center justify-center"
                                                >
                                                    <v-btn
                                                        @click="deletePreviewImages(index)"
                                                        icon
                                                        variant="text"
                                                        ><v-icon size="large" color="red"
                                                            >mdi-trash-can</v-icon
                                                        ></v-btn
                                                    >
                                                </v-overlay>
                                            </v-card>
                                        </v-hover>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-card
                                            @click="openFileInput"
                                            class="button-upload d-flex items-center justify-center"
                                        >
                                            <v-icon size="48" class="">mdi-plus</v-icon>
                                        </v-card>
                                    </v-col>
                                </v-row>

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.media"
                                />
                            </div>
                            <PrimaryButton
                                class="ms-4 col-span-2 text-center justify-center flex"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Tambah Produk
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
