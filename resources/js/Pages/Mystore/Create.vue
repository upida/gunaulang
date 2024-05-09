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
    // data: {
    //     type: Object,
    // },
});

const form = useForm({
    storename: "",
    name: "",
    description: "",
    logo: "",
    cover: "",
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
    router.post("/mystore/create", form);
    form.reset();
};
</script>

<template>
    <Head title="Setiap Bagian Berharga" />

    <BasicLayout :canLogin="canLogin" :canRegister="canRegister">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Store</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="grid grid-cols-2 gap-6"
                        >
                            <div>
                                <InputLabel for="storename" value="storename" />
                                <TextInput
                                    id="storename"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.storename"
                                    autofocus
                                    autocomplete="storename"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.storename"
                                />
                            </div>
                            
                            <div>
                                <InputLabel for="name" value="name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.name"
                                />
                            </div>

                            <div>
                                <InputLabel for="description" value="description" />
                                <TextInput
                                    id="description"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.description"
                                    autofocus
                                    autocomplete="description"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.description"
                                />
                            </div>

                            <div>
                                <InputLabel for="logo" value="logo" />
                                <TextInput
                                    id="logo"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.logo"
                                    autofocus
                                    autocomplete="logo"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.logo"
                                />
                            </div>

                            <div>
                                <InputLabel for="cover" value="cover" />
                                <TextInput
                                    id="cover"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.cover"
                                    autofocus
                                    autocomplete="cover"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.cover"
                                />
                            </div>

                            <div>
                                <InputLabel for="phone" value="phone" />
                                <TextInput
                                    id="phone"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.phone"
                                    autofocus
                                    autocomplete="phone"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.phone"
                                />
                            </div>

                            <div>
                                <InputLabel for="address" value="address" />
                                <TextInput
                                    id="address"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.address"
                                    autofocus
                                    autocomplete="address"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.address"
                                />
                            </div>

                            <div>
                                <InputLabel for="subdistrict" value="subdistrict" />
                                <TextInput
                                    id="subdistrict"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.subdistrict"
                                    autofocus
                                    autocomplete="subdistrict"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.subdistrict"
                                />
                            </div>

                            <div>
                                <InputLabel for="district" value="district" />
                                <TextInput
                                    id="district"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.district"
                                    autofocus
                                    autocomplete="district"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.district"
                                />
                            </div>

                            <div>
                                <InputLabel for="city" value="city" />
                                <TextInput
                                    id="city"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.city"
                                    autofocus
                                    autocomplete="city"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.city"
                                />
                            </div>

                            <div>
                                <InputLabel for="province" value="province" />
                                <TextInput
                                    id="province"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.province"
                                    autofocus
                                    autocomplete="province"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.province"
                                />
                            </div>

                            <div>
                                <InputLabel for="latitude" value="latitude" />
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
                                <InputLabel for="longitude" value="longitude" />
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
                                <InputLabel for="gmaps_point" value="gmaps_point" />
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

                            <div>
                                <InputLabel for="notes" value="notes" />
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
