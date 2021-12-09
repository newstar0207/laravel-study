<template>
    <!-- show room -->
    <div class="flex-1 flex">
        <div class="p-6 w-auto flex flex-1 justify-center">
        <!-- <div class="flex flex-row grid grid-cols-20 mx-28 bg-white flex-1 rounded-lg filter drop-shadow-2xl"> -->
            <!-- 리스트 -->
            <!-- <chat-room-list :room='room' :roomUsers="roomUsers" class="drop-shadow-2xl mx-28 w-auto"></chat-room-list> -->
            <!-- </div> -->
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


        <!-- chatting -->
        <div v-show="openChat == true" class="fixed bottom-0 right-0 flex flex-col items-end ml-6 w-full">
            <div class="mr-5 flex flex-col mb-5 drop-shadow-3xl sm:w-1/2 md:w-1/3 lg:w-1/4 rounded-xl overflow-hidden">

            <!-- admin profile -->
            <div class="flex justify-between items-center text-black p-2 bg-white border-gray-200 border-b-2 shadow-lg mr-5 w-full">

                <div class="flex py-1">
                    <div class="flex items-end">
                        <div class="text-xl font-medium mt-1 pl-4">
                            <span class="text-black">{{ room.title }}</span>
                        </div>
                        <span class="ml-2 text-gray-500">{{ room.password }}</span>
                    </div>
                </div>

                <!-- 취소버튼 -->
                <div v-if="openChat" @click="closeChatting" class="close-chat text-blue-500 mb-1 w-10 flex justify-center items-center px-2 py-1 rounded self-end cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

            </div>


            <div class="flex flex-col bg-white px-2 chat-services expand overflow-auto">

                <div class="flex flex-col flex-grow space-y-4 p-3 overflow-y-scroll h-96" id="messageBody">
                <intersect v-if="callInter" @enter='inters(true)' @leave='inters(false)' @destroyed='destroyInter' @change='changeInter'>
                    <div  class="text-black text-center text-gray-300 target">more..</div>
                </intersect>
                <div v-for="chat in chats" :key="chat.id">
                    <!-- 내가 쓴 -->
                    <div class="flex items-end justify-end" v-if="$page.props.user.id == chat.user_id" >
                        <svg @click="openModal(chat.id)" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-red-300	"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                            <div class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                <div v-if="chat.chat != 'null'">
                                    {{chat.chat}}
                                </div>
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
                                <div v-if="chat.chat != 'null'">
                                    {{chat.chat}}
                                </div>
                                <img v-if="chat.image" :src="chat.image" alt="" width="200" height="200">
                            </div>
                        </div>
                        <img :src='chat.user.profile_photo_url' :alt="chat.user.name" class="w-6 h-6 rounded-full order-1">
                    </div>
                </div>
                </div>
            </div>

            <!-- send message -->
            <div class="relative bg-white">
                <div class="border-t-2 border-gray-200 px-4 pt-2 mb-2 sm:mb-0">

                    <div class="px-2 mb-2 flex w-full items-center">
                        <input type="file" ref="inputFile" hidden @input="form.image = $event.target.files[0]"/>
                        <button @click=$refs.inputFile.click() class="outline-none focus:outline-none">
                            <svg class="text-gray-400 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </button>
                        <form @submit.prevent="submit" class="flex w-full">
                            <input placeholder="message..." v-model="form.chat" class="py-1 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700" type="text" name="message"/>
                            <button type="submit" class="outline-none focus:outline-none" >
                                <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            </div>
        </div>

        <!-- 작아졌을때 버튼 -->
        <div v-if="!openChat" @click="openChatting" class="fixed bottom-0 right-0 mx-10 mb-6 mt-4 text-blue-500 hover:text-blue-600 flex justify-center items-center cursor-pointe">
            <svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-chat-text-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/>
            </svg>
        </div>


    </div>
</template>

<script>
import { reactive, ref  } from '@vue/reactivity'
import ChatRoomUpdate from './ChatRoomUpdate.vue'
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import JetConfirmationModal from '../Jetstream/ConfirmationModal.vue'
import ChatRoomList from './ChatRoomList.vue'
import Intersect from 'vue-intersect'



export default {
    props : [
        'room',
    ],

    components : {
        ChatRoomUpdate,
        ContainerLayout,
        JetConfirmationModal,
        ChatRoomList,
        Intersect,

    },
    setup(props, context){
        const form = reactive({
            chat: null,
            image: null,
        })
        const chats = ref([])
        const actionModal = ref(false)
        const deleteChatId = ref(null)
        const roomUsers = ref([])
        const callInter = ref(true)
        const openChat = ref(false)

        function destroyInter(){
            console.log('destryInter...')
        }

        function changeInter(){
            console.log('changeInter')
        }


        function openModal(id){
            deleteChatId.value = id
            actionModal.value = true
        }


        // infinite scroll
        const skip = ref(0)
        function inters(enter) {
            setTimeout(() => { //Throttling
                if(enter) {
                    console.log('enter...')
                    axios.get(`/${props.room.id}/chat/${skip.value}`)
                    .then(response => {
                        if (response.data.message){
                            callInter.value = false
                            return
                        }else {
                            var messageBody = document.querySelector('#messageBody');
                            let preventScroll = messageBody.scrollHeight
                            // console.log(response.data)
                            const json = response.data
                            for(let i = 0; i < json.length; i++) {
                                chats.value.unshift(json[i])
                            }
                            setTimeout(() => {
                                messageBody.scrollTo({ top : messageBody.scrollHeight - preventScroll})
                            }, 0);
                        }
                    }).catch(error => {
                        console.error(error)
                    })
                    skip.value += 13;
                    if (skip.value == 13 ) {
                        setTimeout(() => {
                            scrollBottom()
                        }, 500);
                    }

                } else {
                    console.log('leaved...')
                }
            }, 1000);
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



        const broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .here((user) => {
                console.log(user, 'chatBroadcasting...');
                // roomUsers.value = user
            })
            .listen('NewChat', (e) => {
                chats.value.push(e.chat)
                form.chat = ''
                console.log(e.chat, 'new chat...')
                scrollBottom()
            })
            .listen('DeleteChat', (e) => {
                deleteChatInchats(e.chat.id);
            });

        function clickChat(id){
            console.log(id)
            actionModal.value = true
        }

        function closeChatting() {
            openChat.value = false
        }

        function openChatting() {
            scrollBottom()
            openChat.value = true
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
            openChat,
            closeChatting,
            openChatting,
            skip,
            destroyInter,
            changeInter,


        }
    }

}
</script>
<style>
    #messageBody::-webkit-scrollbar {
        display: none;
    }
</style>
