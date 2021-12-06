<template>

    <div class="bg-white py-5 w-56 flex flex-col">
        <!-- <p class="px-2 py-3 font-bold">Users...</p> -->
        <div class="mt-5">
            <div class="mt-1 mr-50 rounded rounded-r-3xl pl-6 py-3 font-semibold flex">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                User List
            </div>


            <div  v-for="roomUser in roomUsers" :key="roomUser.id" class="cursor-pointer border-gray-100 rounded-t border-b p-3 ml-4 hover:bg-teal-100 flex-1">
                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 hover:border-blue-500">
                    <div class="w-6 flex flex-col items-center">
                        <div class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 w-4 h-4 rounded-full ">
                            <img class="rounded-full" :alt="roomUser.name" :src="'/storage/' + roomUser.profile_photo_path">
                        </div>
                    </div>

                    <div v-if="room.owner == roomUser.name" class="w-full items-center flex">
                        <div class="mx-2 ">{{ roomUser.name }} owner</div>
                    </div>
                    <div v-else class="w-full items-center flex">
                        <div class="mx-2 ">{{ roomUser.name }}</div>
                    </div>

                    <svg :key="rerendering"  v-if="$page.props.user.name == room.owner" @click="userBan(roomUser)"  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>
        </div>



    </div>
</template>
<script>
export default {
    props : [
        'room',
        'roomUsers'
    ],
    setup(props) {
        function userBan(user) {

        }

        return {
            userBan,
        }
    }
}
</script>
<style>

</style>
