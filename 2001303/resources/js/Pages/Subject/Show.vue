<template>
    <div>

        <navi></navi>

        show view
        {{ user }}
        <br>

        <div class="border-2">

        <div>과목명 :{{ subject.name}}</div>
        <div>학점 :{{ subject.credit}}</div>
        <div>과목설명 :{{ subject.info}}</div>
        <div>등록일 :{{ subject.created_at}}</div>
        <div>변경일 :{{ subject.updated_at}}</div>

        </div>

        <div class="border-2">

            <button @click="updateSubject()">수정</button>
            <br>

            <button @click='deleteSubject()'>삭제</button>
            <br>

            <button @click="take()">수강신청</button>
            <br>
            <button @click="cancel()" >수강취소</button>

        </div>

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
                <!-- <button type="submit">Submit</button> -->
            </form>
        </div>



    </div>
</template>
<script>
import Navi from './Navi.vue'
export default {
    components: {
        Navi
    }
    ,
    props: [
        'user',
        'subject',
        'take',
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
        deleteSubject() {
            this.form.subject_name = this.subject.name;
            this.form.subject_credit = this.subject.credit;
            this.form.subject_info = this.subject.info;

            this.$inertia.delete('/subject/' + this.subject.id);
        },
        updateSubject(){
            // this.form.subject_name = this.subject.name;
            // this.form.subject_credit = this.subject.credit;
            // this.form.subject_info = this.subject.info;

            // this.$inertia.post(`/subject/${this.subject.id}`, {
            //     _method : 'put',
            //     name : this.form.subject_name,
            //     credit : this.form.subject_credit,
            //     info : this.form.subject_info
            // })
            this.$inertia.put('/subject/' + this.subject.id, this.form);

        },
        take() {
            // this.form.subject_name = this.subject.name;
            // this.form.subject_credit = this.subject.credit;
            this.form.subject_info = this.subject.info;

            this.$inertia.post('/subject/' + this.subject.id + '/take');
        },
        cancel() {
            this.form.subject_info = this.subject.info;
            this.$inertia.delete('/subject/' + this.subject.id + '/take/' + this.user.id);
        }
    }
}
</script>
<style>

</style>
