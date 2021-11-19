<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ note.title }}
                </h2>
                <Link :href="'/profiles/'+note.user.name" method="get"><span class="text-gray-500">{{ note.user.name }}</span></Link>
            </div>
            <div class="text-right h-10">
                <button v-if="$page.props.user.id == note.user_id" @click="open_edit_modal" class="m-2 text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                    <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-4 h-4 inline-block mr-1">
                        <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                L5.68,17.217z"/>
                    </svg>
                    <span>수정</span>
                </button>
                <button v-if="$page.props.user.id == note.user_id" @click="showDelModal" class="m-2 text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                    <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-4 h-4 inline-block mr-1">
                        <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                L5.68,17.217z"/>
                    </svg>
                    <span>삭제</span>
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">단어</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">의미</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="word in note.words" :key="word.id">
                                <th class="border-b-2 p-2">{{ word.language }}</th>
                                <th class="border-b-2 p-2">{{ word.mean }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-dialog-modal :show="createNote">
            <template #title>
                <select class="float-right" v-model="pubpriv">
                    <option :value="false">비공개</option>
                    <option :value="true">공개</option>
                </select>
                <input
                    type="text"
                    name="name"
                    v-model="title"
                    placeholder="단어장"
                    class="pt-3 pb-2 block w-4/5 px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                    />

            </template>
            <template #content>
                <table class="w-full mb-3">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">단어</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">의미</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in wordsCount" :key="i">
                            <th><input type="text" @keydown.enter="searchMean(i-1)" v-model="languages[i-1]" class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></th>
                            <th><input type="text" @keydown.enter="searchWord(i-1)" v-model="means[i-1]" class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></th>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button @click="count" class="p-0 w-10 h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                        <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-6 h-6 inline-block">
                            <path fill="#FFFFFF" d="M16,10c0,0.553-0.048,1-0.601,1H11v4.399C11,15.951,10.553,16,10,16c-0.553,0-1-0.049-1-0.601V11H4.601
                                                    C4.049,11,4,10.553,4,10c0-0.553,0.049-1,0.601-1H9V4.601C9,4.048,9.447,4,10,4c0.553,0,1,0.048,1,0.601V9h4.399
                                                    C15.952,9,16,9.447,16,10z" />
                        </svg>
                    </button>
                </div>

            </template>
            <template #footer>
                <button @click="submit(this.languages, this.means)" class="m-1 text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                            <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                                class="w-4 h-4 inline-block mr-1">
                                <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                        c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                        L5.68,17.217z" />
                            </svg>
                            <span>저장</span></button>
                <button @click="closeModal" class="m-1 text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                            <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                                class="w-4 h-4 inline-block mr-1">
                                <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                        c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                        L5.68,17.217z" />
                            </svg>
                            <span>취소</span></button>
            </template>

        </jet-dialog-modal>
        <jet-dialog-modal :show="showDelete" >
            <template #content>

                <!-- <div class="flex flex-col p-8 bg-white shadow-md hover:shodow-lg rounded-2xl"> -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-16 h-16 rounded-2xl p-3 border border-blue-100 text-blue-400 bg-blue-50" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex flex-col ml-3">
                                <div class="font-medium leading-none">Delete Your Note?</div>
                                <p class="text-sm text-gray-600 leading-none mt-1">By deleting your note you will lose your all data
                                </p>
                            </div>
                        </div>
                        <div>
                            <button @click="deleteNote" class="flex-no-shrink bg-red-500 px-5 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full">Delete</button>
                            <button @click="showDelete = false" class="flex-no-shrink bg-red-500 px-5 ml-2 py-2 text-sm shadow-sm hover:shadow-lg font-medium tracking-wider border-2 border-red-500 text-white rounded-full">Cancel</button>
                        </div>

                    </div>
                <!-- </div> -->
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        props : ['note'],
        components: {
            AppLayout,
            JetDialogModal,
            Link,
        },
        data() {
            return {
                createNote : false,
                wordsCount : 1,
                title:'',
                languages: [],
                means:[],
                pubpriv : false,
                currentCount : null,
                showDelete : false,
                form : {
                    language : '',
                    mean : '',
                    note_id : null,
                    currentBol : true,
                },
            }
        },
        methods: {
            closeModal() {

                this.createNote = false;

            },
            showDelModal(){
                this.showDelete = true;
            },
            count() {
                this.wordsCount += 1
                console.log(this.wordsCount);
            },
            searchWord(index) {
                console.log(this.wordShow);
                axios.post('/translate/word', {
                    'word' : this.means[index],
                }).then(response=> {
                    console.log(response.data);
                    this.languages[index] = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },
            searchMean(index) {
                console.log(this.wordShow);
                axios.post('/translate/word', {
                    'word' : this.languages[index]
                }).then(response=> {
                    console.log(response.data);
                    this.means[index] = response.data;
                }).catch(error => {
                    console.log(error);
                });

            },
            open_edit_modal() {
                console.log(this.note.pubpriv);
                this.createNote = true;
                this.title = this.note.title;
                this.wordsCount = this.note.words.length;
                this.currentCount = this.note.words.length;
                this.pubpriv = this.note.pubpriv == 1 ? true : false;
                for (let i = 0; i < this.wordsCount; i++) {
                    this.languages[i] = this.note.words[i].language;
                    this.means[i] = this.note.words[i].mean;
                }
            },
            updateNote(languages, means) {
                console.log(this.wordsCount);
                console.log(this.pubpriv);
                const counts = this.wordsCount;
                axios.patch('/notes/update/'+this.note.id, {
                    'title' : this.title,
                    'pubpriv' : this.pubpriv,
                    })
                .then(response => {
                    this.form.note_id = response.data;
                    console.log(this.form.note_id);
                    for(let i=0; i< counts; i++ ){
                        console.log('dddd');
                        this.form.language = languages[i]
                        this.form.mean = means[i]
                        console.log(this.form.note_id + ' ' + this.form.language + ' ' +  this.form.mean);
                        console.log(this.currentCount);
                        if(i < this.currentCount) {
                            if(!this.form.language && !this.form.mean){
                                this.$inertia.delete('/words/delete/'+this.note.words[i].id);
                            }else{
                                console.log(this.note.words[i].id);
                                this.$inertia.patch('/words/update/'+this.note.words[i].id, this.form);
                            }
                        }else {
                            console.log(this.form.currentBol);
                            this.$inertia.post('/words/store', this.form);
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });

                this.createNote = false;

            },
            deleteNote() {

                    this.$inertia.delete('/notes/delete/'+this.note.id);
            }
        },
    })
</script>
