<template>
    <div class="border-2 border-gray-500">
        roomList!!
        <div>
            <div v-for="room in roomList" :key="room.id" @click="openChatRoom(room)">
                {{  room.title }}
            </div>
        </div>
    </div>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
export default {
    props : [
        'roomList'
    ],
    setup(){
        const openChatRoom = (room) => {
            Inertia.get('/room/' + room.id)
        }

        return { openChatRoom }
    }
}
</script>
<style >

</style>
