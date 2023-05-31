<template>
    <div
        :class="[day_item.opened ? 'opened' : '']"
        class="me-3 action-buttons-holder">
        <div class="action-buttons">
            <button
                class="day-button-actions action-btn edit-item"
                @click="openEditor()"
            >
                <i class="las la-pen"></i>
            </button>
            <button
                v-if="days_length > 1"
                class="day-button-actions action-btn remove-item"
                @click="removeDay(day_index)">
                <i class="las la-times"></i>
            </button>
        </div>
        <button
            :style="generateStyle()"
            class="day-button-actions tab-btn"
            @click="selectDay(day_index)"
            v-text="day_item.title"></button>
        <div v-if="edit_opened" class="sidebar-edit">
            <div class="sidebar-title">
                <h3>Edit {{ day_item.title }}</h3>
                <button class="close-sidebar" @click="edit_opened = false">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="edit-form">
                <div class="mb-3">
                    <label>Day label</label>
                    <input v-model="$parent.base.days.items[day_index].title" class="form-control" type="text">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'day_item',
        'day_index',
        'days_length',
        'styles'
    ],
    data: function () {
        return {
            edit_opened: false,
            style: ''
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
        selectDay(day_index) {
            this.$parent.$emit('close-editors');
            this.$parent.selectDay(day_index);
        },
        removeDay(day_index) {
            this.$parent.removeDay(day_index);
        },
        generateStyle() {
            if (this.day_item.opened) {
                return this.styles.opened;
            }

            return this.styles.base;
        }
    }
};
</script>
