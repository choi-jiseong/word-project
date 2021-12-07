<template>
    <new-layout title="Dashboard">
    <template #content>
    <section class="bg-white py-8">

        <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">

            <nav id="store" class="w-full z-30 top-0 px-6 py-1">
                <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 px-2 py-3">

                    <a class="uppercase tracking-wide no-underline hover:no-underline font-bold text-gray-800 text-xl " href="#">
				        NOTES
			        </a>
                    <div class="text-right">
                        <button @click="open_create_modal()" @close="createNote == false"
                            class="m-5 text-white px-4 w-auto h-10 bg-gray-900 rounded-full hover:bg-gray-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                            <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                                class="w-4 h-4 inline-block mr-1">
                                <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                        c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                        L5.68,17.217z" />
                            </svg>
                            <span>Note</span>
                        </button>
                    </div>
                </div>
            </nav>

            <div v-for="note in notes.data" :key="note" class="w-full md:w-1/3 xl:w-1/4 p-6 flex flex-col">
                <a :href="'/notes/show/'+note.id">
                    <img class="hover:grow hover:shadow-lg" src="https://images.unsplash.com/photo-1555982105-d25af4182e4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=400&h=400&q=80">
                    <div class="pt-3 flex items-center justify-between">
                        <p class="">{{ note.title }}</p>
                        <p class="h-6 w-6 fill-current text-gray-500">
                            {{ note.user.name }}
                        </p>
                    </div>
                    <p class="pt-1 text-gray-900">{{ note.created_at }}</p>
                </a>
            </div>


        <div class="w-full">
            <input-link :links="notes.links" />
        </div>
        </div>

    </section>

    </template>
    </new-layout>
        <jet-dialog-modal :show="createNote">
            <template #title>
                <select class="float-right" v-model="pubpriv">
                    <option :value="false" >비공개</option>
                    <option :value="true">공개</option>
                </select>
                <input type="text" name="name" v-model="title" placeholder="단어장"
                    class="pt-3 pb-2 block w-4/5 px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200" />

            </template>
            <template #content>
                <table class="w-full mb-3 shadow-2xl">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">단어</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">의미</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="i in wordsCount" :key="i">
                            <th>
                                <input type="text" @keydown.enter="searchMean(i-1)" v-model="this.form.languages[i-1]"
                                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200">
                            </th>
                            <th>
                                <input type="text" @keydown.enter="searchWord(i-1)" v-model="this.form.means[i-1]"
                                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200">
                            </th>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button @click="count"
                        class="p-0 w-10 h-10 bg-gray-900 rounded-full hover:bg-gray-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                        <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20" class="w-6 h-6 inline-block">
                            <path fill="#FFFFFF" d="M16,10c0,0.553-0.048,1-0.601,1H11v4.399C11,15.951,10.553,16,10,16c-0.553,0-1-0.049-1-0.601V11H4.601
                                                    C4.049,11,4,10.553,4,10c0-0.553,0.049-1,0.601-1H9V4.601C9,4.048,9.447,4,10,4c0.553,0,1,0.048,1,0.601V9h4.399
                                                    C15.952,9,16,9.447,16,10z" />
                        </svg>
                    </button>
                </div>

            </template>
            <template #footer>
                <button @click="submit(this.form.languages, this.form.means)" class="m-1 text-white px-4 w-auto h-10 bg-gray-900 rounded-full hover:bg-gray-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                            <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                                class="w-4 h-4 inline-block mr-1">
                                <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                        c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                        L5.68,17.217z" />
                            </svg>
                            <span>저장</span></button>
                <button @click="closeModal" class="m-1 text-white px-4 w-auto h-10 bg-gray-900 rounded-full hover:bg-gray-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
                            <svg viewBox="0 0 20 20" enable-background="new 0 0 20 20"
                                class="w-4 h-4 inline-block mr-1">
                                <path fill="#FFFFFF" d="M17.561,2.439c-1.442-1.443-2.525-1.227-2.525-1.227L8.984,7.264L2.21,14.037L1.2,18.799l4.763-1.01                                                        l6.774-6.771l6.052-6.052C18.788,4.966,19.005,3.883,17.561,2.439z M5.68,17.217l-1.624,0.35c-0.156-0.293-0.345-0.586-0.69-0.932
                                                        c-0.346-0.346-0.639-0.533-0.932-0.691l0.35-1.623l0.47-0.469c0,0,0.883,0.018,1.881,1.016c0.997,0.996,1.016,1.881,1.016,1.881
                                                        L5.68,17.217z" />
                            </svg>
                            <span>취소</span></button>
            </template>

        </jet-dialog-modal>
</template>

<script>
    import {
        defineComponent
    } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import NewLayout from '@/Layouts/NewLayout.vue'
    import JetDialogModal from '@/JetStream/DialogModal.vue'
    import InputLink from '../InputLink.vue'
    import {
        Link
    } from '@inertiajs/inertia-vue3'
    import axios from 'axios'
    export default defineComponent({
        props: {
            notes: Array,
            errors: Object,
        },
        components: {
            AppLayout,
            JetDialogModal,
            InputLink,
            Link,
            NewLayout,
        },
        data() {
            return {
                notes_data:this.notes.data,
                createNote: false,
                wordsCount: 1,
                title: '',
                pubpriv: false,
                form: {
                    languages: [],
                    means: [],
                    note_id: null,
                    counts : 0,
                },
                // list : [1, 1, 1, 1,1 ,1 ,1]
            }
        },
        methods: {
            closeModal() {
                this.title = ''
                this.form.note_id = null;
                this.form.languages = [];
                this.form.means = [];
                this.pubpriv = false;
                this.wordsCount = 1;
                this.createNote = false;
            },
            searchWord(index) {
                axios.post('/translate/word', {
                    'word' : this.form.means[index],
                }).then(response=> {
                    console.log(response.data);
                    this.form.languages[index] = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            searchMean(index) {
                axios.post('/translate/word', {
                    'word' : this.form.languages[index],
                }).then(response=> {
                    console.log(response.data);
                    this.form.means[index] = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            count() {
                this.wordsCount += 1
            },
            open_create_modal() {
                console.log('dd')
                this.createNote = true;
                console.log(this.createNote)
            },
            submit(languages, means) {
                const counts = this.wordsCount;

                axios.post('/notes/store', {
                        'title': this.title,
                        'pubpriv': this.pubpriv,
                    })
                    .then(response => {
                        this.form.note_id = response.data;
                        this.form.languages = languages;
                        this.form.means = means;
                        this.form.counts = counts;
                        this.$inertia.post('/words/store', this.form, {
                                onSuccess: () => {
                                    this.title = ''
                                    this.form.note_id = null;
                                    this.form.languages = [];
                                    this.form.means = [];
                                    this.form.counts = 0;
                                    this.pubpriv = false;
                                    this.wordsCount = 1;
                                    this.createNote = false;
                                }
                            });
                    })
                    .catch(error => {
                        console.log(error);
                    });

            },
        },
    })
</script>
