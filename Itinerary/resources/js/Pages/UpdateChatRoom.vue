q   <template>
    <div class="flex flex-col w-full flex-1">
        <!-- 방 수정 (오너일 경우만 가능하게 바꿀것) -> 모달로 바꿀것-->



            <div class="flex items-center border-b-2">
                <p class="text-center text-base md:text-lg font-semibold mt-6">
                    date:  {{ room.start_period }} ~ {{ room.end_period }}
                </p>
            </div>


            <p class="px-2 py-3 font-bold">Users...</p>
            <div  v-for="roomUser in roomUsers" :key="roomUser.id" class="cursor-pointer border-gray-100 rounded-t border-b p-3 hover:bg-teal-100 flex-1">
                <div class="flex w-full items-center p-2 pl-2 border-transparent border-l-2 hover:border-blue-500">
                    <div class="w-6 flex flex-col items-center">
                        <div class="flex relative w-5 h-5 bg-orange-500 justify-center items-center m-1 mr-2 w-4 h-4 rounded-full ">
                            <img class="rounded-full" :alt="roomUser.name" :src="'/storage/' + roomUser.profile_photo_path">
                        </div>
                    </div>

                    <div v-if="room.owner == roomUser.name" class="w-full items-center flex">
                        <div class="mx-2 ">{{ roomUser.name }} owner</div>
                    </div>
                    <div v-else class="w-full items-center flex">
                        <div class="mx-2 ">{{ roomUser.name }}</div>
                    </div>

                    <svg :key="rerendering"  v-if="$page.props.user.name == room.owner" @click="userBan(roomUser)"  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>



            <div class="w-full flex justify-around border-t-2">
                    <button @click="updateBtn = true" class="sm:w-auto px-9 py-4  my-2 items-center text-base font-semibold  rounded-full block  hover:bg-blue-300 border border-blue-300 text-blue-600 hover:text-blue-200 ">update</button>
                    <button class="sm:w-auto px-9 py-4 mb-2 text-base items-center my-2 font-semibold  rounded-full block  hover:bg-red-300 border border-red-300 text-red-600 hover:text-red-200 ">cancel</button>
            </div>

            <jet-dialog-modal :show="updateBtn" @close="updateBtn = false" >
                <template #title>
                    <h1 class="text-xl font-bold">Update New Room</h1>
                </template>
                <template #content>
                    <div class="h-96 overflow-auto space-y-6 mx-8">
                        <label class="text-sm font-medium text-gray-900 block mb-2">period</label>
                        <date-picker  class="bg-gray-50" @period='periodPicker' v-model="updateForm.period"></date-picker>
                        <label class="text-sm font-medium text-gray-900 block mb-2">title</label>
                        <input id="title" required  placeholder="update room title..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="updateForm.title" />
                        <label class="text-sm font-medium text-gray-900 block mb-2">owner</label>
                        <input id="title" required  placeholder="update room owner..."  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" v-model="updateForm.owner" />
                    </div>
                </template>
                <template #footer>
                    <div>
                        <button @click="updateRoom()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
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
        'roomUsers'
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

        const updateForm = reactive({
            title : null,
            period : [],
            owner : null,
        })

        onMounted(() => {
            updateForm.title = props.room.title
            updateForm.owner = props.room.owner
            updateForm.period = [props.room.start_period, props.room.end_period]
            console.log('mount in updateChatroom', updateForm)
        })

        function updateRoom() {
            axios.patch('/room/' + props.room.id, {
                title : updateForm.title,
                period : updateForm.period,
                owner : updateForm.owner
            }).then((response) => {
                rerendering.value += 1
                updateForm.title = response.data.title
                updateForm.period = [response.data.start_period, response.data.end_period]
                updateForm.owner = response.data.owner
                updateBtn.value = false

            }).catch((error) => {
                console.error(error)
            })
        }

        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            updateForm.period = [period[0], period[1]]
        }

        function userBan(roomUser){
            axios.delete(`/room/${props.room.id}/user/${roomUser.id}`)
            .then(response => {
                console.log('userBan ok...')
            }).catch(error => {
                console.error(error);
            })
        }

        return {
            deleteChatRoom,
            periodPicker,
            updateForm,
            onMounted,
            userBan,
            updateBtn,
            updateRoom,
        }
    }
}
</script>
<style>

</style>
