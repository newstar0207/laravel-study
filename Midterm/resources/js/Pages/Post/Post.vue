<template>
    <div class="container mx-auto my-5 bg-gray-100 rounded-xl m-auto">
        <form @submit.prevent="submit">
            <div class="mx-5 pt-5">
                <label class="block text-sm font-bold mb-2">Title</label>
                <input v-model="form.title" required name="title" class="w-full shadow appearance-none border rounded py-2 px-3 text-grey-darker" type="text" placeholder="title..">
                <!-- <input type="text" v-model="form.title" required/> -->
                <!-- <input type="text" v-model="form.content" required/> -->
                <label class="block text-sm font-bold mb-2">Content</label>
                <input v-model="form.content" required name="content" class="w-full shadow appearance-none border rounded py-2 px-3 text-grey-darker" type="text" placeholder="content..">
                <input type="file" @input="form.image = $event.target.files[0]" />
                <div class="flex flex-row justy">
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <button class="text-green-500 font-bold py-2 px-4 rounded border-b-4 border-green-darkest" type="submit">Submit</button>
                </div>
            </div>
            <br>

        </form>
    </div>
</template>
<script>
export default {
    data(){
        return {
            form : this.$inertia.form({
                title : null,
                image : null,
                content : null,
            }),
        }
    },
    methods: {
        submit() {
            this.form.post('/post', {
                onSuccess: () => this.form.reset('title', 'content', 'image'),
            })
        },
    },
}
</script>
<style>

</style>
