<template>
    <div>
        h2h2
        <div v-if="roomList[0]">
            <div v-for="room in roomList" :key="room.id">
                <div @click="openChatRoom(room)"> {{ room.title }}</div>
            </div>
        </div>

        <form onsubmit="event.preventDefault()" @keyup.enter="createNewRoom()">
            <input type="text" v-model="title">
            <button @click="createNewRoom()">save</button>
        </form>

        <div v-if="click">
            <chat-room v-bind:chatInfo = chatInfo></chat-room>
        </div>

    </div>
</template>
<script>
import ChatRoom from './ChatRoom.vue';
export default {
    components: {
        ChatRoom
    },
    data() {
        return{
            roomList : [],
            title : '',
            click : false,
            chatInfo : {}
        }
    },
    created() {
        axios.get('/chatroom')
            .then(response => {
                this.roomList = response.data
                console.log(response.data)
            })
            .catch(error => {
                console.error(error)
            })
    },
    methods : {
        createNewRoom() {
            axios.post('/chatroom', {
                title : this.title,
                }).then(response => {
                    console.log('ok')
                })
                .catch(error => {
                    console.error(error)
                })
        },
        openChatRoom(room){
            this.chatInfo = room;
            this.click = true;
        }
    }
}
</script>
<style>

</style>
