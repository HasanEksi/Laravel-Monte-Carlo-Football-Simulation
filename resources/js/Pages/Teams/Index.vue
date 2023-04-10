<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TeamModal from '@/Pages/Teams/TeamModal.vue';
import FixtureButton from '@/Components/FixtureButton.vue';
import swal from "sweetalert2";


defineProps({
    teams: {
        type: Object,
    },
});

const deleteTeam = (id) => {
    swal.fire({
        title: 'Are you sure?',
        text: 'This will delete the team from the system. Fixtures will also be regenerate.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete team!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(route('teams.destroy', id)).then((response) => {

                location.reload();

            }).catch((error) => {
                console.log(error);
            });
        }
    });
};

</script>

<template>

    <AuthenticatedLayout>
        <section
            class="pt-24 md:mt-0 md:h-screen flex flex-col justify-center text-center md:text-left md:flex-row md:justify-between md:items-center lg:px-48 md:px-12 px-4 bg-secondary">
            <div class="md:flex-1 md:mr-10">
                <h1 class="font-pt-serif text-5xl font-bold mb-7">

                    <span class="bg-underline bg-left-bottom bg-no-repeat pb-2 bg-100%">Teams</span>
                </h1>
                <p class="font-pt-serif font-normal mb-7">
                    View a list of all the teams in the system. You can also create new teams and generate fixtures.
                </p>

                <div class="flex gap-2">

                    <button data-modal-target="team-modal" data-modal-toggle="team-modal"
                            class="flex gap-1 items-center justify-center bg-black h-14 py-3 px-4 rounded-full border-2 border-black border-solid text-white mr-2 mb-2 hover:scale-105 transition duration-300 ease-in-out"
                            type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6"/>
                        </svg>
                        Create New Team
                    </button>

                    <FixtureButton/>

                    <TeamModal/>
                </div>
            </div>
            <div class="flex justify-around md:block mt-8 md:mt-0 md:flex-1">
                <div class="relative">
                    <img src="/icons/highlight-top.svg" alt="" class="absolute -top-16 -left-10">
                </div>

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-96 md:w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xl font-bold text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-center" colspan="3">
                                Teams
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="team in teams"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="group text-center px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                <div class=" flex justify-center ">
                                    {{ team.name }}
                                    <div class="absolute right-4 hidden group-hover:flex gap-2">

                                        <!--                                        <button>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                                         stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                                                                                    </svg>

                                                                                </button>-->

                                        <button
                                            @click="deleteTeam(team.id)">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
