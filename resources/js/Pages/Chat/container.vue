<template>
    <app-layout>
        <template #header>
            <div class="container">
                <chat-room-selection
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    v-on:roomchanged="setRoom($event)"/>
            </div>
        </template>

        <div class="messages-container container">
            <div class="message-container">
                <message-container :messages="messages"/>
                <input-message :room="currentRoom" v-on:messagesent="getMessages()"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import MessageContainer from "@/Pages/Chat/MessageContainer";
import InputMessage from "@/Pages/Chat/InputMessage";
import ChatRoomSelection from "@/Pages/Chat/ChatRoomSelection";

export default {
    components: {
        ChatRoomSelection,
        InputMessage,
        MessageContainer,
        AppLayout,
    },
    data: function () {
        return {
            chatRooms: [],
            currentRoom: [],
            messages: [],
        }
    },
    watch: {
        currentRoom(val, oldVal) {
            if (oldVal.id) {
                this.disconnect(oldVal)
            }
            this.connect();
        }
    },
    methods: {
        connect() {
            if (this.currentRoom.id) {
                let vm = this;
                this.getMessages();
                window.Echo.private("chat." + this.currentRoom.id)
                    .listen('.message.new', e => {
                        vm.getMessages();
                    })
            }
        },
        disconnect(room) {
            window.Echo.leave("chat." + room.id);
        },
        getRooms() {
            axios.get('/chat/rooms')
                .then(response => {
                    this.chatRooms = response.data;
                    this.setRoom(response.data[0]);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        setRoom(room) {
            this.currentRoom = room;
        },
        getMessages() {
            axios.get('/chat/room/' + this.currentRoom.id + '/messages')
                .then(response => {
                    this.messages = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
    },
    created() {
        this.getRooms();
    }
}
</script>
