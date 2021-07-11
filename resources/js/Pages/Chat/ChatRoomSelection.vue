<template>
    <div class="room">
        <div class="outer">
            {{ selected.name }} Chat
        </div>
        <div>
            <select v-model="selected" @change="$emit('roomchanged', selected)">
                <option v-for="(room, index) in rooms" :key="index" :value="room" >
                    {{ room.name }}
                </option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    props: ['rooms', 'currentRoom'],
    data: function () {
        return {
            selected: '',
        }
    },
    created() {
        this.selected = this.currentRoom;
    },
}
</script>
