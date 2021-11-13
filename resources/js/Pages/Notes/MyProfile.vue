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
                        <div class="flex flex-row items-start p-2 m-3">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                                <img class="h-40 w-40 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>
                            <div class="flex-col justify-items-start">
                                <h2 class="fint-semibold text-xl text-gray-800 leading-tight mb-4">
                                    {{ $page.props.user.name }}
                                </h2>
                                <div class="mb-4 flex flex-row">
                                    <div class="mr-10">게시물 {{ $page.props.user.notes.length }}</div>
                                    <div class="mr-10">팔로워 80</div>
                                    <div class="mr-10">팔로잉 70</div>
                                </div>
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
                        팔로워
                    </div>
                    <div v-show="selectedTab == tabs[2]">
                        팔로잉
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

    export default defineComponent({
        props: {
            notes: Array,
            errors: Object,
        },
        components: {
            AppLayout,
            MyNotes,

        },
        data() {
            return {
                tabs : ['MyNotes', '팔로워', '팔로잉'],
                selectedTab : '',
            }
        },
        methods: {
            onClickTab(tab) {
                this.selectedTab = tab
            }
        },
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
