<template>
    <new-layout title="Chat">
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
                <div class="bg-white h-screen">
                    <div class="py-10 px-2">
                    <div class="w-full bg-white shadow-xl">
                        <div class="md:flex">
                            <div class="w-full p-4">
                                <div class="card w-5/6 m-auto">
                                    <div class="card-header"></div>
                                    <div class="card-body">
                                        <div v-if="messages" id="scrollcontainer" ref="me" class="p-2 flex flex-col-reverse overflow-y-scroll scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch h-80">
                                            <div>
                                            <div v-for="message in this.messages.data" :key="message.id">
                                                <div>
                                                    <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-auto ">
                                                        <div class="chat-message" v-if="message.user.id != $page.props.user.id">
                                                            <div class="flex items-end">
                                                                <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
                                                                    <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">
                                                                        {{ message.user.name }} : {{ message.message }}
                                                                    </span></div>
                                                                </div>
                                                                <img class="h-8 w-8 rounded-full object-cover" :src="message.user.profile_photo_url" :alt="message.user.name" />
                                                            </div>
                                                        </div>
                                                        <div class="chat-message" v-if="message.user.id == $page.props.user.id">
                                                                <div class="flex items-end justify-end">
                                                                    <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                                                    <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
                                                                        <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">
                                                                            {{ message.user.name }} :{{ message.message }}
                                                                        </span></div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
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
    import { debounce } from 'lodash'
    export default defineComponent({
        props : ['roomId'],
    components : {
        MessageContainer,
        NewLayout,
    },
    data() {
        return {
            form : {
                newMessage : '',
                room_id : this.roomId,
            },
            messages : null,
            messages_data : null,
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
        async getMessages() {
            await axios.get('/chat/room/'+this.roomId+'/messages')
            .then(response => {
                this.messages = response.data;
                this.messages_data = this.messages.data;
                this.messages.data = this.messages.data.reverse();
                // console.log(response.data.data);
            })
            .catch(error => {
                console.log(error);
            });
        },
        getMoreMessages() {
            if(this.messages.current_page == this.messages.last_page) {
                // alert('No more message')
                return;
            }
            axios.get(this.messages.next_page_url).then(response => {
                // this.messages = response.data;
                // this.messages.data = [...this.messages.data, ...response.data.data]
                this.messages = {...response.data, 'data' : [...this.messages.data.reverse(), ...response.data.data]};
                this.messages.data = this.messages.data.reverse();
            }).catch(error => {
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
                // console.log(this.messages.data);
                this.getMessages();
                // this.messages.data.push(response.data.data);
                // this.messages = {...response.data, 'data' : [...this.messages.data, ...response.data.data]};
                this.form.newMessage = '';
            })
        }
    },
    created() {
        this.connect();
    },
    mounted() {

        // var t = document.getElementById('scrollcontainer');
        window.addEventListener("scroll", debounce((e) => {
            // console.log('scroll')
            // console.log("offsetHeight:"+document.documentElement.offsetHeight)
            // console.log("scrollTop:"+document.documentElement.scrollTop)
            // console.log("InnerHeight:"+window.innerHeight)
            console.log(document.documentElement.scrollTop)
            if(document.documentElement.scrollTop < 10) {
                this.getMoreMessages();
            }
        }, 100));
    },
    })
</script>

<style scoped>
.scrollbar-w-2::-webkit-scrollbar {
  width: 0.25rem;
  height: 0.25rem;
}

.scrollbar-track-blue-lighter::-webkit-scrollbar-track {
  --bg-opacity: 1;
  background-color: #f7fafc;
  background-color: rgba(247, 250, 252, var(--bg-opacity));
}

.scrollbar-thumb-blue::-webkit-scrollbar-thumb {
  --bg-opacity: 1;
  /* background-color: #edf2f7; */
  /* background-color: rgba(237, 242, 247, var(--bg-opacity)); */
  background-color: #a0aec0;
}

.scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
  border-radius: 0.25rem;
}
</style>

