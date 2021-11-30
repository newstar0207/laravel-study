<template>
    <!-- show room -->
    <container-layout>
        <div class="flex flex-row grid grid-cols-20 min-h-[calc(100vh-72px)]">

            <!-- 리스트 -->
            <chat-room-list :room='room'></chat-room-list>



            <!-- 메시지 -->
            <div class="flex-1 justify-between flex flex-col col-span-10 rounded p-2 mt-2 mr-4">
                <div class="flex justify-between py-1 border-b-2 border-gray-200">
                    <div class="flex items-center space-x-4">
                        <div class="flex flex-col leading-tight">
                            <div class="text-xl mt-1 flex items-center">
                            <span class="text-gray-700 mr-3">{{ room.title }}</span>

                            </div>
                            <span class="text-lg text-gray-600">{{ room.password }}</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                    </div>
                </div>

                <!-- 메시지 리스트 -->
                <div class="flex flex-col flex-grow space-y-4 p-3 overflow-y-scroll h-96" id="messageBody" >
                    <intersect v-if="callInter" @enter='inters(true)' @leave='inters(false)'>
                        <div class="">.</div>
                    </intersect>
                    <div v-for="chat in chats" :key="chat.id">
                        <!-- 내가 쓴 -->
                        <div class="flex items-end justify-end" v-if="$page.props.user.id == chat.user_id" >
                            <svg @click="openModal(chat.id)" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-red-300	"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                    {{chat.chat}}
                                    <img v-if="chat.image" :src="chat.image" alt="" width="200" height="200">
                                </div>
                            </div>
                            <img :src='$page.props.user.profile_photo_url' :alt="$page.props.user.name" class="w-6 h-6 rounded-full order-1">
                        </div>

                        <!-- 남이 쓴 -->
                        <div class="flex items-end" v-else>
                            <svg @click="openModal(chat.id)"  xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-red-300"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                <div class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-blue-200 text-gray-600">
                                    {{chat.chat}}
                                    <img v-if="chat.image" :src="chat.image" alt="" width="200" height="200">
                                </div>
                            </div>
                            <img :src='chat.user.profile_photo_url' :alt="chat.id" class="w-6 h-6 rounded-full order-1">
                        </div>
                    </div>
                </div>

                <!-- 모달 -->
                <jet-confirmation-modal :show="actionModal" @close="actionModal = false" >
                    <template #title>
                        <div>
                            <h1 class="text-center text-2xl text-red-500">Delete</h1>
                        </div>
                    </template>
                    <template #footer>
                        <div class="flex flex">
                            <button class="mt-12 w-1/2 text-center bg-blue-300 py-2 mx-3 rounded-lg" @click="deleteChat()">delete</button>
                            <button class="mt-12 w-1/2 text-center bg-blue-300 py-2 mx-3 rounded-lg" @click="this.actionModal = false">cancel</button>
                        </div>
                    </template>
                </jet-confirmation-modal>


                <!-- 메시지 입력 -->
                <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0 flex-none">
                    <div class="relative flex">
                        <div class="px-2 mb-2 flex items-end inset-y-0 bottom-0 w-full">

                            <input type="file" ref="inputFile" style='display : none' @input="form.image = $event.target.files[0]"/>
                            <button @click=$refs.inputFile.click() class="outline-none focus:outline-none">
                                <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                            <input placeholder="message..." v-model="form.chat" class="py-1 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700" type="text" name="message" required/>


                            <button @click="submit" class="outline-none focus:outline-none" >
                                <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </container-layout>
</template>
<script>
import { reactive, ref  } from '@vue/reactivity'
import UpdateChatRoom from './UpdateChatRoom.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import JetConfirmationModal from '../Jetstream/ConfirmationModal.vue'
import ChatRoomList from './ChatRoomList.vue'
import { notify } from "notiwind"
import Intersect from 'vue-intersect'


export default {
    props : [
        'room',

    ],
    components : {
        UpdateChatRoom,
        ContainerLayout,
        JetConfirmationModal,
        ChatRoomList,
        Intersect,

    },
    setup(props){
        const form = reactive({
            chat: null,
            image: null,
        })
        const chats = ref([])
        const actionModal = ref(false)
        const deleteChatId = ref(null)
        const roomUsers = ref([])
        const callInter = ref(true)


        function openModal(id){
            deleteChatId.value = id
            actionModal.value = true
        }


        // infinite scroll
        let skip = 0
        function inters(enter) {
            setTimeout(() => { //Throttling
                if(enter) {
                    console.log(skip, 'skip...')
                    axios.get(`/${props.room.id}/chat/${skip}`)
                    .then(response => {
                        if (response.data.message){
                            console.log(response.data.message, 'message...');
                            callInter.value = false
                            return
                        }else {

                            var messageBody = document.querySelector('#messageBody');
                            let preventScroll = messageBody.scrollHeight

                            console.log(response.data)
                            const json = response.data
                            for(let i = 0; i < json.length; i++) {
                                console.log(json[i])
                                chats.value.unshift(json[i])
                            }

                            setTimeout(() => {
                                messageBody.scrollTo({ top : messageBody.scrollHeight - preventScroll})
                            }, 0);
                        }
                    }).catch(error => {
                        console.error(error)
                    })
                    skip += 13;
                    if (skip == 13 ) {
                        setTimeout(() => {
                            scrollBottom()
                        }, 500);
                    }

                } else {
                    console.log('leaved...')
                }
            }, 500);
        }

        function submit() {
            const formData = new FormData()
            if (form.image != null) {
                console.log(form.image)
                formData.append('image',form.image)
            }
            formData.append('chat', form.chat)
            axios.post(`/room/${props.room.id}/chat`, formData,{
                headers: { 'Content-Type': 'multipart/form-data' }
            }).then((response) => {
                form.chat = ''
                form.image = null
            }).catch((error) => {
                console.error(error);
            })
        }

        function scrollBottom() {
            setTimeout(() => {
                var messageBody = document.querySelector('#messageBody');
                messageBody.scrollTop = messageBody.scrollHeight;
            }, 0);
        }

        const deleteChatInchats = (chatId) => {
            for(let i = 0 ;i < chats.value.length ; i++){
                if (chats.value[i].id == chatId) {
                    if (i > -1) chats.value.splice(i, 1)
                    break
                }
            }
            actionModal.value = false
        }



        // 해당 댓글 찾아서 삭제시키기
        const deleteChat = () => {
            const id = parseInt(deleteChatId.value)
            axios.delete(`/chat/${id}`, {
            }).then((response) => {
                console.log(response)
                deleteChatInchats(id)
            }).catch((error) => {
                console.error(error)
            })
        }



        var broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .here((user) => {
                console.log(user, 'here!!!');
                roomUsers.value = user
            })
            .joining((user) => {
                console.log(user, 'joining!!!');
                notify({
                    group: "joinUser",
                    title: user.name,
                }, 2000) // 2s
                roomUsers.value.push(...user)
            })
            .leaving((user) => {
                console.log(user.name, 'leaving!!!');
                notify({
                    group: "leavingUser",
                    title: user.name,
                }, 2000) // 2s
                checkUser(user.id)
            })
            .listen('NewChat', (e) => {
                chats.value.push(e.chat)
                form.chat = ''
                scrollBottom()
            })
            .listen('DeleteChat', (e) => {
                deleteChatInchats(e.chat.id);
            });

        function clickChat(id){
            console.log(id)
            actionModal.value = true
        }

        function checkUser(userId) {
            for(let i =0; i < roomUsers.value.length; i++) {
                if (roomUsers.value[i].id == userId) {
                    roomUsers.value.splice(i,1)
                    break
                }
            }
        }

        return {
            submit,
            form,
            deleteChat,
            broadcastingRoom,
            chats,
            deleteChatInchats,
            clickChat,
            actionModal,
            openModal,
            roomUsers,
            scrollBottom,
            inters,
            callInter,
            checkUser,

        }
    }

}
</script>
<style>
    #messageBody::-webkit-scrollbar {
        display: none;
    }
</style>
