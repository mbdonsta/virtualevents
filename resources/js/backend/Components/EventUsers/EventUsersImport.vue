<template>
    <div>
        <div v-if="errors.status !== 403" class="row">
            <div class="col-md-6">
                <div class="mb-10">
                    <label class="form-label" v-text="label_trans"></label>
                    <input
                        :disabled="loading"
                        class="form-control"
                        name="import_file"
                        type="file" @change="handleFileUpload($event)">
                    <div v-if="errors.status === 422 && errors.data.errors && errors.data.errors.import_file"
                         class="invalid-feedback d-block"
                         v-text="errors.data.errors.import_file[0]"></div>
                </div>
            </div>
            <div class="col-12">
                <button id="kt_sign_up_submit" :disabled="loading" class="btn btn-primary" @click="checkFile()">
                    <!--begin::Indicator label-->
                    <span v-if="!loading" class="indicator-label" v-text="button_trans"></span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span v-if="loading" class="indicator-progress d-block">
                    {{ loading_trans }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                    <!--end::Indicator progress-->
                </button>
                <div v-if="results.rows_found > 0" class="">
                    <hr>
                    <div>Import Started...</div>
                    <div>
                        <strong>Rows found: {{ results.rows_found }}</strong>
                    </div>
                    <div v-if="results.finished">
                        <div>
                            <strong>Already exist in event: {{ results.already_exist }}</strong>
                        </div>
                        <div>
                            <strong>Attached to event: {{ results.inserted }}</strong>
                        </div>
                        <div>
                            <strong>Skipped: {{ results.invalid_emails.length }} <span
                                v-if="results.invalid_emails.length">(invalid email addresses. see info
                                below)</span></strong>
                        </div>
                    </div>
                    <div v-if="results.finished" class="">
                        <strong>Import finished</strong>
                        <div v-if="results.invalid_emails.length" class="p-3 border my-3">
                            <strong>Skipped rows:</strong>
                            <table class="table">
                                <tr class="fw-bold">
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                </tr>
                                <tr v-for="item in results.invalid_emails">
                                    <td v-text="item.firstname"></td>
                                    <td v-text="item.lastname"></td>
                                    <td v-text="item.email"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div v-for="(item, index) in results.imports" v-if="!results.finished" :key="index" class="">
                        <p v-text="item"></p>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="errors.status === 403" class="py-5 text-center">
            <h3 v-text="auth_trans"></h3>
        </div>
    </div>
</template>

<script>
const IMPORT_BATCH = 250;
export default {
    props: [
        'label_trans',
        'button_trans',
        'loading_trans',
        'auth_trans',
        'file_check_route',
        'import_users_route'
    ],
    data: function () {
        return {
            loading: false,
            file: '',
            errors: [],
            auth_error: [],
            results: {
                rows_found: 0,
                inserted: 0,
                already_exist: 0,
                invalid_emails: [],
                imported: 0,
                finished: false,
                imports: []
            }
        };
    },
    mounted() {
    },
    methods: {
        handleFileUpload(event) {
            if (this.loading) {
                return false;
            }
            this.file = event.target.files[0];
        },
        checkFile() {
            if (this.loading) {
                return false;
            }

            this.resetResult();
            this.errors = [];
            this.loading = true;
            let formData = new FormData();
            formData.append('import_file', this.file);

            axios.post(
                this.file_check_route,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(resp => {
                this.results.rows_found = resp.data.rows_found;
                this.results.imported = 0;
                this.results.invalid_emails = [];
                this.results.finished = false;
                this.importUsers();
            }).catch(err => {
                this.errors = {
                    status: err.response.status,
                    data: err.response.data
                };
                this.loading = false;
            })
        },
        importUsers() {
            let skip = this.results.imported;
            let formData = new FormData();
            formData.append('import_file', this.file);
            formData.append('skip', skip);
            var importBatch = (this.results.rows_found - this.results.imported) > IMPORT_BATCH ? IMPORT_BATCH : this.results.rows_found - this.results.imported;
            this.results.imports.push('Importing from ' + this.results.imported + ' to ' + (importBatch + this.results.imported));
            axios.post(
                this.import_users_route,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
            ).then(resp => {
                this.results.imported += importBatch;
                this.results.already_exist += resp.data.already_exist;
                this.results.inserted += resp.data.inserted;
                this.results.invalid_emails = this.results.invalid_emails.concat(resp.data.invalid_emails);
                console.log(this.results.invalid_emails);
                if (this.results.imported < this.results.rows_found) {
                    this.importUsers();
                } else {
                    this.results.finished = true;
                    this.loading = false;
                }
            }).catch(err => {
                this.errors = {
                    status: err.response.status,
                    data: err.response.data
                };
                this.loading = false;
            })
        },
        resetResult() {
            this.results = {
                rows_found: 0,
                inserted: 0,
                already_exist: 0,
                imported: 0,
                finished: false,
                imports: []
            };
        }
    }
};
</script>
