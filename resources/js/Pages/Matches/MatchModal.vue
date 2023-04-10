<script setup>
import {useForm} from '@inertiajs/vue3';
import axios from "axios";

const form = useForm({
    homeScore: '',
    awayScore: '',
});

const submit = () => {
    axios.post('/teams', form)
        .then((response) => {

            if (response.data.status === 'success') {
                form.reset();
                window.location.href = '/matches';
            }

        })
        .catch((error) => {
                console.log(error);
            }
        );
};

</script>

<template>
    <div id="match-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="match-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">
                        Edit Match
                    </h3>
                    <form class="space-y-6" @submit.prevent="submit">

                        <div>
                            <label for="homeScore"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Home Team Score
                            </label>
                            <input type="number" name="homeScore" id="homeScore"
                                   min="1" max="100"
                                   v-model="form.homeScore"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: 1-100" required>
                        </div>

                        <div>
                            <label for="awayScore"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Away Team Score
                            </label>
                            <input type="number" name="awayScore" id="awayScore"
                                   min="1" max="100"
                                   v-model="form.awayScore"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: 1-100" required>
                        </div>


                        <button type="submit"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                class="w-full text-white bg-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:scale-105 transition duration-300 ease-in-out">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
