<template>

    <div>
    <div class="flex flex-row items-center">
        <div class="flex flex-row items-center">
        <div class="text-xl font-semibold">Messages</div>
        <div class="flex items-center justify-center ml-2 text-xs h-5 w-5 text-white bg-red-500 rounded-full font-medium">5</div>
        </div>
        <div class="ml-auto">
        <button class="flex items-center justify-center h-7 w-7 bg-gray-200 text-gray-500 rounded-full">
            <svg class="w-4 h-4 stroke-current"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
        </div>
    </div>


    <div class="mt-5">
        <ul class="flex flex-row items-center justify-between">
        <li>
            <a href="#"
                class="flex items-center pb-3 text-xs font-semibold relative text-indigo-800">
            <span>All Conversations</span>
            <span class="absolute left-0 bottom-0 h-1 w-6 bg-indigo-800 rounded-full"></span>
            </a>
        </li>
        </ul>
    </div>


    <div class="mt-5">
        <div class="text-xs text-gray-400 font-semibold uppercase">Team</div>
    </div>

    <!-- for 문 필요 -->
    <div v-if="roomList != null">
        <div v-for="room in roomList" :key="room.id">
            <room-item :room= 'room' :user = 'user' @click="openChatRoom(room)"/>
        </div>
    </div>

    <!-- <form @submit.prevent='createNewRoom()' @keyup.enter="createNewRoom()">
        <input type="text" v-model="title">
        <input type="password" v-model='password'>
        <button>save</button>
    </form> -->

<!-- 클릭시 모달 띄우기 -->


    <div class="absolute bottom-0 left-90 mr-2">
        <button class="flex items-center justify-center shadow-sm h-10 w-10 bg-red-500 text-white rounded-full" @click="createNewRoom()">
            <!-- svg =>  Scalable Vector Graphics의 약자로 벡터 기반 그래픽을 XML 형식으로 정의하는 것을 의미 -->
            <svg class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <!--  <path /> 태그는 일러스트레이터처럼 패스(선과 면)을 이용한 태그입니다. -->
            <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </button>
        </div>
    </div>

</template>
<script>
import RoomItem from './RoomItem.vue'
export default {
    components : {
        RoomItem,
    },
    props: [
        'user',
    ],
    data() {
        return{
            roomList : [],
            title : '',
            password: '',
            // currentRoom : {},
        }
    },
    beforeCreate() {
        // this.user = this.user;
        console.log(this.user);
        axios.get('/chatroom')
            .then(response => {
                this.$store.commit('setRoomList', response.data)
                this.roomList = this.$store.getters.getRoomList;
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
            console.log('clicked ...')
            // this.currentRoom = room;
            this.$store.commit('openChatRoom', room);
            // this.currentRoom = this.$store.getters.getCurrentRoom;
        },
    },

}
</script>
<style>

</style>
