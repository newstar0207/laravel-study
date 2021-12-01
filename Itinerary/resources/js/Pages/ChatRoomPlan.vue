<template>

    <!-- 새로운 스케줄 입력 -->

    <form @submit.prevent="submit()">
        <label>schedule</label>
        <input type="text" v-model="form.schedule">
        <label>date</label>
        <input type= "date" v-model="form.date">
        <button type="submit">submit</button>
    </form>


    <!-- 스케줄 출력 -->

    <div>
        <div v-for="schedule in schedules" :key="schedule.id">
            <div class="border-b-2">
                <div v-if="schedule.iscomplete == 1" class="line-through">{{ schedule.schedule}}</div>
                <div v-else>{{ schedule.schedule }}</div>
                <div>{{schedule.date}}</div>
                <div class="flex flex-row-reverse">
                    <button @click="deleteSchedule(schedule.id)">delete</button>
                    <button @click="completeSchedule(schedule.id)">complete</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { reactive, ref } from '@vue/reactivity'
import { onMounted } from '@vue/runtime-core'
export default {
    props: [
        'room'
    ],
    setup(props) {

        const schedules = ref([])
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
        }
    }

}
</script>
<style>

</style>
