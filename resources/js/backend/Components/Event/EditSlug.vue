<template>
    <div>
        <div :class="[ editing ? 'd-none' : 'd-block' ]">
            <strong v-text="currentUrl + '/watch/' + currentSlug"></strong>
            <a class="btn-link text-decoration-underline" href="#" @click="startSlugEdit($event)">Edit</a>
        </div>
        <div :class="[ editing ? 'd-block' : 'd-none' ]">
            <strong v-text="currentUrl + '/watch/'"></strong>
            <input v-model="currentSlug" name="slug" @keyup="filterInput()">
            <a class="btn-link text-decoration-underline" href="#" @click="endSlugEdit($event)">OK</a>
        </div>
    </div>
</template>

<script>
import latinize from 'latinize';

export default {
    props: [
        'url',
        'slug',
        'is_error'
    ],
    data: function () {
        return {
            editing: false,
            currentUrl: this.url,
            currentSlug: this.slug
        };
    },
    created() {
        if (this.is_error) {
            this.editing = true;
        }
    },
    mounted() {
    },
    methods: {
        startSlugEdit(event) {
            event.preventDefault();
            this.editing = true;
        },
        endSlugEdit(event) {
            event.preventDefault();
            this.editing = false;
        },
        filterInput() {
            this.currentSlug = this.currentSlug
                .replace(/[^\x00-\x7F]/g, (char) => {
                    return latinize(char); // replace non-Latin characters with Latin equivalents
                })
                .replace(/[^a-zA-Z0-9-\s]/g, '') // remove non-alphanumeric characters except spaces and hyphens
                .replace(/--+/g, '-')
                .replace(/\s+/g, '-')
                .replace(/^\-+|\-+$/g, '')
                .toLowerCase();
            console.log('filtered');
        }
    }
};
</script>
