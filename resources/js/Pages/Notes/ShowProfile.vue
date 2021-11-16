<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                ノート
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <div class="flex flex-col items-start p-2 m-3 md:flex-row">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                                <img class="h-40 w-40 rounded-full object-cover" :src="viewed_user.profile_photo_url" :alt="viewed_user.name" />
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

                        </div>

                    </div>
                    <div class="tabs border-b-2 mb-3">
                        <button class="w-1/3 cursor-pointer py-2 px-4 text-gray-500 border-b-8" v-for="tab in tabs" :key="tab" :class="selectedTab === tab ? 'text-red-500 border-red-500' : ''" v-on:click="onClickTab(tab)">
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
        </div>

    </app-layout>
</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
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
            AppLayout,
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
            onClickTab(tab) {
                this.selectedTab = tab
            }
        },
        updated(){

        }
        ,
        created() {
            Inertia.reload({only : ['user']});
            this.selectedTab = this.tabs[0];
        }
    })
</script>

<style scoped>
.active {
    background: #f7c9c9;
}

</style>
