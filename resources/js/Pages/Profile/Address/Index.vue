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

const form = useForm({
    is_active: false,
    name: "",
    phone: "",
    address: "",
    subdistrict: "",
    district: "",
    city: "",
    province: "",
    latitude: "",
    longitude: "",
    gmaps_point: "",
    notes: "",
});

const submit = () => {
    router.post("/profile/address/create", form);
    form.reset();
    // form.post(route("/profile/address/create"), {
    //     onFinish: () => ,
    // });
};

const categories = ref([
    {
        label: "Makan gratis disini!",
        image: "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=2080&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Makan murah",
        image: "https://images.unsplash.com/photo-1606787366850-de6330128bfc?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Butuh limbah makanan?",
        image: "https://images.unsplash.com/photo-1553787434-45e1d245bfbb?q=80&w=2020&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
    {
        label: "Produk olahan limbah makananmu",
        image: "https://images.unsplash.com/photo-1587733761376-3f26fc81d17f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        action: () => {},
    },
]);
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="grid grid-cols-2 gap-6"
                        >
                            <div>
                                <InputLabel for="name" value="Nama Alamat" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>
                            <div>
                                <InputLabel for="address" value="Alamat" />
                                <TextInput
                                    id="address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.address"
                                    required
                                    autofocus
                                    autocomplete="address"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.address"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="subdistrict"
                                    value="Kecamatan"
                                />
                                <TextInput
                                    id="subdistrict"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.subdistrict"
                                    required
                                    autofocus
                                    autocomplete="subdistrict"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.subdistrict"
                                />
                            </div>
                            <div>
                                <InputLabel for="district" value="Kabupaten" />
                                <TextInput
                                    id="district"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.district"
                                    required
                                    autofocus
                                    autocomplete="district"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.district"
                                />
                            </div>
                            <div>
                                <InputLabel for="city" value="Kota" />
                                <TextInput
                                    id="city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.city"
                                    required
                                    autofocus
                                    autocomplete="city"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.city"
                                />
                            </div>
                            <div>
                                <InputLabel for="province" value="Provinsi" />
                                <TextInput
                                    id="province"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.province"
                                    required
                                    autofocus
                                    autocomplete="province"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.province"
                                />
                            </div>
                            <div>
                                <InputLabel for="latitude" value="Latitude" />
                                <TextInput
                                    id="latitude"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.latitude"
                                    autofocus
                                    autocomplete="latitude"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.latitude"
                                />
                            </div>
                            <div>
                                <InputLabel for="longitude" value="Longitude" />
                                <TextInput
                                    id="longitude"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.longitude"
                                    autofocus
                                    autocomplete="longitude"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.longitude"
                                />
                            </div>
                            <div>
                                <InputLabel
                                    for="gmaps_point"
                                    value="Titik Gmaps"
                                />
                                <TextInput
                                    id="gmaps_point"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.gmaps_point"
                                    autofocus
                                    autocomplete="gmaps_point"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.gmaps_point"
                                />
                            </div>
                            <div class="mt-4">
                                <InputLabel
                                    for="phone"
                                    value="Phone"
                                    required
                                />

                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.phone"
                                    required
                                    autocomplete="phone"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.phone"
                                />
                            </div>
                            <div>
                                <InputLabel for="notes" value="Keterangan" />
                                <TextInput
                                    id="notes"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.notes"
                                    autofocus
                                    autocomplete="notes"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.notes"
                                />
                            </div>
                            <div></div>
                            <Toggle
                                v-model:checked="form.is_active"
                                label="Jadikan sebagai alamat utama"
                            />
                            <PrimaryButton
                                class="ms-4 col-span-2 text-center justify-center flex"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Simpan Alamat
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex items-center space-x-5">
                        <v-icon
                            icon="mdi-map-marker-outline"
                            class="cursor-pointer"
                        ></v-icon>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Esse explicabo qui architecto debitis ratione
                            enim soluta obcaecati nisi laudantium neque. Esse,
                            minus voluptatem? Laudantium aut asperiores
                            consequuntur eligendi, rerum aliquid.
                        </p>
                        <v-icon
                            icon="mdi-pencil"
                            class="cursor-pointer text-orange-500"
                        ></v-icon>
                    </div>
                </div>

                <div class="p-4 sm:p-8 sm:rounded-lg">
                    <div class="flex items-center space-x-8">
                        <a
                            v-for="cat in categories"
                            class="rounded-full mx-auto w-44 h-44 cursor-pointer text-center"
                        >
                            <img
                                class="w-44 h-44 object-cover rounded-full mb-3"
                                :src="cat.image"
                            />
                            {{ cat.label }}
                        </a>
                    </div>
                </div>
                <div class="p-4 sm:p-8 sm:rounded-lg grid grid-cols-4 gap-6">
                    <v-card v-for="i in 6" class="mx-auto" max-width="400">
                        <v-img
                            class="align-end text-white"
                            height="200"
                            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
                            cover
                        >
                            <!-- <v-card-title
                                >Top 10 Australian beaches</v-card-title
                            > -->
                        </v-img>

                        <v-card-subtitle class="pt-4">
                            Nama Produk
                        </v-card-subtitle>

                        <v-card-text>
                            <div>Deskripsi Produk</div>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn
                                prepend-icon="mdi-cart-plus"
                                color="black"
                                text="Masukkan keranjang"
                                class="w-full px-5"
                                variant="flat"
                            >
                                <template v-slot:prepend>
                                    <v-icon color="white"></v-icon> </template
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </div>
            </div>
        </div>
    </BasicLayout>
</template>
