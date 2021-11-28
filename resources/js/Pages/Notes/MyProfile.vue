<template>
    <new-layout title="Dashboard">
        <template #content>
            <section class="bg-white py-8">

                <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

                    <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                            <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
                        MY
                        </a>
                        </div>
                    </nav>
                <div class="bg-white overflow-hidden sm:rounded-lg w-full">
                    <div class="">
                        <div class="flex flex-col items-start p-2 m-5 md:flex-row">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                                <img class="h-40 w-40 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>
                            <div class="flex-col justify-items-start">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                    {{ $page.props.user.name }}
                                </h2>
                                <div class="mb-4 flex flex-row">
                                    <div class="mr-10">게시물 {{ $page.props.user.notes.length }}</div>
                                    <div class="mr-10">팔로워 {{ followers.length }}</div>
                                    <div class="mr-10">팔로잉 {{ $page.props.user.following.length }}</div>
                                </div>
                                <div class="mb-4">{{ $page.props.user.username }}</div>
                                <div class="flex justify-between">
                                    <div>
                                        <div class="mb-4"> {{ $page.props.user.profile ? $page.props.user.profile.title : 'no title' }}</div>
                                        <div class="mb-4"> {{ $page.props.user.profile ? $page.props.user.profile.description : 'no description' }}</div>
                                    </div>
                                    <button @click="showProModal" class="border p-2 my-auto rounded-2xl">profile 편집</button>
                                </div>
                            </div>
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

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <div class="flex flex-col items-start p-2 m-3 md:flex-row">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3 px-40">
                                <img class="h-40 w-40 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>
                            <div class="flex-col justify-items-start">
                                <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                                    {{ $page.props.user.name }}
                                </h2>
                                <div class="mb-4 flex flex-row">
                                    <div class="mr-10">게시물 {{ $page.props.user.notes.length }}</div>
                                    <div class="mr-10">팔로워 {{ followers.length }}</div>
                                    <div class="mr-10">팔로잉 {{ $page.props.user.following.length }}</div>
                                </div>
                                <div class="mb-4">{{ $page.props.user.username }}</div>
                                <div class="flex justify-between">
                                    <div>
                                        <div class="mb-4"> {{ $page.props.user.profile ? $page.props.user.profile.title : 'no title' }}</div>
                                        <div class="mb-4"> {{ $page.props.user.profile ? $page.props.user.profile.description : 'no description' }}</div>
                                    </div>
                                    <button @click="showProModal" class="border p-2 my-auto rounded-2xl">profile 편집</button>
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
                        <followers-list :followers="followers" />
                    </div>
                    <div v-show="selectedTab == tabs[2]">
                        <following-list :following="following" />
                    </div>
                </div>
            </div>
        </div> -->
    </new-layout>
    <jet-dialog-modal :show="showProEdit" >
        <template #content>
            <div class="flex flex-col">
                <label for="">Title</label>
                <input type="text" v-model="form.proTitle"><br>
                <label for="">Description</label>
                <input type="text" v-model="form.proDescription">
            </div>

        </template>
        <template #footer>
            <button @click="editPro" class="flex-no-shrink bg-red-500 px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full">수정</button>
            <button @click="showProEdit = false" class="flex-no-shrink ml-2 bg-red-500 px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full">취소</button>
        </template>
    </jet-dialog-modal>

</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import NewLayout from '@/Layouts/NewLayout.vue'
    import MyNotes from './MyNotes.vue'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    import FollowersList from '../FollowersList.vue'
    import FollowingList from '../FollowingList.vue'


    export default defineComponent({
        props: {
            notes: Array,
            errors: Object,
            followers : Array,
            following : Array,
        },
        components: {
            MyNotes,
            JetDialogModal,
            FollowersList,
            FollowingList,
            NewLayout,

        },
        data() {
            return {
                tabs : ['MyNotes', '팔로워', '팔로잉'],
                selectedTab : '',
                profileEdit : false,
                showProEdit : false,
                form : {
                    proTitle : '',
                    proDescription : '',
                    user_id : this.$page.props.user.id,
                }
            }
        },
        methods: {
            editPro() {
                if(this.$page.props.user.profile){
                    this.$inertia.patch('/profiles/'+this.$page.props.user.profile.id, this.form, {
                        onSuccess: () => {
                            this.showProEdit = false;
                        }
                    });
                }else{
                    this.$inertia.post('/profiles', this.form, {
                        onSuccess: () => {
                            this.showProEdit = false;
                        }
                    });
                }
            },
            showProModal(){
                this.showProEdit = true;
                this.form.proTitle = this.$page.props.user.profile.title;
                this.form.proDescription =  this.$page.props.user.profile.description;
            },
            onClickTab(tab) {
                this.selectedTab = tab
            }
        },
        created() {
            this.selectedTab = this.tabs[0];
        }
    })
</script>

