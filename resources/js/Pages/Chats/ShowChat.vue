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
                <div class="bg-white overflow-hidden">
                    <div class="py-10 px-2">
                    <div class="w-full bg-white shadow-lg">
                        <div class="md:flex">
                            <div class="w-full p-4">
                                <div class="card w-5/6 m-auto">
                                    <div class="card-header"></div>
                                    <div class="card-body">
                                        <message-container :messages="this.messages" />
                                    </div>
                                    <div class="card-footer">
                                        <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
                                            <div class="relative flex">
                                                <input
                                                    id="btn-input"
                                                    type="text"
                                                    name="message"
                                                    class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 bg-gray-200 rounded-full py-3"
                                                    placeholder="Type your message here..."
                                                    v-model="form.newMessage"
                                                    @keyup.enter="sendMessage"
                                                    />
                                                <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                                                    <button @click="sendMessage" type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 transform rotate-90">
                                                            <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    import NewLayout from '@/Layouts/NewLayout.vue'
    import MessageContainer from './MessageContainer.vue'

    export default defineComponent({
        props : ['roomId'],
    components : {
        MessageContainer,
        NewLayout
    },
    data() {
        return {
            form : {
                newMessage : '',
                room_id : this.roomId,
            },
            messages : null,
        }
    },
    methods: {
        connect() {
            if(this.roomId) {
                let vm = this;
                this.getMessages();
                window.Echo.private('chat.'+ this.roomId)
                            .listen('.message.new', e => {
                                vm.getMessages();
                                // console.log(this.messages);
                            });
            }
        },
        disconnect(roomId) {
            window.Echo.leave('chat.'+roomId);
        },
        getMessages() {
            axios.get('/chat/room/'+this.roomId+'/messages')
            .then(response => {
                this.messages = response.data;
                // console.log(response.data);
            })
            .catch(error => {
                console.log(error);
            });
        },
        sendMessage() {
            // this.$inertia.post('/chat/room/'+this.roomId+'/message', this.form, {
            //      onSuccess: () => {
            //          this.form.newMessage = ''
            //          this.getMessages();
            //      }
            // });
            axios.post('/chat/room/'+this.roomId+'/message', {
                message : this.form.newMessage
            })
            .then(response => {
                // console.log(response.data);
                this.getMessages();
                this.form.newMessage = '';
            })
        },
    },
    created() {
        this.connect();
    }
    })
</script>

