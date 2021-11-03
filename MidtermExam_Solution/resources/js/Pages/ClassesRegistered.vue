<template>
    <app-layout>
        <template #header>
            <div>
                수강 교과목 리스트
            </div>
            <h2>
                수강과목 수 : {{ numOfRegisteredClasses }}
            </h2>
            <h2>
                수강학점 : {{ totalCredits }}
            </h2>
        </template>
        <!-- {{  subjects }} -->
        <table>
            <thead>
                <tr>
                    <th>과목명</th>
                    <th>학점</th>
                    <th>수강신청자 수</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="subject in subjects" :key="subject.id" >
                    <td>
                        <p>
                            <Link :href="'/classes/show/' + subject.id">{{ subject.name}}</Link>
                        </p>
                    </td>
                    <td>
                        <p>{{ subject.credit }}</p>
                    </td>
                    <td>
                        <!-- <p>{{ subject.users.length }}</p> -->
                        <Link :href="'/classes/users/' + subject.id" method="get" type="button">
                            {{ subject.users.length }}
                        </Link>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <div>
            <pagination :links='Subjects.links'></pagination>
        </div> -->

    </app-layout>
</template>
<script>

// import Pagination from './Pagination.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    props: ['subjects'],
    components : {
        // Pagination,
        AppLayout,
        Link,
    },
    data(){
        return {

        }
    },
    computed : {
        numOfRegisteredClasses() {
            return this.subjects.length;
        },
        totalCredits() {
            let sum = 0;
            for ( let i = 0; i < this.subjects.length; i++){
                sum += parseInt(this.subjects[i].credit);
            }
            return sum;
        }
    }
}
</script>
<style>

</style>
