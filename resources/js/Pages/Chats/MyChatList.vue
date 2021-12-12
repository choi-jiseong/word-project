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
                    <div class="container mx-auto py-5 flex justify-center h-screen">
                        <div class="w-4/5 h-60 flex flex-col shadow-xl">
                            <div class="bg-white text-sm text-gray-500 font-bold px-5 py-2 shadow border-b border-gray-300">
                                MyChat List
                            </div>
                            <div class="w-full h-full overflow-auto shadow bg-white" id="journal-scroll">
                                <table class="w-full">
                                    <tbody class="">
                                        <tr v-for="room in rooms" :key="room" class="relative transform scale-100
                                                py-1 border-b-2 border-blue-100 cursor-default hover:bg-blue-100
                                            ">
                                            <Link :href="'/chat/room/'+room.id" method="get">
                                                <div v-for="chatuser in room.chatuser" :key="chatuser">
                                                    <div class="flex flex-rows" v-if="chatuser.id != $page.props.user.id" >
                                                        <td class="pl-5 py-5 pr-3">
                                                            <img :src="chatuser.profile_photo_url" width="40" height="40" class="rounded-full">
                                                        </td>
                                                        <td class="px-2 my-auto whitespace-no-wrap">
                                                            <div class="leading-5 text-gray-500 font-medium">{{ chatuser.name }}</div>
                                                        </td>
                                                    </div>
                                                </div>
                                            </Link>
                                        </tr>
                                    </tbody>
                                </table>
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
<style scoped>
  #journal-scroll::-webkit-scrollbar {
            width: 4px;
            cursor: pointer;
            /*background-color: rgba(229, 231, 235, var(--bg-opacity));*/

        }
        #journal-scroll::-webkit-scrollbar-track {
            background-color: rgba(229, 231, 235, var(--bg-opacity));
            cursor: pointer;
            /*background: red;*/
        }
        #journal-scroll::-webkit-scrollbar-thumb {
            cursor: pointer;
            background-color: #a0aec0;
            /*outline: 1px solid slategrey;*/
        }
</style>
