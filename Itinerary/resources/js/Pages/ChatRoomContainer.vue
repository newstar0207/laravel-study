<template>
    <container-layout>
        <chat-user :room="room[0]" :roomUsers="roomUsers"></chat-user>

        <div class="flex flex-col w-full bg-blue-50 rounded-lg drop-shadow-lg m-8">
            <chat-room-update  :room='room[0]'></chat-room-update>
            <chat-room-cost :room='room[0]' :userLength='userLength'></chat-room-cost>
            <chat-room-plan :room='room[0]'></chat-room-plan>
        </div>

        <chat-room class="fixed" :room="room[0]" ></chat-room>

    </container-layout>
</template>
<script>
import { computed, ref } from '@vue/reactivity'
import ChatRoom from './ChatRoom.vue'
import { onBeforeUnmount } from '@vue/runtime-core'
import { notify } from "notiwind"
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import ChatUser from './ChatUser.vue'
import ChatRoomUpdate from './ChatRoomUpdate.vue'
import ChatRoomPlan from './ChatRoomPlan.vue'
import ChatRoomCost from './ChatRoomCost.vue'
import { Inertia } from '@inertiajs/inertia'


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
        const userLength = computed(() => roomUsers.value.length)

        const broadcastingRoom = Echo.join(`chat-room.${props.room[0].id}`)
            .here((user) => {
                console.log(user, 'roomBroadcasting...');
                roomUsers.value = user
            })
            .joining((user) => {
                console.log(user, 'joining!!!');
                setTimeout(() => {
                    notify({
                        group: "joinUser",
                        title: user.name,
                    }, 2000) // 2s
                }, 500);
                roomUsers.value.push(user)
            })
            .leaving((user) => {
                console.log(user.name, 'leaving!!!');
                setTimeout(() => {
                    notify({
                        group: "leavingUser",
                        title: user.name,
                    }, 2000) // 2s
                }, 500);
                checkUser(user.id)
            })
            .listen('CheckUser', (e) => {
                // console.log('checkUser...')
                // axios.get('/room/' + e.userId + '/check')
                // .then((response) => {
                //     console.log(response.data)
                // })
                // .catch(error => {
                //     console.log(error)
                // })
                // console.log('listen checkUser...')
                Inertia.visit('/room/' + e.roomId + '/check/' + e.userId, {
                    method: 'get',
                })

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
            Echo.leave(`chat-room.${props.room[0].id}`);
        })


        return {
            broadcastingRoom,
            roomUsers,
            checkUser,
            userLength,


        }
    }
}
</script>
<style>

</style>
