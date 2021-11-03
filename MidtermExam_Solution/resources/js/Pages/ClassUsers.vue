<template>
    <app-layout>
        <template #header>
            <div>
                수강신청자 리스트
            </div>
        </template>
        <!-- {{  users }} -->
        <table>
            <thead>
                <tr>
                    <th>사용자 프로파일 이미지</th>
                    <th>사용자 명</th>
                    <th>사용자 이메일</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users.data" :key="user.id" >
                    <td>
                        <img :src="user.profile_photo_url" :alt="user.name">
                    </td>
                    <td>
                        <p>{{ user.name }}</p>
                    </td>
                    <td>
                        <p>{{ user.email }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div>
            <pagination :links='users.links'></pagination>
        </div>

    </app-layout>
</template>
<script>

import Pagination from './Pagination.vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    props: ['users'],
    components : {
        Pagination,
        AppLayout,
        Link,
    },

}
</script>
<style>

</style>
