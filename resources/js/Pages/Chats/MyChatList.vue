<template>
    <new-layout title="Dashboard">
    <template #content>
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
				CHATS
			</a>
                </div>
            </nav>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden sm:rounded-lg">
                    <div class="py-10 px-2">
                        <div class="w-full mx-auto bg-white shadow-lg">
                            <div class="md:flex">
                                <div class="w-full p-4">
                                    <ul>
                                        <li v-for="room in rooms" :key="room" class="flex justify-between items-center bg-gray-100 mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                            <Link :href="'/chat/room/'+room.id" method="get">
                                            <div v-for="chatuser in room.chatuser" :key="chatuser">
                                                <div class="flex ml-2" v-if="chatuser.id != $page.props.user.id">
                                                     <img :src="chatuser.profile_photo_url" width="40" height="40" class="rounded-full">
                                                <div class="flex flex-col ml-2"> <span class="font-medium text-black">{{ chatuser.name }}</span> <span class="text-sm text-gray-400 truncate w-32"></span> </div>
                                            </div>
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
        </section>
        </template>

    </new-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    // import AppLayout from '@/Layouts/AppLayout.vue'
    import NewLayout from '@/Layouts/NewLayout.vue'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        props : ['rooms'],
        components: {
            Link,
            NewLayout,
        },
    })
</script>
