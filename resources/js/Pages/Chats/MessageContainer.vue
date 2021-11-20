<template>
    <div v-if="messages" class="p-2  flex flex-col-reverse overflow-scroll">
        <div v-for="msg in messages" :key="msg.id">
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
    }
}
</script>
