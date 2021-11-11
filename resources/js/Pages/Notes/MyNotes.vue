<template>
    <div class="flex flex-wrap">
        <div v-for="note in notes.data" :key="note.id"
            class="bg-white text-base w-full rounded-lg shadow m-2 border border-3 border-black my-1 flex flex-col">
            <div class="p-2 flex flex-col text-right">
                <div class="flex justify-between">
                    <h3 class="text-xl overflow-ellipsis overflow-hidden">{{ note.title }}</h3>
                    <p class="my-1">{{ note.created_at }}</p>
                </div>
                <Link :href="'/notes/show/'+note.id" method="get"><button value="button"
                    class="hover:text-white hover:bg-green-400 bg-gray-800 text-gray-400 m-auto my-2 px-6 py-2 text-lg rounded shadow-px-4 border-0">click</button>
                </Link>
            </div>
        </div>
        <input-link :links="notes.links" />
    </div>
</template>

<script>
    import InputLink from '../InputLink.vue'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
export default {
    props : ['notes'],
    components:{
        InputLink,
        Link,
    }

}
</script>

<style scoped>

</style>
