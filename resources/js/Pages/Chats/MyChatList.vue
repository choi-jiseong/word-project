<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="py-10 px-2">
                        <div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-lg overflow-hidden md:max-w-lg">
                            <div class="md:flex">
                                <div class="w-full p-4">
                                    <ul>
                                        <li v-for="(room, index) in rooms" :key="room" class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                            <Link :href="'/chat/room/'+room.id" method="get">
                                            <div class="flex ml-2"> <img :src="chatUsers[index].profile_photo_url" width="40" height="40" class="rounded-full">
                                                <div class="flex flex-col ml-2"> <span class="font-medium text-black">{{ chatUsers[index].name }}</span> <span class="text-sm text-gray-400 truncate w-32"></span> </div>
                                            </div>
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        props : ['rooms', 'chatUsers'],
        components: {
            AppLayout,
            Link,
        },
    })
</script>
