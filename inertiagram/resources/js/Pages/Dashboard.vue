<template>
    <app-layout title="Dashboard">
        <template #header>
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                <img :src="$page.props.user.profile_photo_url" alt="username" class="rounded-full h-40 w-40 object-cover">
            </div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{  username }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden sm:rounded-lg">
                    <post-list></post-list>
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
            'username'
        ]
    })
</script>
