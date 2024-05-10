<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import BasicLayout from "@/Layouts/BasicLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Toggle from "@/Components/Toggle.vue";
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
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="grid grid-cols-2 gap-6"
                        >
                            <div class="w-full">
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
                            <div class="">
                                <InputLabel for="address" value="Alamat" />
                                <TextInput
                                    id="address"
                                    type="text"
                                    class="mt-1 w-full"
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
                            <div class="">
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
                                class="col-span-2"
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
            </div>
        </div>
    </BasicLayout>
</template>
