<template>
    <container-layout>
        <div class="flex">
            <aside-chat :roomList="roomList">dsfd</aside-chat>
            <chat-image :chatImage="chatImage"></chat-image>
        </div>
    </container-layout>
</template>
<script>
import AsideChat from './AsideChat.vue'
import ChatImage from './ChatImage.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'

export default {
    props: [
        'chatImage',
        'roomList',
    ],
    components : {
        AsideChat,
        ChatImage,
        ContainerLayout,
    }
}
</script>
<style>

</style>
