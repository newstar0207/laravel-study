<template>
    <container-layout>

        <!-- container! -->


        <aside class="bg-white py-5 w-60 h-full">

            <button @click="createNewRoomModal = true" class="flex items-center align-middle py-2 bg-white shadow-md  rounded-3xl text-gray-800 text-sm font-semibold ml-3 border border-gray-200 hover:shadow-xl transition-all w-52  focus:outline-none">
                <svg class="h-8 px-4"  viewBox="0 0 36 36"><path class="ng-tns-c17-1" d="M16 16v14h4V20z" fill="#34A853"></path><path class="ng-tns-c17-1" d="M30 16H20l-4 4h14z" fill="#4285F4"></path><path class="ng-tns-c17-1" d="M6 16v4h10l4-4z" fill="#FBBC05"></path><path class="ng-tns-c17-1" d="M20 16V6h-4v14z" fill="#EA4335"></path><path class="ng-tns-c17-1" d="M0 0h36v36H0z" fill="none"></path></svg>
                Create New Room
            </button>

            <!-- side bar menu -->

            <div class="mt-5">
                <div class="mt-1  mr-50 rounded rounded-r-3xl pl-6 py-3 font-semibold">
                    <button @click="roomListBtn ? roomListBtn = false : roomListBtn = true" class="text-gray-600  text-sm font-semibold flex items-center  focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        Room List
                    </button>
                </div>

                <div v-if="roomListBtn">
                    <room-list class="p-6" :roomList = 'roomLists'></room-list>
                </div>

                <div class="mt-1  mr-50 rounded rounded-r-3xl pl-6 py-3 font-semibold">
                    <button @click="searchRoomModal ? searchRoomModal = false : searchRoomModal = true" class="text-gray-600 text-sm font-semibold flex items-center   focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Search Room
                    </button>
                </div>

            </div>
        </aside>



        <!-- new room modal -->
        <jet-dialog-modal :show="createNewRoomModal" @close="createNewRoomModal = false" >
            <template #title>
                <h1 class="text-xl font-bold">Create New Room</h1>
            </template>
            <template #content>
                <div class="h-96 overflow-auto space-y-6 mx-8">
                    <label class="text-sm font-medium text-gray-900 block mb-2">period</label>
                    <date-picker  class="bg-gray-50" @period='periodPicker' v-model="roomCreateForm.period"></date-picker>
                    <label class="text-sm font-medium text-gray-900 block mb-2">title</label>
                    <input id="title" required  placeholder="new room title..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="roomCreateForm.title" />
                </div>
            </template>
            <template #footer>
                <div>
                    <button @click="createNewRoom()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                </div>
            </template>
        </jet-dialog-modal>



        <!-- find room modal -->
        <jet-dialog-modal :show="searchRoomModal" @close="searchRoomModal = false" >
            <template #title>
                <h1 class="text-xl font-bold">Search Room</h1>
            </template>
            <template #content>
                <div class="h-auto overflow-auto space-y-6 mx-8">
                    <label class="text-sm font-medium text-gray-900 block mb-2">password</label>
                    <input required  placeholder="room password..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="searchRoomPassword" />
                </div>
            </template>
            <template #footer>
                <div>
                    <button @click="searchRoom()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                </div>
            </template>
        </jet-dialog-modal>

    </container-layout>
</template>
<script>
import ContainerLayout from '../Layouts/ContainerLayout.vue'
import { reactive, ref } from '@vue/reactivity'
import RoomList from './RoomList.vue'
import JetDialogModal from '../Jetstream/DialogModal.vue'
import DatePicker from './DatePicker.vue'
import { notify } from "notiwind"
export default {
    components : {
        ContainerLayout,
        RoomList,
        JetDialogModal,
        DatePicker,
    },
    props : [
        'roomList',
        'exist',
        'error',
        'dateValue'
    ],
    setup(props) {

        const roomLists = ref([...props.roomList])
        const roomListBtn = ref(false)
        const createNewRoomModal = ref(false)
        const searchRoomModal = ref(false)
        const searchRoomPassword = ref('')

        const roomCreateForm = reactive({
            title: null,
            period : null,
        })

        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            roomCreateForm.period = period
        }

        const createNewRoom = () => {
            axios.post('/room', {
                title : roomCreateForm.title,
                period : roomCreateForm.period,
            }).then(response => {
                createNewRoomModal.value = false
                roomLists.value.push(response.data.room)
                notify({
                    group: "joinUser",
                    title: 'success',
                }, 2000) // 2s
            }).catch(error => {
                console.error(error)
                notify({
                    group: "deleteUser",
                    title: 'error',
                }, 2000) // 2s
            })
        }

        function searchRoom() {
            axios.get('/room/find', {
                params: {
                    password : searchRoomPassword.value,
                }
            }).then(response => {
                searchRoomPassword.value = ''
                searchRoomModal.value = false
                roomLists.value.push(response.data.room)
                notify({
                    group: "joinUser",
                    title: 'success',
                }, 2000) // 2s
            }).catch(error => {
                console.error(error)
                notify({
                    group: "deleteUser",
                    title: 'error',
                }, 2000) // 2s
            })
        }

        return {
            createNewRoom,
            roomListBtn,
            createNewRoomModal,
            roomCreateForm,
            periodPicker,
            searchRoomModal,
            searchRoomPassword,
            searchRoom,
            roomLists,
        }

    }

}
</script>
<style>
</style>

