<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-row items-start">
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                    <img :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" class="rounded-full h-40 w-40 object-cover">
                </div>
                <div class="flex-col justify-items-start">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{  username }}
                    </h2>
                    <div class="mb-4 flex flex-row">
                        <div class="mr-10">게시물 4</div>
                        <div class="mr-10">팔로워 80</div>
                        <div class="mr-10">팔로우 72</div>
                    </div>
                    <div class="mb-4">새별이</div>
                    <div class="mb-4">새별이</div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <post-list :post = 'post'></post-list>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from './Instagram/PostList.vue'

    export default defineComponent({
        components: {
            AppLayout,
            PostList,
        },
        props : [
            'username',
            'post'
        ]
    })
</script>
