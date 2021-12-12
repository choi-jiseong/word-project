<template>
    <new-layout title="Dashboard">
        <template #content>
            <section class="bg-white py-8">

                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                        USER
                        </a>
                        </div>
                    </nav>
                <div class="bg-white overflow-hidden sm:rounded-lg w-full">
                    <div class="bg-cover bg-right" style="background-image: url('https://images.unsplash.com/photo-1422190441165-ec2956dc9ecc?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1600&q=80');">
                        <div class="flex flex-col items-start p-5 m-5 md:flex-row">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                                <img class="h-40 w-40 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>
                            <div class="flex-col justify-items-start">
                                <div class="flex">
                                    <h2 class="fint-semibold text-xl text-gray-800 leading-tight mb-4">
                                        {{ viewed_user.name }}
                                    </h2>
                                    <!-- <button class="px-2 mx-4 mb-4 font-semibold text-blue-700 bg-transparent border">follow</button> -->
                                    <follow-button :user="user" :viewed_user="viewed_user" />
                                </div>
                                <div class="mb-4 flex flex-row">
                                    <div class="mr-10">게시물 {{ viewed_user.notes.length }}</div>
                                    <div class="mr-10">팔로워 {{ followers.length }}</div>
                                    <div class="mr-10">팔로잉 {{ viewed_user.following.length }}</div>
                                </div>
                                <div class="mb-4">{{ viewed_user.username }}</div>
                                <div class="mb-4"> {{ viewed_user.profile ? viewed_user.profile.title : 'no title' }}</div>
                                <div class="mb-4"> {{ viewed_user.profile ? viewed_user.profile.description : 'no description' }}</div>
                            </div>
                            <button @click="playChat(viewed_user.id)" class="border p-2 my-auto rounded-2xl">채팅하기</button>
                        </div>
                    </div>
                    <div class="tabs border-b-2 mb-3">
                        <button class="w-1/3 cursor-pointer py-2 px-4 text-gray-900 border-b-8" v-for="tab in tabs" :key="tab" :class="selectedTab === tab ? 'text-gray-900 border-gray-900' : ''" v-on:click="onClickTab(tab)">
                            {{ tab }}
                        </button>
                    </div>
                    <div v-show="selectedTab == tabs[0]">
                        <my-notes :notes="notes" />
                    </div>
                    <div v-show="selectedTab == tabs[1]">
                        <followers-list :followers="followers" />
                    </div>
                    <div v-show="selectedTab == tabs[2]">
                        <following-list :following="following" />
                    </div>
                </div>
                </div>


            </section>
        </template>

    </new-layout>
</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import NewLayout from '@/Layouts/NewLayout.vue'
    import MyNotes from './MyNotes.vue'
    import FollowButton from '../FollowButton.vue'
    import FollowersList from '../FollowersList.vue'
    import FollowingList from '../FollowingList.vue'
import { Inertia } from '@inertiajs/inertia'

    export default defineComponent({
        props: {
            notes: Array,
            // errors: Object,
            user : Object,
            viewed_user : Object,
            followers : Array,
            following : Array,

        },
        components: {
            NewLayout,
            MyNotes,
            FollowButton,
            FollowersList,
            FollowingList,

        },
        data() {
            return {
                tabs : ['Notes', '팔로워', '팔로잉'],
                selectedTab : '',
            }
        },
        methods: {
            playChat(userId) {
            this.$inertia.post('/chat/room/create', {chatUserId : userId});
            },
            onClickTab(tab) {
                this.selectedTab = tab
            }
        }
        ,
        created() {
            this.selectedTab = this.tabs[0];
        }
    })
</script>

<style scoped>
.active {
    background: #f7c9c9;
}

</style>
