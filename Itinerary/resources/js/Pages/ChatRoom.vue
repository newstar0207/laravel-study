<template>
    <div>
        show room
        {{ room }}
        <!-- 방 삭제 -->
        <br>
        <button class="bg-blue-500 hover:bg-blue-400" @click="deleteChatRoom">삭제</button>

        <br>
        <!-- 방 수정 (오너일 경우만 가능하게 바꿀것)-->
        <div class="py-12">
            <div class="bg-white shadow-xl sm:rounded-lg h-300">
                <form @submit.prevent="submit()">
                    <label>title</label>
                    <input id="title" required class="border-2 border-gray-300" v-model="form.title" />
                    <label>period</label>
                    <date-picker :date='room' @period='periodPicker'></date-picker>
                    <label>owner</label>
                    <input id="owner" required class="border-2 border-gray-300" v-model='form.owner'>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
                </form>
            </div>
        </div>
        <button></button>
    </div>
</template>
<script>
import { Inertia } from '@inertiajs/inertia'
import DatePicker from './DatePicker.vue'
import { reactive } from 'vue'
import { onMounted } from 'vue'

export default {
    props : [
        'room'
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
            owner : null
        })

        onMounted(() => {
            form.title = props.room.title
            form.owner = props.room.owner
            form.period = null
        })

        const submit = () => {
            Inertia.post('/room', {
                preserveScroll: true,
                onSuccess: () => form.reset(),
            });
        }
        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            form.period = period
        }

        return { deleteChatRoom, submit, periodPicker, form, onMounted}
    }
}
</script>
<style>

</style>
