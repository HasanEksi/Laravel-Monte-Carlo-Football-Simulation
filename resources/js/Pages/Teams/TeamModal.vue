<script setup>
import {useForm} from '@inertiajs/vue3';
import axios from "axios";

const form = useForm({
    name: '',
    powerRate: '',
    homeAdvantage: '',
    goalkeeperFactor: '',
});

const submit = () => {
    axios.post('/teams', form)
        .then((response) => {

            if (response.data.status === 'success') {
                form.reset();
                window.location.href = '/teams';
            }

        })
        .catch((error) => {
                console.log(error);
            }
        );
};

</script>

<template>
    <div id="team-modal" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="team-modal">
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
                        Create New Team
                    </h3>
                    <form class="space-y-6" @submit.prevent="submit">
                        <div>
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Team Name
                            </label>
                            <input type="text" name="name" id="name"
                                   maxlength="255"
                                   v-model="form.name"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: Team 1" required>
                        </div>

                        <div>
                            <label for="powerRate"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Team Power Rate
                            </label>
                            <input type="number" name="powerRate" id="powerRate"
                                   min="1" max="100"
                                   v-model="form.powerRate"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: 1-100" required>
                        </div>

                        <div>
                            <label for="homeAdvantage"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Home Advantage
                            </label>
                            <input type="number" name="homeAdvantage" id="homeAdvantage"
                                   min="1" max="100"
                                   v-model="form.homeAdvantage"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: 1-100" required>
                        </div>
                        <div>
                            <label for="goalkeeperFactor"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Goalkeeper Factor
                            </label>
                            <input type="number" name="goalkeeperFactor" id="goalkeeperFactor"
                                   min="1" max="100"
                                   v-model="form.goalkeeperFactor"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black focus:border-black block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="ex: 1-100" required>
                        </div>

                        <button type="submit"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                class="w-full text-white bg-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:scale-105 transition duration-300 ease-in-out">
                            Create Team
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
