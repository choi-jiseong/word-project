<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex flex-col">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ note.title }}
                </h2>
                <h3 class="text-gray-500">{{ note.user.name }}</h3>
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
                <button v-if="$page.props.user.id == note.user_id" @click="deleteNote" class="m-2 text-white px-4 w-auto h-10 bg-red-600 rounded-full hover:bg-red-700 active:shadow-lg mouse shadow transition ease-in duration-200 focus:outline-none">
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
                    <table class="w-full mb-3">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">단어</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100">의미</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="word in note.words" :key="word.id">
                                <th>{{ word.language }}</th>
                                <th>{{ word.mean }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-dialog-modal :show="createNote">
            <template #title>
                <input
                    type="text"
                    name="name"
                    v-model="title"
                    placeholder="단어장"
                    class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"
                    />
                <select class="float-right" v-model="pubpriv">
                    <option :value="false">비공개</option>
                    <option :value="true">공개</option>
                </select>
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
                            <th><input type="text" v-model="languages[i-1]" class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></th>
                            <th><input type="text" v-model="means[i-1]" class="pt-3 pb-2 block w-full px-0 mt-0 bg-transparent border-0 border-b-2 appearance-none focus:outline-none focus:ring-0 focus:border-black border-gray-200"></th>
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
                <button @click="updateNote(this.languages, this.means)" class="bg-blue-500">수정</button>
                <button @click="createNote = false; this.wordsCount=1" class="bg-blue-500">취소</button>
            </template>

        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetDialogModal from '@/JetStream/DialogModal.vue'

    export default defineComponent({
        props : ['note'],
        components: {
            AppLayout,
            JetDialogModal,

        },
        data() {
            return {
                createNote : false,
                wordsCount : 1,
                // saveNoteId : null,
                title:'',
                languages: [],
                means:[],
                pubpriv : false,
                currentCount : null,
                form : {
                    language : '',
                    mean : '',
                    note_id : null,
                    currentBol : true,
                }
            }
        },
        methods: {
            count() {
                this.wordsCount += 1
                console.log(this.wordsCount);
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

                // this.title = ''
                // this.languages = [];
                // this.means = [];
                // this.form.note_id = null;
                // this.form.language = '',
                // this.form.mean = '',
                // this.pubpriv = false;
                this.createNote = false;

            },
            deleteNote() {

                if(confirm('삭제?')){
                    this.$inertia.delete('/notes/delete/'+this.note.id);
                }else{
                    return;

                }

            }
        },
    })
</script>
