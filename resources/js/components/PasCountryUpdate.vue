<template>

    <div class="bg-gray-100 py-1 px-2 flex justify-between content-center">
        <div><span class="fi" :class="'fi-'+iso2.toLowerCase()"></span> <span class="text-sm">{{ name }}</span></div>
        <div class="flex items-center justify-items-end">

            <!-- Loading -->
            <template v-if=loading>
                <i class="fa-solid fa-sync fa-spin"></i>
            </template>

            <!-- Update -->
            <template v-else-if=downloaded>
                <span v-if=updated class="italic text-xs pr-2">
                    {{ Locale.getLabel('offline.settings.protected_areas.last_update') }}: {{ updated }}
                </span>
                <button class="btn-nav gray small whitespace-nowrap" @click="update(iso3)">
                    <span class="fas fa-fw fa-rotate"></span>
                    {{ Locale.getLabel('offline.settings.protected_areas.update') }}
                </button>
                <span class="fas fa-fw fa-check-circle text-green-600 pl-2"></span>
            </template>

            <!-- Download -->
            <template v-else>
                <button class="btn-nav gray small whitespace-nowrap" @click="download(iso3)">
                    <span class="fas fa-fw fa-down-long"></span>
                    {{ Locale.getLabel('offline.settings.protected_areas.download') }}
                </button>
                <span class="fas fa-fw fa-xmark-circle text-red-600 pl-2"></span>
            </template>

        </div>
    </div>

</template>

<script setup>

import { ref } from 'vue';

const Locale = window.ModularForms.Helpers.Locale;

const props = defineProps({
    iso2: String,
    iso3: String,
    name: String,
    downloaded: Boolean,
    updated: String,
});

const loading = ref(false);

function update(iso3) {
    console.log('update', iso3);
    loading.value = true;
}

function download(iso3) {
    console.log('download', iso3);
    loading.value = true;
}


</script>
