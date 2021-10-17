<template>
    <div>
        h2h2
        <div v-if="roomList[0]">
            <div v-for="room in roomList" :key="room.id">
                <div @click="openChatRoom(room, user)"> {{ room.title }}</div>
            </div>
        </div>

        <form onsubmit="event.preventDefault()" @keyup.enter="createNewRoom()">
            <input type="text" v-model="title">
            <input type="password" v-model='password'>
            <button @click="createNewRoom()">save</button>
        </form>

        <div v-if="click">
            <chat-room v-bind:chatInfo = chatInfo v-bind:user = user></chat-room>
        </div>

    </div>
</template>

<script>
import ChatRoom from './ChatRoom.vue';
export default {
    components: {
        ChatRoom
    },
    props: [
        'user',
    ],
    data() {
        return{
            roomList : [],
            title : '',
            password: '',
            click : false,
            chatInfo : {},
        }
    },
    created() {
        // this.user = this.user;
        console.log(this.user);
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
                password : this.password,
                }).then(response => {
                    console.log('ok')
                })
                .catch(error => {
                    console.error(error)
                })
        },
        openChatRoom(room, user){
            this.chatInfo = room;
            this.click = true;

        }
    }
}
</script>
<style>

</style>
