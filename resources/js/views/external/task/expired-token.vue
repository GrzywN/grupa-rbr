<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@shared/layouts/guest-layout.vue';
</script>

<template>
    <Head title="Your link expired" />

    <GuestLayout>
        <div class="flex flex-col gap-4 py-12">
            <div class="mx-auto w-full max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        Your token has expired. Please try with a new link.
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
