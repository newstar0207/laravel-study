<template>
    <app-layout>
        <!-- <h1>교과목 리스트</h1>
        {{  Subjects.links }}

        <div v-for="subject in Subjects.data" :key="subject.id">
            <div class="border-10 border-black">
                과목명
                <div> {{ subject.name }}</div>
                학점
                <div> {{ subject.credit }}</div>
            </div>
        </div>
        <div>
            <pagination :links = "Subjects.links"/>
        </div> -->

        <table>
            <thead>
                <tr>
                    <th>과목명</th>
                    <th>학점</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="subject in Subjects.data" :key="subject.id" >
                    <td>
                        <p>
                            <Link :href="'/classes/show/' + subject.id">{{ subject.name}}</Link>
                        </p>
                    </td>
                    <td>
                        <p>{{ subject.credit }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
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
    created() {
        // console.log(this.$page.props.user, 'props');
    }
}
</script>
<style>

</style>
