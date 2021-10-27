<template>
    <div>
        this is container

        <navi></navi>


        <!--  교과목 등록  -->

        <div class="flex flex-col border-2">
            <form @submit.prevent="submit">
                <label for="subject_name">subject_name:</label>
                <input id="subject_name" v-model="form.subject_name" />
                <br>
                <label for="subject_credit">subject_credit:</label>
                <input id="subject_credit" v-model="form.subject_credit" />
                <br>
                <label for="subject_info">subject_info:</label>
                <input id="subject_info" v-model="form.subject_info" />
                <br>
                <button type="submit">Submit</button>
            </form>
        </div>



        <!--  교과목 목록  -->
        <div class="border-2" v-if="subjects">
            <div v-for="subject in subjects" :key="subject.id" class="border-2 m-3">

                <div>과목명 : {{ subject.name }}</div>
                <div>학점 :{{ subject.credit }}</div>

                <button @click="showSubject(subject)">상세보기</button>
                <!-- <button @click="showUser(subject)">수강신청자</button> -->
            </div>
        </div>

    </div>
</template>
<script>
import Navi from './Subject/Navi.vue'
export default {
    components : {
        Navi
    },
    props: [
        'subjects'
    ],
    data() {
        return {
            form: {
                subject_name : null,
                subject_credit : null,
                subject_info : null,
            },
        }
    },
    methods: {
        submit() {
            this.$inertia.post('/subject', this.form)
        },
        showSubject(subject) {
            this.$inertia.visit('subject/' + subject.id, {method : 'get'})
        },
        // showUser(subject) {
        //     this.$inertia.get('')
        // }
    },

}
</script>
<style>

</style>
