import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// import { tinymce } from "tinymce";
import 'tinymce';

(function () {
    "use strict";

    const select = (el, all = false) => {
        el = el.trim()
        if (all) {
            return [...document.querySelectorAll(el)]
        } else {
            return document.querySelector(el)
        }
    }

    let streamFormError = select('.stream-form-error');
    if(streamFormError) {

        document.addEventListener("turbo:before-cache", function() {
            document.querySelectorAll(".stream-form-success").forEach(el => el.remove());
            document.querySelectorAll(".stream-form-error > ul").forEach(el => el.remove());
        });
    }

    // let textPost = select('#post-textarea');
    // if(textPost) {

    //     tinymce.init({
    //         selector: '#post-textarea',
    //         // plugins: [ "image", "code", "table", "link", "media", "codesample"],
    //     });
    // }

})();
