<template>
<!-- <link
  href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
  rel="stylesheet"
/> -->
    <!-- <div class="w-5/6 mx-auto">
    <div class="flex flex-col overflow-auto lg:overflow-visible">
      <div class="flex lg:justify-between border-b-2 border-fuchsia-900 pb-1 mb-3">
        <h2 class="text-2xl text-gray-500 font-bold">MyNotes</h2>
      </div>
        <div class="flex flex-wrap">
            <div v-for="note in notes.data" :key="note.id"
                class="bg-white text-base w-full rounded-lg shadow border border-3 border-black my-1 flex flex-col">
                <div class="p-2 flex flex-col text-right">
                    <div class="flex justify-between">
                        <div class="flex">
                            <h3 class="text-xl overflow-ellipsis overflow-hidden">{{ note.title }}</h3>
                            <svg v-if="note.pubpriv == false" class="h-7 w-7 text-gray-500"  width="22" height="22" viewBox="0 0 24 22" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="5" y="11" width="14" height="10" rx="2" />  <circle cx="12" cy="16" r="1" />  <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                        </div>
                        <p class="my-1">{{ note.created_at }}</p>
                    </div>
                    <Link :href="'/notes/show/'+note.id" method="get"><button value="button"
                        class="hover:text-white hover:bg-green-400 bg-gray-800 text-gray-400 m-auto my-2 px-6 py-2 text-lg rounded shadow-px-4 border-0">click</button>
                    </Link>
                </div>
            </div>
            <input-link :links="notes.links" />
        </div>
    </div>
    </div> -->
<div class="w-5/6 mx-auto">
    <div class="flex lg:justify-between border-b-2 border-fuchsia-900 pb-1 mb-3">
        <h2 class="text-2xl text-gray-500 font-bold">MyNotes</h2>
    </div>
    <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
        <div v-for="note in notes.data" :key="note" class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
            <a :href="'/notes/show/'+note.id">
                <img class="hover:grow hover:shadow-lg" src="https://images.unsplash.com/photo-1555982105-d25af4182e4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=400&h=400&q=80">
                <div class="pt-3 flex items-center justify-between">
                    <p class="">{{ note.title }}</p>
                    <p class="h-6 w-6 fill-current text-gray-500">
                    <svg v-if="note.pubpriv == false" class="h-7 w-7 text-gray-900"  width="22" height="22" viewBox="0 0 24 22" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">  <path stroke="none" d="M0 0h24v24H0z"/>  <rect x="5" y="11" width="14" height="10" rx="2" />  <circle cx="12" cy="16" r="1" />  <path d="M8 11v-4a4 4 0 0 1 8 0v4" /></svg>
                    </p>
                </div>
                <p class="pt-1 text-gray-900">{{ note.created_at }}</p>
            </a>
        </div>

        <div class="w-full">
            <input-link :links="notes.links" />
        </div>
    </div>
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
