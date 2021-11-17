
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
        props : ['messages', 'roomId'],
    components : {
        MessageContainer,
        AppLayout
    },
    data() {
        return {
            form : {
                newMessage : '',
                room_id : this.roomId,
            }

        }
    },
    methods: {
        sendMessage() {
            this.$inertia.post('/chat/room/'+this.roomId+'/message', this.form, {
                 onSuccess: () => {
                     this.form.newMessage = ''
                 }
            });
        },
    },
    })
</script>

