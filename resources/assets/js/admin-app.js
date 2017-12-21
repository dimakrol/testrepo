import Popper from 'popper.js/dist/umd/popper.js';
import moment from 'moment';
import Croppie from 'croppie'
import 'select2/dist/js/select2.full';
import 'jquery-ui/ui/widgets/sortable'

window.moment = moment;
window.Croppie = Croppie;
window.Popper = Popper;


window._ = require('lodash');
/**
 * js lib for bootstrap
 */
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
    require( 'datatables.net' )( window, $ );
    require( 'datatables.net-bs4' )( $ );
} catch (e) {}

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

