<template>
    <div v-if="links.length > 3">
        <template v-for="(link, k) in links" :key='k'>
            <div v-if="link.url === null"></div>
            <Link v-else></Link>
        </template>

    </div>
</template>
<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    props: {
        links : Array,
    },
    components : {
        Link,
    }
}
</script>
<style>

</style>
