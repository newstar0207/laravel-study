<template>
    <app-layout>
        <table>
            <thead>
                <tr>
                    <th>과목명</th>
                    <th>학점</th>
                    <th v-if="$page.props.isAdmin" @click="sort">수강자 수</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="subject in subjectList" :key="subject.id" >
                    <td>
                        <p>
                            <Link :href="'/classes/show/' + subject.id">{{ subject.name}}</Link>
                        </p>
                    </td>
                    <td>
                        <p>{{ subject.credit }}</p>
                    </td>
                    <td v-if="$page.props.isAdmin">
                        <Link v-if="$page.props.isAdmin" :href="'/classes/users/' + subject.id" method='get' type="button">
                            {{ subject.users.length }}
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <!-- {{  Subjects.links }} -->
            <pagination :links='Subjects.links'></pagination>
        </div>

    </app-layout>
</template>
<script>

import Pagination from './Pagination.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    props: ['Subjects'],
    components : {
        Pagination,
        AppLayout,
        Link,
    },
    data() {
        return{
            subjectList : this.Subjects.data,
            toggle : true,
        }
    },
    methods : {
        sort(){
            // console.log('click');
            let vm = this;
            this.subjectList.sort(function(s1, s2) {
                if (vm.toggle) {
                    return s1.users.length - s2.users.length;
                }else {
                    return s2.users.length - s1.users.length;
                }
            });
            this.toggle = !this.toggle;
        }
    }
}
</script>
<style>

</style>
