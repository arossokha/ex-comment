﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.dialog.add('anchor', function (a) {
    var b = function (c, d, e) {
        var g = this;
        g.editMode = true;
        g.editObj = e;
        var f = g.editObj.getAttribute('name');
        if (f)g.setValueOf('info', 'txtName', f); else g.setValueOf('info', 'txtName', '');
    };
    return{title:a.lang.anchor.title, minWidth:300, minHeight:60, onOk:function () {
        var f = this;
        var c = f.getValueOf('info', 'txtName'), d = CKEDITOR.env.ie ? a.document.createElement('<a name="' + CKEDITOR.tools.htmlEncode(c) + '">') : a.document.createElement('a');
        if (f.editMode) {
            f.editObj.copyAttributes(d, {name:1});
            f.editObj.moveChildren(d);
        }
        d.removeAttribute('_cke_saved_name');
        d.setAttribute('name', c);
        var e = a.createFakeElement(d, 'cke_anchor', 'anchor');
        if (!f.editMode)a.insertElement(e); else {
            e.replace(f.fakeObj);
            a.getSelection().selectElement(e);
        }
        return true;
    }, onShow:function () {
        var e = this;
        e.editObj = false;
        e.fakeObj = false;
        e.editMode = false;
        var c = a.getSelection(), d = c.getSelectedElement();
        if (d && d.getAttribute('_cke_real_element_type') && d.getAttribute('_cke_real_element_type') == 'anchor') {
            e.fakeObj = d;
            d = a.restoreRealElement(e.fakeObj);
            b.apply(e, [a, c, d]);
            c.selectElement(e.fakeObj);
        }
        e.getContentElement('info', 'txtName').focus();
    }, contents:[
        {id:'info', label:a.lang.anchor.title, accessKey:'I', elements:[
            {type:'text', id:'txtName', label:a.lang.anchor.name, validate:function () {
                if (!this.getValue()) {
                    alert(a.lang.anchor.errorName);
                    return false;
                }
                return true;
            }}
        ]}
    ]};
});
