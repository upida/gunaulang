<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const data = defineProps({
    store: {
        type: Object,
    },
});

const form = useForm({
    title: data.store?.title ?? "",
    description: data.store?.description ?? "",
    email: data.store?.email ?? "",
    phone: data.store?.phone ?? "",
    // photo: data.store?.photo ?? '',
    // cover: data.store?.cover ?? '',
    address: data.store?.address ?? "",
    active: Boolean(data.store?.active ?? true),
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{
                    data.store
                        ? `Your store information`
                        : `Let's make your store!`
                }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Kindness and sustainability with <b>Goods and Grubs</b>.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('donator.store'))"
            class="mt-6 space-y-6"
        >
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
                    class="text-green-600 mt-1 block w-full"
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
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.description"
                    required
                    autocomplete="description"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <v-text-field
                    placeholder="Email"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="email"
                    type="text"
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="phone" value="Phone" />

                <v-text-field
                    placeholder="Phone"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="phone"
                    type="text"
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <!-- <div>
                <InputLabel for="photo" value="Photo" />

                <v-file-input
                    placeholder="Photo"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.photo"
                    id="photo"
                    prepend-icon="mdi-camera"
                ></v-file-input>

                <InputError class="mt-2" :message="form.errors.photo" />
            </div> -->

            <!-- <div>
                <InputLabel for="cover" value="Cover" />

                <v-text-field
                    placeholder="Cover"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="cover"
                    type="text"
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.cover"
                    required
                    autocomplete="cover"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.cover" />
            </div> -->

            <div>
                <InputLabel for="address" value="Address" />

                <v-text-field
                    placeholder="Address"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="address"
                    type="text"
                    class="text-green-600 mt-1 block w-full"
                    v-model="form.address"
                    required
                    autocomplete="address"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.address" />
            </div>

            <div>
                <InputLabel for="status" value="Status" />

                <v-switch
                    v-model="form.active"
                    hide-details
                    inset
                    color="green-lighten-2"
                    :label="form.active ? 'Active' : 'Inactive'"
                ></v-switch>

                <InputError class="mt-2" :message="form.errors.active" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">{{
                    data.store ? `Save` : `Create`
                }}</PrimaryButton>

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
                        {{ data.store ? `Saved.` : `Created.` }}
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
