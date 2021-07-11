<template>
    <div class="input ">
        <div>
            <input type="text"
                   v-model="message"
                   @keyup.enter="sendMessage()"
                   placeholder="Say something.."
            />
            <button
                @click="sendMessage()"
            >Send</button>
        </div>
    </div>
</template>

<script>
import Input from "@/Jetstream/Input";

export default {
    components: { Input },
    props: ['room'],
    data: function () {
        return {
            message: '',
        }
    },
    methods: {
        sendMessage() {
            if ( this.message == ' ') {
                return;
            }
            axios.post('/chat/room/' + this.room.id + '/message', {
                message: this.message
            })
            .then( response => {
                if (response.status == 201) {
                    this.message = '';
                    this.$emit('messagesent');
                }
            })
            .catch( error => {
                console.log(error);
            })
        }
    }
}
</script>
