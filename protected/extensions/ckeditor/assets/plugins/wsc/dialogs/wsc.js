﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.dialog.add('checkspell', function (a) {
    var b = CKEDITOR.tools.getNextNumber(), c = 'cke_frame_' + b, d = 'cke_data_' + b, e = 'cke_error_' + b, f, g = document.location.protocol || 'http:', h = a.lang.spellCheck.notAvailable, i = '<textarea style="display: none" id="' + d + '"' + ' rows="10"' + ' cols="40">' + ' </textarea><div' + ' id="' + e + '"' + ' style="display:none;color:red;font-size:16px;font-weight:bold;padding-top:160px;text-align:center;z-index:11;">' + '</div><iframe' + ' src=""' + ' style="width:485px;background-color:#f1f1e3;height:380px"' + ' frameborder="0"' + ' name="' + c + '"' + ' id="' + c + '"' + ' allowtransparency="1">' + '</iframe>', j = a.config.wsc_customLoaderScript || g + '//loader.spellchecker.net/sproxy_fck/sproxy.php' + '?plugin=fck2' + '&customerid=' + a.config.wsc_customerId + '&cmd=script&doc=wsc&schema=22';
    if (a.config.wsc_customLoaderScript)h += '<p style="color:#000;font-size:11px;font-weight: normal;text-align:center;padding-top:10px">' + a.lang.spellCheck.errorLoading.replace(/%s/g, a.config.wsc_customLoaderScript) + '</p>';
    function k(m, n) {
        var o = 0;
        return function () {
            if (typeof window.doSpell == 'function') {
                if (typeof f != 'undefined')window.clearInterval(f);
                l(m);
            } else if (o++ == 180)window._cancelOnError(n);
        };
    }

    ;
    window._cancelOnError = function (m) {
        if (typeof window.WSC_Error == 'undefined') {
            CKEDITOR.document.getById(c).setStyle('display', 'none');
            var n = CKEDITOR.document.getById(e);
            n.setStyle('display', 'block');
            n.setHtml(m || a.lang.spellCheck.notAvailable);
        }
    };
    function l(m) {
        var n = new window._SP_FCK_LangCompare(), o = CKEDITOR.getUrl(a.plugins.wsc.path + 'dialogs/'), p = o + 'tmpFrameset.html';
        window.gFCKPluginName = 'wsc';
        n.setDefaulLangCode(a.config.defaultLanguage);
        window.doSpell({ctrl:d, lang:n.getSPLangCode(a.langCode), winType:c, onCancel:function () {
            m.hide();
        }, onFinish:function (q) {
            a.focus();
            m.getParentEditor().setData(q.value);
            m.hide();
        }, staticFrame:p, framesetPath:p, iframePath:o + 'ciframe.html', schemaURI:o + 'wsc.css'});
        CKEDITOR.document.getById(e).setStyle('display', 'none');
        CKEDITOR.document.getById(c).setStyle('display', 'block');
    }

    ;
    return{title:a.lang.spellCheck.title, minWidth:485, minHeight:380, buttons:[CKEDITOR.dialog.cancelButton], onShow:function () {
        var m = this.getContentElement('general', 'content').getElement();
        m.setHtml(i);
        if (typeof window.doSpell != 'function')CKEDITOR.document.getHead().append(CKEDITOR.document.createElement('script', {attributes:{type:'text/javascript', src:j}}));
        var n = a.getData();
        CKEDITOR.document.getById(d).setValue(n);
        f = window.setInterval(k(this, h), 250);
    }, onHide:function () {
        window.ooo = undefined;
        window.int_framsetLoaded = undefined;
        window.framesetLoaded = undefined;
        window.is_window_opened = false;
    }, contents:[
        {id:'general', label:a.lang.spellCheck.title, padding:0, elements:[
            {type:'html', id:'content', style:'width:485;height:380px', html:'<div></div>'}
        ]}
    ]};
});
