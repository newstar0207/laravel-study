q   <template>
    <div class="">
        <!-- 방 수정 (오너일 경우만 가능하게 바꿀것) -> 모달로 바꿀것-->

        <div class="bg-white rounded-t-lg border border-b-2 h-auto p-4 pl-6 flex justify-between">
            <div class="font-semibold text-2xl">
                {{ room.password }}
            </div>
            <button @click="updateBtn = true" class="bg-pink-500 text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="button">
                Update
            </button>
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
                <div class="flex justify-between">
                    <button @click="updateRoom()" class="text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Submit</button>
                    <button  class="text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Delete Room</button>
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
