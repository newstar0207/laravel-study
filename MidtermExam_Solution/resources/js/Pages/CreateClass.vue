<template>
    <div>
        <h1>교과목 등록</h1>
        <div class="border-5 m-5">
            <form @submit.prevent="submit()">
                <label>name</label>
                <input id="name" required class="border-2 border-gray-300" v-model="form.name" />
                <label>credit</label>
                <input id="credit" required class="border-2 border-gray-300" v-model="form.credit" />
                <label>description</label>
                <input id="description" required class="border-2 border-gray-300" v-model="form.description" />
                <button type="submit" class="bg-blue-500 hover:bg-blue-400">Submit</button>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            form : {
                name : null,
                credit: null,
                description: null,
            }
        }
    },
    methods : {
        submit() {
            this.$inertia.post('/classes/store', this.form);
        }
    }
}
</script>
<style >

</style>
