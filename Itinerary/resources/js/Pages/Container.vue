<template>
    <container-layout>
        <div class="flex">
            <aside-chat :roomList="roomList"></aside-chat>
            <chat-image :chatImage="chatImage"></chat-image>
        </div>
    </container-layout>
</template>
<script>
import AsideChat from './AsideChat.vue'
import ChatImage from './ChatImage.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import { onBeforeUnmount } from '@vue/runtime-core'
import { Inertia } from '@inertiajs/inertia'

export default {
    props: [
        'chatImage',
        'roomList',
    ],
    components : {
        AsideChat,
        ChatImage,
        ContainerLayout,
    },
    setup(props) {
        const broadcastingRoom = Echo.channel('room')
        .listen('ChatImageUpdate', (e) =>  {
            console.log('chatImageupdate...')
            Inertia.get(route('room.index'));
        })

        onBeforeUnmount(() => {
            console.log('public channel leave....')
            Echo.leaveChannel('room');
        })

        return {
            broadcastingRoom,
            onBeforeUnmount,
        }
    }
}
</script>
<style>

</style>
