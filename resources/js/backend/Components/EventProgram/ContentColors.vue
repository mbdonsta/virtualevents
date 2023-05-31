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
                    <label>Row border color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.row_border_color"
                        class="form-control" type="color">
                </div>
                <hr>
                <h4>Default row type</h4>
                <div class="mb-3">
                    <label>Title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.default.title.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Sub title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.default.subtitle.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button background color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.default.button.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button text color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.default.button.color"
                        class="form-control" type="color">
                </div>
                <hr>
                <h4>Compact row type</h4>
                <div class="mb-3">
                    <label>Title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.title.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Sub title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.subtitle.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Sub item content time color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.sub_item_time.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Sub item content title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.sub_item_title.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Sub item content subtitle color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.sub_item_subtitle.color"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button background color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.button.backgroundColor"
                        class="form-control" type="color">
                </div>
                <div class="mb-3">
                    <label>Button text color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.compact.button.color"
                        class="form-control" type="color">
                </div>
                <hr>
                <h4>Minimal row type</h4>
                <div class="mb-3">
                    <label>Title color</label>
                    <input
                        v-model="$parent.base.styles.content_styles.minimal.title.color"
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
