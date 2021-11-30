q   <template>
    <div class="flex flex-row ">
        <!-- 방 수정 (오너일 경우만 가능하게 바꿀것) -> 모달로 바꿀것-->
        <div class="py-12">
            <div class="">
                <form @submit.prevent="submit()">
                    <label>title</label>
                    <input id="title" required class="border-2 border-gray-300" v-model="form.title" />
                    <label>period</label>
                    <date-picker :date='room' @period='periodPicker' v-model='form.period'></date-picker>
                    <label>owner</label>
                    <input id="owner" required class="border-2 border-gray-300" v-model='form.owner'>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
                </form>
                <button class="bg-blue-500 hover:bg-blue-400" @click="deleteChatRoom">삭제</button>
                <div v-if="$page.props.errors">{{ errors }}</div>
            </div>

            <div class="border">
                <div v-for="roomUser in updateRoomUsers" :key="roomUser.id" class="border-b-2 flex justify-between space-y-3 items-center">
                    <div v-if="room.owner == roomUser.name">
                        {{  roomUser.name }} owner
                    </div>
                    <div v-else>
                        {{  roomUser.name }}
                    </div>
                    <svg v-if="$page.props.user.id == room.id" @click="userBan(roomUser)"  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
import DatePicker from './DatePicker.vue'
import { reactive, ref } from 'vue'
import { onMounted } from 'vue'
export default {
    props : [
        'room',
        'dateValue',

    ],
    components : {
        DatePicker,
    },
    setup(props) {
        const deleteChatRoom = () => {
            Inertia.delete('/room/' + props.room.id)
        }

        const form = reactive({
            title : null,
            period : null,
            owner : null,
        })

        const updateRoomUsers = ref([])

        onMounted(() => {
            form.title = props.room.title
            form.owner = props.room.owner
            form.period = [props.room.start_period, props.room.end_period]
            console.log('mount in updateChatroom')

        })

        const submit = () => {
            // Inertia.patch('/room/' + props.room.id , form, {
            //     preserveScroll: true,
            //     onSuccess: () => {
            //     },
            // });
            axios.patch('/room/' + props.room.id , form)
            .then((response) => {
                form.title = response.data.title
                form.period = [response.data.start_period, response.data.end_period]
                form.owner = response.data.owner
            })
            .catch((error) => {
                console.error(error)
            })


        }
        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            form.period = period
            console.log(form.period, 'form.period')
        }

        function userBan(roomUser){
            axios.delete(`/room/${props.room.id}/user/${roomUser.id}`)
            .then(response => {
                console.log('userBan ok...')
            }).catch(error => {
                console.error(error);
            })
        }

        var broadcastingUpdateChatRoom = Echo.join(`chat-room.${props.room.id}`)
            .here((user) => {
                console.log(user, 'UpdateChatRoom here!!!');
                updateRoomUsers.value = user
            })
            .joining((user) => {
                console.log(user, 'UpdateChatRoom joining!!!');
                updateRoomUsers.value.push(...user)
            })


         function checkUser(user) {
            for(let i =0; i < updateRoomUsers.value.length; i++) {
                if (updateRoomUsers.value[i].id == user.id) {
                    updateRoomUsers.value.splice(i,1)
                    break
                }
            }
        }



        return {
            deleteChatRoom,
            submit,
            periodPicker,
            form,
            onMounted,
            userBan,
            broadcastingUpdateChatRoom,
            updateRoomUsers,
            checkUser
        }
    }
}
</script>
<style>

</style>
