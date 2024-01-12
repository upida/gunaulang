<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    username: user.username,
    email: user.email,
    phone: user.phone,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Profile Information
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-6"
        >
            <div>
                <InputLabel for="Name" value="Name" />

                <v-text-field
                    placeholder="Name"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="name"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="Username" value="Username" />

                <v-text-field
                    placeholder="Username"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="username"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.username"
                    required
                    autocomplete="username"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div>
                <InputLabel for="Email" value="Email" />

                <v-text-field
                    placeholder="Email"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="email"
                    type="email"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="Phone" value="Phone" />

                <v-text-field
                    placeholder="Phone"
                    variant="outlined"
                    single-line
                    hide-details
                    density="compact"
                    id="phone"
                    type="text"
                    class="text-teal-600 mt-1 block w-full"
                    v-model="form.phone"
                    required
                    autocomplete="phone"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.phone" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

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
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
