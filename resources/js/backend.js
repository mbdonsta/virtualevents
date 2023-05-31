import './bootstrap';
import './vendors/draggable.bundle';
import 'daterangepicker';
import 'select2';
import './backend/custom-scripts';

window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component("event-users-import", require("./backend/Components/EventUsers/EventUsersImport.vue").default);
Vue.component("event-program-base", require("./backend/Components/EventProgram/Base.vue").default);
Vue.component("image-upload", require("./Global/ImageUpload.vue").default);
Vue.component("event-room-banners", require("./backend/Components/EventRoom/EventRoomBanners.vue").default);
Vue.component("edit-slug", require("./backend/Components/Event/EditSlug.vue").default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});
