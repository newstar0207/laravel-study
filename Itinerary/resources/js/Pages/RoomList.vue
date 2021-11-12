<template>
    <div class="border-2 border-gray-500">
        roomList!!
        <div>
            <div v-for="room in roomList" :key="room.id" @click="openChatRoom(room)">
                <!-- <Link :href="'/room/' + room.id + '/chat'">{{ room.title }}</Link> -->
                {{  room.title }}
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
