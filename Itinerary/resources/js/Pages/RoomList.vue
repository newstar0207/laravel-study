<template>
    <!-- roomList!! -->
    <div>
        <div v-for="room in roomList" :key="room.id" @click="openChatRoom(room)" class="flex cursor-pointer my-1 hover:bg-blue-100 rounded">
            <div class="ml-2 text-center py-1">
                <p class="text-xl p-0 text-blue-400">&bull;</p>
            </div>
            <div class="h-10 py-2 px-2">
                <p class="hover:text-blue-dark">{{ room.title }}</p>
            </div>
        </div>
    </div>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3'
export default {
    props : [
        'roomList',
    ],
    components : {
        Link,
    },
    setup(){
        const openChatRoom = (room) => {
            Inertia.get('/room/' + room.id + '/chat')
        }

        return { openChatRoom }
    }
}
</script>
<style >

</style>
