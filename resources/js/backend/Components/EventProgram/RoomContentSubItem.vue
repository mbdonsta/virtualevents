<template>
    <div class="content-sub-item">
        <div class="content-actions">
            <button
                class="edit-content"
                @click="openEditor()">
                <i class="las la-pen"></i>
            </button>
            <button
                class="remove-content"
                @click="removeItem()">
                <i class="las la-times"></i>
            </button>
        </div>
        <div
            :style="{ color: styles.sub_item_time.color }"
            class="sub-time"
            v-text="sub_item.time"></div>
        <div class="sub-content">
            <div
                :style="{ color: styles.sub_item_title.color }"
                class="sub-content-title"
                v-text="sub_item.title"></div>
            <div
                :style="{ color: styles.sub_item_subtitle.color }"
                class="sub-content-sub-title"
                v-text="sub_item.subtitle"></div>
            <div v-if="sub_item.show_button" class="content-button">
                <a
                    :href="sub_item.button_url"
                    :style="{ color: styles.button.color, backgroundColor: styles.button.backgroundColor }"
                    class="btn"
                    v-text="sub_item.button_text"></a>
            </div>
        </div>
        <div v-if="edit_opened" class="sidebar-edit">
            <div class="sidebar-title">
                <h3>Edit</h3>
                <button class="close-sidebar" @click="edit_opened = false">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="edit-form">
                <div class="mb-3">
                    <label>Content time</label>
                    <input
                        v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].time"
                        class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label>Content title</label>
                    <textarea
                        v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].title"
                        class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <label>Content sub title</label>
                    <textarea
                        v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].subtitle"
                        class="form-control"></textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check form-check-custom form-check-solid">
                        <input
                            id="flexCheckDefault"
                            v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].show_button"
                            class="form-check-input"
                            type="checkbox"/>
                        <label class="form-check-label" for="flexCheckDefault">
                            Show button
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Button text</label>
                    <input
                        v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].button_text"
                        class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label>Button URL</label>
                    <input
                        v-model="$parent.$parent.base.rooms.items[room_index].content.items[content_item_index].items[sub_item_index].button_url"
                        class="form-control" type="text">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'sub_item',
        'sub_item_index',
        'content_item_index',
        'room_index',
        'day_index',
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
        removeItem() {
            this.$parent
                .$parent
                .base
                .rooms.items[this.room_index]
                .content.items[this.content_item_index]
                .items
                .splice(this.sub_item_index, 1);
        },
        openEditor() {
            // need rework for global events
            this.$parent.$parent.$emit('close-editors');
            this.$parent.$emit('close-editors');
            this.edit_opened = true;
        }
    }
};
</script>
