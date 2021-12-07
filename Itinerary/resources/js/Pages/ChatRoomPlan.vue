<template>

    <!-- 새로운 스케줄 입력 -->

    <div class="p-6">

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <div class="ml-2 font-semibold text-xl text-gray-400">
                    Schedule
                </div>
            </div>
            <button @click="scheduleBtn = true" class="text-green-500">new Schedule</button>
        </div>
    </div>


    <jet-dialog-modal :show="scheduleBtn" @close="scheduleBtn = false" >
        <template #title>
            <h1 class="text-xl font-bold">Update New Schedule</h1>
        </template>
        <template #content>
            <div class="flex justify-evenly mt-10">
                <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                    <div class="-mt-4 absolute px-1 uppercase text-xs">
                        <label class="bg-white text-gray-600 px-1">Schedule</label>
                    </div>
                    <input v-model="form.schedule" autocomplete="false" type="text" class="py-1 px-1 outline-none block h-full w-full">
                </div>
                <div class="border focus-within:border-blue-500 focus-within:text-blue-500 relative rounded p-1">
                    <div class="-mt-4 absolute px-1 uppercase text-xs">
                        <label class="bg-white text-gray-600 px-1">Date</label>
                    </div>
                    <input type='date' v-model="form.date" autocomplete="false" class="py-1 px-1 outline-none block h-full w-full">
                </div>
            </div>
        </template>
        <template #footer>
            <button @click="submit()" class="rounded text-gray-100 px-3 py-1 bg-blue-500 hover:shadow-inner hover:bg-blue-700">Save</button>
        </template>
    </jet-dialog-modal>



    <!-- 스케줄 출력 -->

    <div v-for="schedule in schedules" :key="schedule.id" class="px-6">
        <div class="flex flex-col mt-1 lg:w-6/12 px-4">
            <div class="px-3 py-3 bg-white rounded text-sm mb-3 flex justify-between">
                <div>
                    <div v-if="schedule.iscomplete == 1" class="line-through">{{ schedule.schedule}}</div>
                    <div v-else class="font-medium">{{ schedule.schedule }}</div>
                    <div class="text-xs text-gray-400">{{schedule.date}}</div>
                </div>
                <div class="flex">
                    <svg @click="completeSchedule(schedule.id)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <svg @click="deleteSchedule(schedule.id)" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <!-- <button @click="deleteSchedule(schedule.id)">delete</button> -->
                    <!-- <button @click="completeSchedule(schedule.id)">complete</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- <div>
            <div class="border-b-2">
                <div class="flex flex-row-reverse">
                </div>
            </div>
    </div> -->
</template>
<script>
import { reactive, ref } from '@vue/reactivity'
import { onMounted } from '@vue/runtime-core'
import JetDialogModal from '../Jetstream/DialogModal.vue'
export default {
    props: [
        'room'
    ],

    components: {
        JetDialogModal,
    },
    setup(props) {

        const schedules = ref([])
        const scheduleBtn = ref(false)
        const form = reactive({
            schedule : '',
            date : ''
        })

        onMounted(() => {
            // console.log()
            axios.get(`/room/${props.room.id}/schedule`)
            .then(response => {
                console.log(response.data, 'schedules...')
                let json = response.data
                schedules.value.push(...json)
            }).catch(error => {
                console.log(error)
            })
        })

        function submit() {
            axios.post(`/room/${props.room.id}/schedule`, {
                schedule : form.schedule,
                date : form.date,
            }).then(response => {
                console.log(response.data)
                resetForm()
            }).catch(error => {
                console.error(error)
            })
        }

        function resetForm() {
            form.schedule = null
            form.date = null
        }

        function completeSchedule(scheduleId){
            axios.put(`/room/${props.room.id}/schedule/${scheduleId}`, {
                iscomplete : true,
            }).then(response => {
                console.log(response.data)
                for(let i = 0; i < schedules.value.length; i++) {
                    if(schedules.value[i].id == response.data.id){
                        schedules.value[i].iscomplete = 1
                        break
                    }
                }
                schedules.value
            }).catch(error => {
                console.log(error)
            })
        }

        var broadcastingChatRoomPlan  = Echo.join(`chat-room.${props.room.id}`)
            .listen('AddSchedule', (e) => {
                console.log(e.schedule)
                schedules.value.push(e.schedule)
            }).listen('DeleteSchedule', (e) => {
                for(let i = 0; i < schedules.value.length; i++) {
                    if(schedules.value[i].id == e.scheduleId){
                        schedules.value.splice(i,1)
                        break
                    }
                }
            })

        function deleteSchedule(scheduleId){
            axios.delete(`/room/${props.room.id}/schedule/${scheduleId}`)
            .then(response => {
                console.log(response.message)
            }).catch(error => {
                console.log(error)
            })
        }


        return {
            form,
            submit,
            resetForm,
            onMounted,
            schedules,
            completeSchedule,
            broadcastingChatRoomPlan,
            deleteSchedule,
            scheduleBtn,
        }
    }

}
</script>
<style>

</style>
