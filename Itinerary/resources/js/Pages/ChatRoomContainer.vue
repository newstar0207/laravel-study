<template>
    <container-layout>
        <chat-user :room="room" :roomUsers="roomUsers"></chat-user>

        <div class="flex flex-col w-full bg-blue-50 rounded-lg drop-shadow-lg m-8">
            <chat-room-update :room='room'></chat-room-update>
            <chat-room-cost :room='room'></chat-room-cost>
            <chat-room-plan :room='room'></chat-room-plan>
        </div>

        <chat-room class="fixed" :room="room"></chat-room>

    </container-layout>
</template>
<script>
import { ref } from '@vue/reactivity'
import ChatRoom from './ChatRoom.vue'
import { onBeforeUnmount } from '@vue/runtime-core'
import { notify } from "notiwind"
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import ChatUser from './ChatUser.vue'
import ChatRoomUpdate from './ChatRoomUpdate.vue'
import ChatRoomPlan from './ChatRoomPlan.vue'
import ChatRoomCost from './ChatRoomCost.vue'


export default {
    props : [
        'room',
    ],
    components : {
        ChatRoom,
        ContainerLayout,
        ChatUser,
        ChatRoomUpdate,
        ChatRoomPlan,
        ChatRoomCost,

    },
    setup(props) {

        const roomUsers = ref([])

        const broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .here((user) => {
                console.log(user, 'roomBroadcasting...');
                roomUsers.value = user
            })
            .joining((user) => {
                console.log(user, 'joining!!!');
                notify({
                    group: "joinUser",
                    title: user.name,
                }, 2000) // 2s
                roomUsers.value.push(user)
            })
            .leaving((user) => {
                console.log(user.name, 'leaving!!!');
                notify({
                    group: "leavingUser",
                    title: user.name,
                }, 2000) // 2s
                checkUser(user.id)
            })

        function checkUser(userId) {
            for(let i =0; i < roomUsers.value.length; i++) {
                if (roomUsers.value[i].id == userId) {
                    roomUsers.value.splice(i,1)
                    break
                }
            }
        }

        // destroy
        onBeforeUnmount(() => {
            Echo.leave(`chat-room.${props.room.id}`);
        })


        return {
            broadcastingRoom,
            roomUsers,
            checkUser,
        }
    }
}
</script>
<style>

</style>
