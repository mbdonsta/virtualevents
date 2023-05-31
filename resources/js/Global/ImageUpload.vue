<template>
    <div>
        <div :class="{ 'opacity-50': loading, 'file-upload-box': upload_type === 'file' }"
             class="js-image-upload image-upload-box">
            <input :disabled="loading" accept=".jpg, .png, .pdf" name="file" type="file"
                   @change="handleFileUpload($event)">
            <input :name="field_name" :value="current_file_id" type="hidden">
            <input :name="field_url_name" :value="current_file_url" type="hidden">
            <input :name="field_filename" :value="current_filename" type="hidden">
            <div v-if="upload_type !== 'file'" :class="{ 'fit': fit }" class="image-box">
                <span v-if="!current_file_id || !current_file_url" class="svg-icon svg-icon-muted svg-icon-5hx">
                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
                            fill="currentColor"
                            opacity="0.3"/>
                        <path
                            d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
                            fill="currentColor"/>
                    </svg>
                </span>
                <img v-if="current_file_url && current_file_id" :src="current_file_url">
            </div>
            <div v-if="upload_type === 'file'" class="file-upload-wrap form-control">
                <span>Upload file</span>
                <span v-if="current_filename" v-text="current_filename"></span>
            </div>
            <a v-if="current_file_id" class="remove" href="#" @click="removeBanner($event)">
                <span class="svg-icon svg-icon-muted">
                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6 19.7C5.7 19.7 5.5 19.6 5.3 19.4C4.9 19 4.9 18.4 5.3 18L18 5.3C18.4 4.9 19 4.9 19.4 5.3C19.8 5.7 19.8 6.29999 19.4 6.69999L6.7 19.4C6.5 19.6 6.3 19.7 6 19.7Z"
                            fill="currentColor"
                            opacity="1"/>
                        <path
                            d="M18.8 19.7C18.5 19.7 18.3 19.6 18.1 19.4L5.40001 6.69999C5.00001 6.29999 5.00001 5.7 5.40001 5.3C5.80001 4.9 6.40001 4.9 6.80001 5.3L19.5 18C19.9 18.4 19.9 19 19.5 19.4C19.3 19.6 19 19.7 18.8 19.7Z"
                            fill="currentColor"/>
                    </svg>
                </span>
            </a>
        </div>
        <div v-if="errors.status === 422 && errors.data.errors && errors.data.errors.file"
             class="invalid-feedback d-block"
             v-text="errors.data.errors.file[0]"></div>
    </div>
</template>

<script>
export default {
    props: [
        'upload_type',
        'route',
        'file_id',
        'file_url',
        'filename',
        'fit',
        'field_name',
        'field_url_name',
        'field_filename',
    ],
    data: function () {
        return {
            current_file_id: this.file_id ? parseInt(this.file_id) : '',
            current_file_url: this.file_url,
            current_filename: this.filename,
            loading: false,
            errors: []
        };
    },
    mounted() {
    },
    methods: {
        handleFileUpload(event) {
            if (this.loading) {
                return false;
            }
            this.errors = [];
            this.file = event.target.files[0];
            let formData = new FormData();
            formData.append('file', this.file);

            axios.post(
                this.route,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(resp => {
                this.current_file_id = resp.data.file_id;
                this.current_file_url = resp.data.url;
                this.current_filename = resp.data.name;
                let event_vars = {
                    file_id: this.current_file_id,
                    file_url: this.current_file_url,
                    filename: this.current_filename
                }
                this.$emit('imageUploaded', event_vars);
            }).catch(err => {
                console.log(err);
                this.errors = {
                    status: err.response.status,
                    data: err.response.data
                };
                this.loading = false;
            })
        },
        removeBanner(event) {
            event.preventDefault();
            this.current_file_id = '';
            this.current_file_url = '';
            this.current_filename = '';
            let event_vars = {
                file_id: this.current_file_id,
                file_url: this.current_file_url,
                filename: this.current_filename
            }
            this.$emit('imageUploaded', event_vars);
        }
    }
};
</script>
