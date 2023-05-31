<template>
    <div
        :class="[room_item.opened ? 'opened' : '']"
        class="me-3 action-buttons-holder">
        <div class="action-buttons">
            <button
                class="day-button-actions action-btn edit-item"
                @click="openEditor()"
            >
                <i class="las la-pen"></i>
            </button>
            <button
                v-if="rooms_length > 1"
                class="day-button-actions action-btn remove-item"
                @click="removeRoom($parent.base.rooms.items, room_index)">
                <i class="las la-times"></i>
            </button>
        </div>
        <button
            :style="generateStyle()"
            class="day-button-actions tab-btn"
            @click="selectRoom($parent.base.rooms.items, room_index)"
            v-text="room_item.title"></button>
        <div v-if="edit_opened" class="sidebar-edit">
            <div class="sidebar-title">
                <h3>Edit {{ room_item.title }}</h3>
                <button class="close-sidebar" @click="edit_opened = false">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="edit-form">
                <div class="mb-3">
                    <label>Room label</label>
                    <input
                        v-model="$parent.base.rooms.items[room_index].title"
                        class="form-control" type="text">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'day_index',
        'room_item',
        'room_index',
        'rooms_length',
        'styles'
    ],
    data: function () {
        return {
            edit_opened: false
        }
    },
    created() {

    },
    mounted() {
        this.$parent.$on('close-editors', () => {
            this.edit_opened = false;
        })
    },
    methods: {
        openEditor() {
            this.$parent.$emit('close-editors');
            this.edit_opened = true;
        },
        selectRoom(room_items, room_index) {
            this.$parent.$emit('close-editors');
            this.$parent.selectRoom(room_items, room_index);
        },
        removeRoom(room_items, room_index) {
            this.$parent.removeRoom(room_items, room_index);
        },
        generateStyle() {
            if (this.room_item.opened) {
                return this.styles.opened;
            }

            return this.styles.base;
        }
    }
};
</script>
