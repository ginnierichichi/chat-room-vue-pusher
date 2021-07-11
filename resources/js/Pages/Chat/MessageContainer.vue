<template>
    <div class="inner-container">
        <div>
            <div v-for="(message, index) in messages" :key="index">
                <message-item :message="message"/>
            </div>
        </div>
    </div>
</template>

<script>
import MessageItem from "@/Pages/Chat/MessageItem";
export default {
    components: {MessageItem},
    props: ['messages'],
}
</script>
