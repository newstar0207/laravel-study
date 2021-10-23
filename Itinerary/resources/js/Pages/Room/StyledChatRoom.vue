<template>
    <div></div>
    <!-- <div>
        <div>
            <div class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-pink-500 text-pink-100">T</div>
                <div class="flex flex-col ml-3">
                    <div class="font-semibold text-sm">UI Art Design</div>
                    <div class="text-xs text-gray-500">Active</div>
                </div>

                <div>
                    <ul class="flex flex-row items-center space-x-2">
                        <li>
                            <a href="#"
                                class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-400 h-10 w-10 rounded-full">
                                <span>
                                <svg class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                </svg>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>



        <div class="h-full overflow-hidden py-4">
            <div class="h-full overflow-y-auto">
                <div v-if="this.chatItem">

                       <!-- 채팅있던 자리 -->
              <!--         <styled-chat></styled-chat>
                </div>
            </div>
        </div>
    </div>
    </div> -->
</template>
<script>
import StyledChat from './StyledChat.vue';
export default {
    components :{
        StyledChat,
    },
    data() {
        return {
            currentRoom : {},
            chatItem = false,
        }
    },
    created(){
        this.currentRoom = this.$store.getters.getCurrentRoom
    },
    mounted() {
        console.log(this.currentRoom)
        axios.get('/chatroom/' + this.currentRoom.id + '/chat')
            .then(response => {
                console.log(response.data.data)
                // this.chats = response.data.data
                this.$store.commit('setChat', response.data.data);
                this.chatItem = true;
            })
            .catch(error => {
                console.error(error)
            })
    }
}
</script>

