<template>
    <div class="d-inline-block">
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
                    <label>Odd row background</label>
                    <input
                        v-model="$parent.base.styles.content_time_col.odd.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Odd row text color</label>
                    <input
                        v-model="$parent.base.styles.content_time_col.odd.color"
                        class="form-control" type="color">
                </div>
                <hr>
                <div class="mb-3">
                    <label>Even row background</label>
                    <input
                        v-model="$parent.base.styles.content_time_col.even.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Even row text color</label>
                    <input
                        v-model="$parent.base.styles.content_time_col.even.color"
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
