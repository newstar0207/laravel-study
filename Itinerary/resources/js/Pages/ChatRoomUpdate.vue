<template>
    <div class="">
        <!-- 방 수정 (오너일 경우만 가능하게 바꿀것) -> 모달로 바꿀것-->

        <div class="bg-white rounded-t-lg border border-b-2 h-auto p-4 pl-6 flex justify-between">
            <div class="font-semibold text-2xl flex">
                <div>
                    {{ originData.roomTitle }}
                </div>
                <div class="font-base text-xl text-gray-400 ml-2 flex items-end">
                    {{ originData.roomPassword }}
                </div>
            </div>

            <button  v-if="$page.props.user.name == room.owner" @click="updateBtn = true" class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                Update
            </button>
        </div>

        <jet-dialog-modal :show="updateBtn" @close="updateBtn = false,  updateBtnClose()" >
            <template #title>
                <h1 class="text-xl font-bold">Update New Room</h1>
            </template>
            <template #content>
                <div class="h-96 overflow-auto space-y-6 mx-8">
                    <label class="text-sm font-medium text-gray-900 block mb-2">period</label>
                    <date-picker class="bg-gray-50" @period='periodPicker' :date="period"></date-picker>
                    <label class="text-sm font-medium text-gray-900 block mb-2">title</label>
                    <input id="title" required  placeholder="update room title..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="updateForm.title" />
                    <label class="text-sm font-medium text-gray-900 block mb-2">owner</label>
                    <input id="title" required  placeholder="update room owner..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="updateForm.owner" />
                </div>
                <div class="font-bold text-red-700">{{ errorMessage }}</div>
            </template>
            <template #footer>
                <div class="flex justify-between">
                    <button @click="updateRoom()" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                    <button @click='deleteChatRoom()' class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete Room</button>
                </div>
            </template>
        </jet-dialog-modal>

        </div>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
import DatePicker from './DatePicker.vue'
import { reactive, ref } from 'vue'
import { onMounted } from 'vue'
import JetDialogModal from '../Jetstream/DialogModal.vue'
export default {
    props : [
        'room',
        'dateValue',

    ],
    components : {
        DatePicker,
        JetDialogModal,
    },
    setup(props) {

        const updateBtn = ref(false)

        const deleteChatRoom = () => {
            Inertia.delete('/room/' + props.room.id)
        }

        // 원본데이터
        const originData = reactive({
            roomTitle : props.room.title,
            roomPassword : props.room.password,
            roomPeriod : [props.room.start_period, props.room.end_period],
            roomOwner : props.room.owner,
        })

        const errorMessage = ref('')

        const updateForm = reactive({
            title : '',
            owner : '',
            password : '',
        })

        const period = ref([])

        onMounted(() => {
            // roomTit
            axios.get('/room/' + props.room.id + '/update')
            .then((response) => {
                updateForm.owner = response.data.owner
                updateForm.title = response.data.title
                updateForm.password = response.data.password
                period.value[0] = response.data.start_period
                period.value[1] = response.data.start_period
                originData.roomTitle = response.data.title
                originData.roomPassword = response.data.password
                originData.roomPeriod = [response.data.start_period, response.data.start_period]
                originData.roomOwner = response.data.owner
            }).catch((error) => {
                console.error(error)
            })
        })

        function updateBtnClose(){
            updateForm.title = originData.roomTitle
            updateForm.password = originData.roomPassword
            period.value = [originData.roomPeriod[0], originData.roomPeriod[1]]
            updateForm.owner = originData.roomOwner
            errorMessage.value = ''
        }

        const broadcastingRoom = Echo.join(`chat-room.${props.room.id}`)
            .listen('UpdateRoom', (e) => {
                updateForm.title = e.room.title
                updateForm.owner = e.room.owner
                period.value[0] = e.room.start_period
                period.value[1] = e.room.end_period
                originData.roomTitle = e.room.title
                originData.roomPassword = e.room.password
                originData.roomPeriod = [e.room.start_period, e.room.end_period]
            }).listen('DeleteRoom', (e) => {
                console.log('deleteRoom Event')
                Inertia.get(route('room.index'))
            })


        function updateRoom() {
            axios.patch('/room/' + props.room.id, {
                title : updateForm.title,
                period : period.value,
                owner : updateForm.owner
            }).then((response) => {
                updateBtn.value = false
            }).catch((error) => {
                console.error(error)
                errorMessage.value = 'you are not owner, FOREIGN KEY constraint failed'
            })
        }

        const periodPicker = (per) => {
            console.log(per, 'datavalue...')
            period.value = [per[0], per[1]]
        }


        return {
            deleteChatRoom,
            periodPicker,
            updateForm,
            onMounted,
            updateBtn,
            updateRoom,
            period,
            broadcastingRoom,
            originData,
            updateBtnClose,
            errorMessage,

        }
    }
}
</script>
<style>

</style>
