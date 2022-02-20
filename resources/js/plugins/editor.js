import _ from 'lodash';
import Router from './router';

export default {
    getUrlParam(n) {
        const r = new RegExp("(?:[?&]|&)" + n + "=([^&]+)", "i"),
            o = window.location.search.match(r);
        return o && o.length > 1 ? o[1] : null
    },
    returnFileUrl(n) {
        const r = this.getUrlParam("CKEditorFuncNum");
        window.opener.CKEDITOR.tools.callFunction(r, n);
        window.close();
    },
    resetEditor() {
        if (!_.isEmpty(window.CKEDITOR)) {
            window.CKEDITOR.instances = {};
        }
    },
    initEditor(editor, data) {
        if (_.isEmpty(window.CKEDITOR)) {
            console.log('Ckeditor not init');
            return;
        }

        if (_.isEmpty(editor)) {
            console.log('Editor id cannot be null');
            return;
        }

        if (_.isEmpty(data)) {
            data = '';
        }

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const locale = document.querySelector('meta[name="locale"]').getAttribute('content');
        const options = {
            removePlugins: 'magicline, div, find, flash, forms, table, tableselection,' +
                ' tabletools,' +
                ' liststyle',

            extraPlugins: 'wordcount,notification,clipboard,blockquote',
            // filebrowserImageBrowseUrl: Router.route('file.index'),
            filebrowserImageUploadUrl: Router.route('file-manager.anonymous_upload', {editor: 'ckeditor', _token: token}),
            defaultLanguage: locale,
        };

        window.CKEDITOR.CKEDITOR_BASEPATH = window.location.origin

        if (_.isEmpty(window.CKEDITOR.instances) || _.isEmpty(window.CKEDITOR.instances[editor])) {
            window.CKEDITOR.replace(editor, options);
        } else {
            window.CKEDITOR.instances[editor].setData(data);
        }
    },
    getEditorData(editor) {
        if (!_.isEmpty(window.CKEDITOR.instances[editor])) {
            return window.CKEDITOR.instances[editor].getData();
        }
        return '';
    },
};


