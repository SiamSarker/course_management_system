// require('./bootstrap');

import $ from 'jquery';
window.jQuery = $;
window.$ = $;
import 'bootstrap';

var $jq = jQuery.noConflict();
$jq(document).ready(function(){
    $jq('.dropdown').dropdown();
});
