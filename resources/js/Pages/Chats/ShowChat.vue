
<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ this.roomId }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="card">
                        <div class="card-header">Chats</div>
                        <div class="card-body">
                            <message-container :messages="messages" />
                        </div>
                        <div class="card-footer">
                            <input
                                id="btn-input"
                                type="text"
                                name="message"
                                class="form-control input-sm"
                                placeholder="Type your message here..."
                                v-model="form.newMessage"
                                @keyup.enter="sendMessage"
                                />
                            <span>
                                <button class="btn btn-primary btn-sm" id="btn-chat" @click="sendMessage">
                                    Send
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import MessageContainer from './MessageContainer.vue'

    export default defineComponent({
        props : ['roomId'],
    components : {
        MessageContainer,
        AppLayout
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
                                console.log(this.messages);
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
                console.log(response.data);
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
                console.log(response.data);
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

