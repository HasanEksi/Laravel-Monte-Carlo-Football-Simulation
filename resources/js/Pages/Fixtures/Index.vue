<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FixtureButton from '@/Components/FixtureButton.vue';
import SimulationButton from '@/Components/SimulationButton.vue';
import { Link } from '@inertiajs/vue3';
defineProps({
    fixtures: {
        type: Object,
    },
});
</script>

<template>

    <AuthenticatedLayout>
        <section
            class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 bg-secondary">
            <div class="md:flex-1 md:mr-10">
                <h1 class="font-pt-serif text-5xl font-bold mb-7">

                    <span class="bg-underline bg-left-bottom bg-no-repeat pb-2 bg-100%">
                        Fixtures
                    </span>
                </h1>
                <p class="font-pt-serif font-normal mb-7">
                    View a list of all the fixture in the system. You can also start a simulation.
                </p>

                <div class="flex gap-2">
                    <Link href="/league">
                        <SimulationButton/>
                    </Link>

                    <FixtureButton/>
                </div>
            </div>
            <div class="flex flex-col justify-around md:block mt-8 md:mt-0 md:flex-1">
                <div class="relative">
                    <img src="/icons/highlight-top.svg" alt="" class="absolute -top-16 -left-10">
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-6"
                     v-for="(index,key) in fixtures" :key="index.id"
                >
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center" colspan="3">
                                Week {{ index[0].week }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="fixture in index"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-[40%] group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                {{ fixture.home_team.name }}


                            </td>
                            <td class="w-[10%] text-center">-</td>
                            <td class="w-[40%] group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">

                                {{ fixture.away_team.name }}

                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="relative">
                    <img src="/icons/highlight-bottom.svg" alt="" class="absolute -bottom-10 -right-6">
                </div>
            </div>
        </section>

    </AuthenticatedLayout>

</template>

<style>

</style>
