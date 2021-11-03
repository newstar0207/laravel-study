<template>
    <app-layout>

        <template #header>
            <div>
                교과목 상세보기
            </div>
        </template>
        <div>
            <div>
                <div>
                    교과목명
                </div>
                <div>{{ subject.name}}</div>
                <div>
                    학점
                </div>
                <div>{{ subject.credit}}</div>
                <div>
                    교과목 설명
                </div>
                <div>{{ subject.description}}</div>
                <div>
                    등록일
                </div>
                <div>{{ subject.created_at}}</div>
                <div>
                    변경일
                </div>
                <div>{{ subject.updated_at}}</div>
            </div>
            <div>
                <button class="bg-blue-500"  v-if="$page.props.isAdmin" @click="open_update_modal">수정</button>
                <button class="bg-blue-500" v-if="$page.props.isAdmin"  @click="delete_class">삭제</button>
                <button class="bg-blue-500" v-if="registeredClass==false" @click="register_class">수강신청</button>
                <button class="bg-blue-500" v-if='registeredClass==true' @click="unregister_class">수강취소</button>
            </div>
        </div>



        <jet-dialog-modal :show="confirmUpdate" @close="confirmi = false">
            <template #title>
                교과목 수정
            </template>

            <template #content>
                <div>
                    <label>교과목명</label>
                    <input type="text" v-model="form.name">
                </div>
                <div>
                    <label>학점</label>
                    <input type="text" v-model="form.credit">
                </div>
                <div>
                    <label>교과목 설명</label>
                    <input type="text" v-model="form.description">
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="confirmUpdate = false">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="update_class" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </jet-danger-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>
<script>
import AppLayout from '../Layouts/AppLayout.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'

export default {
    props: {
        'subject': Object,
        'registeredClass' : Boolean,
    },
    components : {
        AppLayout,
        JetDialogModal
    },
    data() {
        return {
            form : {
                name:null,
                credit: 3,
                description: '교과목 설명',
            },
            confirmUpdate : false,
        }
    },
    methods : {
        open_update_modal() {
            console.log('sdd')
            this.form.name = this.subject.name;
            this.form.credit = this.subject.credit;
            this.form.description = this.subject.description;
            this.confirmUpdate = true;
        },
        update_class() {
            this.$inertia.patch('/classes/update/' + this.subject.id, this.form, {
                onSuccess : () => {
                    this.form.name = '';
                    this.form.credit = '';
                    this.form.description = '';
                    this.confirmUpdate = false;
                },
            });
        },
        delete_class() {
            this.$inertia.delete('/classes/delete/' + this.subject.id);
        },
        register_class() {
            this.$inertia.post('/classes/register/' + this.subject.id, {}, {only:['registeredClass']})
        },
        unregister_class() {
            this.register_class();
        },
    }
}
</script>
<style>

</style>
