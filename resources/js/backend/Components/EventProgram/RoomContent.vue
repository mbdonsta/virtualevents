<template>
    <div :class="'schedule-content-item style-' + content_item.type">
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
        <div :style="{ backgroundColor: time_col_styles.backgroundColor }" class="left-side">
            <span :style="{ color: time_col_styles.color }" class="left-side__content"
                  v-text="content_item.time"></span>
        </div>
        <div :style="{ borderColor: content_styles.row_border_color }" class="right-side">
            <div v-if="content_item.type === 'default'" class="right-side__image">
                <image-upload
                    :file_id="content_item.file_id"
                    :file_url="content_item.file_url"
                    :route="route"
                    field_name="media_file_id"
                    field_url_name="media_file_url"
                    @imageUploaded="setImage($event, content_item)"></image-upload>
            </div>
            <div class="right-side__content">
                <h3 :style="{ color: content_styles[content_item.type].title.color }" class="title"
                    v-text="content_item.title"></h3>
                <div
                    v-if="content_item.type !== 'minimal'"
                    :style="{ color: content_styles[content_item.type].subtitle.color }"
                    class="subtitle"
                    v-text="content_item.subtitle"></div>
                <div v-if="content_item.type === 'default' && content_item.show_button" class="content-button">
                    <a
                        :href="content_item.button_url"
                        :style="{ color: content_styles[content_item.type].button.color, backgroundColor: content_styles[content_item.type].button.backgroundColor }"
                        class="btn"
                        v-text="content_item.button_text"></a>
                </div>
                <div v-if="content_item.type === 'compact'" class="sub-items">
                    <div v-for="(sub_item, sub_item_index) in content_item.items">
                        <room-content-sub-item
                            :key="sub_item_index"
                            :content_item_index="content_item_index"
                            :day_index="day_index"
                            :room_index="room_index"
                            :styles="content_styles[content_item.type]"
                            :sub_item="sub_item"
                            :sub_item_index="sub_item_index"
                        ></room-content-sub-item>
                    </div>
                    <div class="add-sub-item">
                        <button
                            class="btn btn-sm btn-success"
                            @click="addSubItem()">
                            Add sub Item
                        </button>
                    </div>
                </div>
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
                    <label>Content style</label>
                    <select
                        v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].type"
                        class="form-select">
                        <option value="default">Default</option>
                        <option value="compact">Compact</option>
                        <option value="minimal">Minimal</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Content time</label>
                    <input
                        v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].time"
                        class="form-control" type="text">
                </div>
                <div class="mb-3">
                    <label>Content title</label>
                    <textarea
                        v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].title"
                        class="form-control"></textarea>
                </div>
                <div v-if="content_item.type !== 'minimal'" class="mb-3">
                    <label>Content sub title</label>
                    <textarea
                        v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].subtitle"
                        class="form-control"></textarea>
                </div>
                <div v-if="content_item.type === 'default'">
                    <div class="mb-3">
                        <div class="form-check form-check-custom form-check-solid">
                            <input
                                id="flexCheckDefault"
                                v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].show_button"
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
                            v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].button_text"
                            class="form-control" type="text">
                    </div>
                    <div class="mb-3">
                        <label>Button URL</label>
                        <input
                            v-model="$parent.base.rooms.items[room_index].content.items[content_item_index].button_url"
                            class="form-control" type="text">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RoomContentSubItem from "./RoomContentSubItem";

export default {
    components: {RoomContentSubItem},
    props: [
        'content_item',
        'content_item_index',
        'room_index',
        'day_index',
        'route',
        'time_col_styles',
        'content_styles'
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
        setImage(event, content_item) {
            this.$parent.base.rooms.items[this.room_index].content.items[this.content_item_index].file_id = event.file_id;
            this.$parent.base.rooms.items[this.room_index].content.items[this.content_item_index].file_url = event.file_url;
        },
        removeItem() {
            this.$parent.base.rooms.items[this.room_index].content.items.splice(this.content_item_index, 1);
        },
        addSubItem() {
            let default_content = {
                time: '09:00 - 10:00',
                title: 'The title',
                subtitle: 'Sub title',
                show_button: false,
                button_text: 'Button',
                button_url: '#'
            };
            this.$parent.base.rooms.items[this.room_index].content.items[this.content_item_index].items.push(default_content);
        },
        openEditor() {
            this.$parent.$emit('close-editors');
            this.edit_opened = true;
        }
    }
};
</script>
