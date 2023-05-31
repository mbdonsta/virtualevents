<template>
    <div id="eventSchedule" class="pt-0">
        <div class="mb-10">
            <label>Day name</label>
            <input v-model="name" class="form-control" type="text">
            <div v-if="errors.name" class="invalid-feedback d-block" v-text="errors.name[0]"></div>
        </div>
        <div class="schedule-view">
            <div class="day-boxes">
                <div class="day-box">
                    <div class="rooms">
                        <div v-for="(room_item, room_index) in base.rooms.items">
                            <room-button
                                :key="room_index"
                                :room_index="room_index"
                                :room_item="room_item"
                                :rooms_length="base.rooms.items.length"
                                :styles="base.styles.room_btn"
                            ></room-button>
                        </div>
                        <div class="d-inline-block">
                            <button class="btn btn-success" @click="addRoom(base.rooms.items)">+ Add room</button>
                        </div>
                    </div>
                    <div class="room-boxes pt-15">
                        <div
                            v-for="(room_item, room_index) in base.rooms.items"
                            :class="[room_item.opened ? 'opened' : '']"
                            class="room-content">
                            <div class="content-items">
                                <div v-for="(content_item, content_item_index) in room_item.content.items"
                                     class="content-row">
                                    <room-content
                                        :key="content_item.id"
                                        :content_item="content_item"
                                        :content_item_index="content_item_index"
                                        :content_styles="base.styles.content_styles"
                                        :room_index="room_index"
                                        :route="image_upload_route"
                                        :time_col_styles="(content_item_index + 1) % 2 === 0 ? base.styles.content_time_col.even : base.styles.content_time_col.odd"
                                    ></room-content>
                                </div>
                            </div>
                            <div class="add-item">
                                <div
                                    class="btn btn-success"
                                    @click="addContentItem(room_item.content.items)">Add Item
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="sumbit">
                <button
                    id="kt_sign_up_submit"
                    class="btn btn-primary"
                    type="submit"
                    @click="submitProgram()">
                    <!--begin::Indicator label-->
                    <span :class="[loading ? 'd-none' : 'd-block']" class="indicator-label"
                          v-text="submit_trans"></span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span :class="[loading ? 'd-block' : 'd-none']" class="indicator-progress">{{ please_wait_trans }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                    <!--end::Indicator progress-->
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import DayButton from "./DayButton";
import RoomButton from "./RoomButton";
import RoomContent from "./RoomContent";
import DayButtonColors from "./DayButtonColors";
import RoomButtonColors from "./RoomButtonColors";
import TimeColumnColors from "./TimeColumnColors";
import ContentColors from "./ContentColors";

export default {
    components: {
        ContentColors,
        TimeColumnColors,
        RoomButtonColors,
        DayButtonColors,
        RoomContent,
        RoomButton,
        DayButton
    },
    props: [
        'submit_trans',
        'please_wait_trans',
        'submit_route',
        'schedule',
        'image_upload_route',
        'day_name'
    ],
    data: function () {
        return {
            loading: false,
            errors: [],
            edit_opened: false,
            name: this.day_name ? this.day_name : '',
            base: this.schedule ? JSON.parse(this.schedule) : [],
            default_styles: {
                day_btn: {
                    opened: {
                        backgroundColor: '#7239ea',
                        borderColor: '#7239ea',
                        color: '#ffffff'
                    },
                    base: {
                        backgroundColor: '#ffffff',
                        borderColor: '#ffffff',
                        color: '#000000'
                    }
                },
                room_btn: {
                    opened: {
                        backgroundColor: '#7239ea',
                        borderColor: '#7239ea',
                        color: '#ffffff'
                    },
                    base: {
                        backgroundColor: '#ffffff',
                        borderColor: '#ffffff',
                        color: '#000000'
                    }
                },
                content_time_col: {
                    odd: {
                        backgroundColor: '#7239ea',
                        color: '#ffffff',
                    },
                    even: {
                        backgroundColor: '#ffffff',
                        color: '#000000',
                    }
                },
                content_styles: {
                    row_border_color: '#000000',
                    default: {
                        title: {
                            color: '#000000'
                        },
                        subtitle: {
                            color: '#000000'
                        },
                        button: {
                            backgroundColor: '#ffffff',
                            color: '#000000'
                        }
                    },
                    compact: {
                        title: {
                            color: '#000000'
                        },
                        subtitle: {
                            color: '#000000'
                        },
                        button: {
                            backgroundColor: '#ffffff',
                            color: '#000000'
                        },
                        sub_item_time: {
                            color: '#000000'
                        },
                        sub_item_title: {
                            color: '#000000'
                        },
                        sub_item_subtitle: {
                            color: '#000000'
                        }
                    },
                    minimal: {
                        title: {
                            color: '#000000'
                        }
                    }
                }
            }
        };
    },
    created() {
        if (this.base.length < 1) {
            this.setBaseDefaults();
        }
        this.checkDefaultAttributes();
    },
    methods: {
        setBaseDefaults() {
            this.base = {
                styles: this.default_styles,
                rooms: []
            }
            let default_content = {
                enabled: true,
                items: []
            }
            this.addRoom(default_content.items, true);
            this.base.rooms = default_content;
        },
        checkDefaultAttributes() {
            if (!this.base.styles) {
                this.base.styles = this.default_styles;

                return false;
            }

            if (!this.base.styles.day_btn) {
                this.base.styles.day_btn = this.default_styles.day_btn;
            }

            if (!this.base.styles.room_btn) {
                this.base.styles.room_btn = this.default_styles.room_btn;
            }

            if (!this.base.styles.content_time_col) {
                this.base.styles.content_time_col = this.default_styles.content_time_col;
            }

            if (!this.base.styles.content_styles) {
                this.base.styles.content_styles = this.default_styles.content_styles;
            }
        },
        removeDay(index) {
            if (this.base.days.items.length < 2) {
                return false;
            }

            this.base.days.items.splice(index, 1);
            this.closeAllItems(this.base.days.items);
            this.base.days.items[0].opened = true;
        },
        selectDay(index) {
            this.closeAllItems(this.base.days.items);
            this.base.days.items[index].opened = true
        },
        addRoom(items, opened = false) {
            let defaults_content = {
                opened: opened,
                title: 'Room name',
                content: {
                    items: []
                }
            };
            items.push(defaults_content);
        },
        removeRoom(items, index) {
            if (items.length < 2) {
                return false;
            }

            items.splice(index, 1);
            this.closeAllItems(items);
            items[0].opened = true;
        },
        selectRoom(items, index) {
            this.closeAllItems(items);
            items[index].opened = true
        },
        closeAllItems(items) {
            items.forEach((item, i) => {
                item.opened = false;
            });
        },
        addContentItem(items) {
            let default_content = {
                id: Math.floor(Date.now() / 1000),
                type: 'default',
                time: '09:00 - 10:00',
                title: 'Title',
                subtitle: 'Subtitle',
                file_id: 0,
                file_url: '',
                show_button: false,
                button_text: 'Button',
                button_url: '#',
                items: []
            };
            items.push(default_content);
        },
        openEditor() {
            this.edit_opened = true;
        },
        submitProgram() {
            if (this.loading) {
                return false;
            }

            this.loading = true;

            axios.post(this.submit_route, {
                content: JSON.stringify(this.base),
                name: this.name
            }).then(resp => {
                this.loading = false;
                window.location.href = resp.data.redirect;

            }).catch(err => {
                this.errors = err.response.data.errors;
                this.loading = false;
            })
        }
    }
};
</script>
