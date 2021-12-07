<template>
    <div v-if="messages" class="p-2  flex flex-col-reverse overflow-scroll">

        <div v-for="msg in this.messages" :key="msg">
            <styled-message-item :message="msg" />
        </div>
    </div>
</template>

<script>
    import StyledMessageItem from './StyledMessageItem.vue'
export default {
    props : ['messages'],
    components : {
        StyledMessageItem
    },
    data() {
        return {
            messages_data : this.messages.data,
        }
    },
    methods: {
        scroll: function () {
            const self = this;
            window.onscroll = function(ev) {
                // console.log(this.messages);
                if(document.documentElement.scrollTop < 10) {
                    self.$inertia.visit(next.url, {
                        preserveScroll : true,
                        preserveState : true,
                    });
                    self.messages_data.push(...self.messages.data);
                }
            }
        }
    },
    mounted() {
        this.scroll();
        // console.log(this.$page.props.messages)
    },

}
</script>
