<template>
    <div class="d-inline-block ms-5">
        <button class="btn btn-sm btn-primary" @click="openEditor()">Change colors</button>
        <div v-if="edit_opened" class="sidebar-edit">
            <div class="sidebar-title">
                <h3>Edit</h3>
                <button class="close-sidebar" @click="edit_opened = false">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="edit-form">
                <div class="mb-3">
                    <label>Button background</label>
                    <input
                        v-model="$parent.base.styles.room_btn.base.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button border color</label>
                    <input
                        v-model="$parent.base.styles.room_btn.base.borderColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button text color</label>
                    <input
                        v-model="$parent.base.styles.room_btn.base.color"
                        class="form-control" type="color">
                </div>
                <hr>
                <div class="mb-3">
                    <label>Active button background</label>
                    <input
                        v-model="$parent.base.styles.room_btn.opened.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Active button border color</label>
                    <input
                        v-model="$parent.base.styles.room_btn.opened.borderColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Active button text color</label>
                    <input
                        v-model="$parent.base.styles.room_btn.opened.color"
                        class="form-control" type="color">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [],
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
        }
    }
};
</script>
