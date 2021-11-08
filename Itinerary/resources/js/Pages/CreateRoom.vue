<template>
    <div class="border-2 border-gray-500">
        <div class="py-12">
            <div class="bg-white shadow-xl sm:rounded-lg h-300">
                    <form @submit.prevent="submit()">
                    <label>title</label>
                    <input id="title" required class="border-2 border-gray-300" v-model="form.title" />
                    <label>period</label>
                    <date-picker @period='periodPicker'></date-picker>
                    <!-- {{ period }} -->
                    <!-- <input id="period" required class="border-2 border-gray-300" v-model="form.period" /> -->
                    <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import DatePicker from './DatePicker.vue'
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
    components : {
        DatePicker,
    },
    props : [
        'dateValue'
    ],
    setup (props) {
        const form = reactive({
            title: null,
            period : null,
        })
        const submit = () => {
            Inertia.post('/room', form, {
                preserveScroll: true,
            });
        }
        const periodPicker = (period) => {
            console.log(period, 'datavalue...')
            form.period = period
        }

        const openChatRoom = (room) => {
            Inertia.get('/room/' + room.id)
        }

        return { form, submit, periodPicker, openChatRoom }
    },
}
</script>
<style>

</style>
