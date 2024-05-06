<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('home')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <!-- <NavLink
                                    :href="route('home')"
                                    :active="route().current('home')"
                                >
                                    Home
                                </NavLink>
                                <NavLink
                                    :href="route('category')"
                                    :active="route().current('category')"
                                >
                                    Category
                                </NavLink>
                                <NavLink
                                    :href="route('search')"
                                    :active="route().current('search')"
                                >
                                    <v-tooltip location="bottom" text="Search">
                                        <template v-slot:activator="{ props }">
                                            <v-icon
                                                v-bind="props"
                                                icon="mdi-magnify"
                                            ></v-icon>
                                        </template>
                                    </v-tooltip>
                                </NavLink> -->
                            </div>
                        </div>

                        <div class="hidden sm:flex">
                            <!-- Settings Dropdown -->
                            <div
                                v-if="canLogin && $page.props.auth.user"
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <!-- <NavLink
                                    :href="route('cart')"
                                    :active="route().current('cart')"
                                >
                                    <v-tooltip location="bottom" text="Cart">
                                        <template v-slot:activator="{ props }">
                                            <v-icon
                                                v-bind="props"
                                                icon="mdi-cart"
                                            ></v-icon>
                                        </template>
                                    </v-tooltip>
                                </NavLink>
                                <NavLink
                                    :href="route('donator.page')"
                                    :active="[
                                        'donator.page',
                                        'donator.store.page',
                                        'donator.donate.page',
                                        'donator.order.page',
                                    ].includes(route().current())"
                                >
                                    Your Donation
                                </NavLink> -->
                                <Dropdown width="48" class="sm:self-center">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <!-- <DropdownLink :href="route('order.list.page')">
                                            History Order
                                        </DropdownLink> -->
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>

                            <template v-else>
                                <Link
                                    :href="route('login')"
                                    class="font-semibold text-gray-600 hover:text-gray-900 self-center focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >Log in</Link
                                >

                                <Link
                                    v-if="canRegister"
                                    :href="route('register')"
                                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 self-center focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                    >Register</Link
                                >
                            </template>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <!-- <ResponsiveNavLink
                            :href="route('home')"
                            :active="route().current('home')"
                        >
                            <v-icon icon="mdi-home"></v-icon> Home
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('category')"
                            :active="route().current('category')"
                        >
                            <v-icon
                                icon="mdi-format-list-bulleted-type"
                            ></v-icon>
                            Category
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('search')"
                            :active="route().current('search')"
                        >
                            <v-icon icon="mdi-magnify"></v-icon> Search
                        </ResponsiveNavLink> -->
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        v-if="canLogin && $page.props.auth.user"
                        class="pt-4 pb-1 border-t border-gray-200"
                    >
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <!-- <ResponsiveNavLink
                                :href="route('cart')"
                                :active="route().current('cart')"
                            >
                                <v-icon icon="mdi-cart"></v-icon> Cart
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('order.list.page')"
                                :active="route().current('order.list.page')"
                            >
                                <v-icon icon="mdi-history"></v-icon> History
                                Order
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('donator.page')"
                                :active="[
                                    'donator.page',
                                    'donator.store.page',
                                    'donator.donate.page',
                                    'donator.order.page',
                                ].includes(route().current())"
                            >
                                <v-icon icon="mdi-charity"></v-icon> Your Donation
                            </ResponsiveNavLink> -->
                            <ResponsiveNavLink
                                :href="route('profile.edit')"
                                :active="route().current('profile.edit')"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                    <div v-else class="pt-4 pb-1 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('login')">
                                Log in
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                v-if="canRegister"
                                :href="route('register')"
                            >
                                Register
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
                style="position: sticky; top: 0; z-index: 40"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>

            <footer
                v-if="$slots.footer"
                class="bg-white"
            >
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                </div>
            </footer>
        </div>
    </div>
</template>
