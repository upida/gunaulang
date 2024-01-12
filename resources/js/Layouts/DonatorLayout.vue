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
});

console.log(route().current());
</script>

<template>

    <!-- Page Heading -->
    <header
        class="bg-white shadow"
        style="position: sticky; top: 0; z-index: 40"
    >
        <div class="max-w-7xl mx-auto">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Donator</h2>
                            </div>
                        </div>

                        <div class="hidden sm:flex">
                            <!-- Settings Dropdown -->
                            <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('donator.page')"
                                    :active="route().current('donator.page')"
                                >
                                    Donation
                                </NavLink>
                                <NavLink
                                    :href="route('donator.store.page')"
                                    :active="route().current('donator.store.page')"
                                >
                                    Store
                                </NavLink>
                                <NavLink
                                    :href="route('donator.order.page')"
                                    :active="route().current('donator.order.page')"
                                >
                                    <v-tooltip location="bottom" text="Order">
                                        <template v-slot:activator="{ props }">
                                            <v-icon
                                                v-bind="props"
                                                icon="mdi-bell"
                                            ></v-icon>
                                        </template>
                                    </v-tooltip>
                                </NavLink>
                                <NavLink
                                    :href="route('donator.donate.page')"
                                    :active="route().current('donator.donate.page')"
                                >
                                    <v-tooltip location="bottom" text="Add new donation">
                                        <template v-slot:activator="{ props }">
                                            <v-icon
                                                v-bind="props"
                                                icon="mdi-plus"
                                            ></v-icon>
                                        </template>
                                    </v-tooltip>
                                </NavLink>
                            </div>
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
                    <!-- Responsive Settings Options -->
                    <div
                        class="pt-4 pb-1 border-t border-gray-200"
                    >
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('donator.page')"
                                :active="route().current('donator.page')"
                            >
                                <v-icon icon="mdi-charity"></v-icon> Donation
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('donator.store.page')"
                                :active="route().current('donator.store.page')"
                            >
                                <v-icon icon="mdi-store"></v-icon> Store
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('donator.order.page')"
                                :active="route().current('donator.order.page')"
                            >
                                <v-icon icon="mdi-bell"></v-icon> Order
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('donator.donate.page')"
                                :active="route().current('donator.donate.page')"
                            >
                                <v-icon icon="mdi-plus"></v-icon> Add Donation
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <slot />
</template>
