<template>
    <form @submit.prevent="submit()">
        <label>schedule</label>
        <input type="text" v-model="form.schedule">
        <label>date</label>
        <input type= "date" v-model="form.date">
        <button type="submit">submit</button>
    </form>

    <div>
        <div v-for="schedule in schedules" :key="schedule.id">
            <div class="border-b-2">
                <div>{{ schedule.schedule }}</div>
                <div class="flex flex-row-reverse">
                    <button>delete</button>
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
                for (let i = 0; i < response.data.length ; i++) {
                    schedules.value.push(response.data[i])
                }
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
            axios.post(`/room/${props.room.id}/schdule/${scheduleId}`, {
                complete : true,
            }).then(response => {
                console.log(response.data)
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
        }
    }

}
</script>
<style>

</style>
