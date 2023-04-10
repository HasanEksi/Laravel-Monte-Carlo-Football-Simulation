<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DangerButton from "@/Components/DangerButton.vue";
import swal from "sweetalert2";


defineProps({
    leagueTable: {
        type: Array,
    },
    teams: {
        type: Object,
    },
});

const playAllMatches = () => {
    axios.post('/league')
        .then((response) => {
            // reload data

            window.location.reload();
        })
        .catch((error) => {

            console.log('ee' + error);

            swal.fire({
                title: 'Error!',
                text: error.response.data.message,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
}

const playNextMatch = () => {
    axios.post('/league?next=true')
        .then((response) => {
           window.location.reload();
        })
        .catch((error) => {
            swal.fire({
                title: 'Error!',
                text: error.response.data.message,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        });
}

const resetLeague = () => {
    swal.fire({
        title: 'Are you sure?',
        text: 'This will reset the league table',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, reset league!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(route('league.reset')).then((response) => {

                location.reload();

            }).catch((error) => {
                console.log(error);
            });
        }
    });
}

</script>

<template>

    <AuthenticatedLayout>
        <section
            class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 ">

            <div class="grid md:grid-cols-2 gap-2">
                <div class="md:flex-1 md:mr-10">
                    <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1">
                        <div class="relative">
                            <img src="/icons/highlight-top.svg" alt="" class="absolute -top-16 -left-10">
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <h5 class="text-center text-2xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                League Table</h5>
                            <table class="w-96 md:w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Team
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Points">
                                        PTS
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Played">
                                        P
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Won">
                                        W
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Drawn">
                                        D
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Lost">
                                        L
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center" title="Goal Difference">
                                        GD
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="league in leagueTable"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ league.team.name }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.points }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.played }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.won }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.drawn }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.lost }}
                                    </td>
                                    <td class="text-center bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        {{ league.goal_difference }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="relative">
                            <img src="/icons/highlight-bottom.svg" alt="" class="absolute -bottom-10 -right-6">
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row justify-around md:block mt-8 md:mt-0 md:flex-1">

                    <div class="grid md:grid-cols-2 gap-2">
                        <button @click="playAllMatches"
                              class="flex gap-1 items-center justify-center bg-black h-10 px-2 rounded-full border-2 border-black border-solid text-white mr-2 mb-2 hover:scale-105 transition duration-300 ease-in-out"
                              type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                            Play All
                        </button>

                        <button @click="playNextMatch"
                              class="flex gap-1 items-center justify-center bg-black h-10 px-2 rounded-full border-2 border-black border-solid text-white mr-2 mb-2 hover:scale-105 transition duration-300 ease-in-out"
                              type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                            Next Week
                        </button>

                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <h5 class="text-center text-2xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            Championship Predictions
                        </h5>
                        <table class="w-96 md:w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Team
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    %
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr
                                v-for="team in teams"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ team.name }}

                                </td>
                                <td class="group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                    {{ team.winning_probability }}

                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>


                    <div class="flex justify-end">
                        <DangerButton
                            @click="resetLeague"
                            class="mt-4 ">Reset League</DangerButton>

                    </div>

                </div>
            </div>

        </section>

    </AuthenticatedLayout>

</template>

<style>

</style>
