<template>
    <div>
        <div v-if="roomList[0]">
            <div v-for="room in roomList" :key="room.id">
                <div @click="openChatRoom(room)"></div>
            </div>
        </div>


        <!-- 방 만들기 -->
        <!-- <form @submit.prevent='createNewRoom()' @keyup.enter="createNewRoom()">
            <input type="text" v-model="title">
            <input type="password" v-model='password'>
            <button>save</button>
        </form> -->

        <!-- <form onsubmit="event.preventDefault()" @keyup.enter="createNewRoom()">
            <input type="text" v-model="title">
            <input type="password" v-model='password'>
            <button @click="createNewRoom()">save</button>
        </form> -->

        <!-- <div v-if="currentRoo">
            <chat-room v-bind:currentRoom = 'currentRoom' v-bind:user = 'user'></chat-room>
        </div> -->

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
            currentRoom : this.$store.state.currentRoom,
        }
    },
    created() {
        // this.user = this.user;
        console.log(this.user);
        axios.get('/chatroom')
            .then(response => {
                this.roomList = response.data
                console.log(response.data, 'roomList ...')
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
        openChatRoom(room){
            // this.currentRoom = room;
            this.$store.commit('openChatRoom', room)
        },
    },

}
</script>
<style>
    #test {
        border: 1px solid red;
    }
</style>
