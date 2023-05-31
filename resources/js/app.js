// require('./bootstrap');

import $ from 'jquery';
window.jQuery = $;
window.$ = $;
import 'bootstrap';

$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});
