﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add('removeformat', {requires:['selection'], init:function (a) {
    a.addCommand('removeFormat', CKEDITOR.plugins.removeformat.commands.removeformat);
    a.ui.addButton('RemoveFormat', {label:a.lang.removeFormat, command:'removeFormat'});
}});
CKEDITOR.plugins.removeformat = {commands:{removeformat:{exec:function (a) {
    var b = a._.removeFormatRegex || (a._.removeFormatRegex = new RegExp('^(?:' + a.config.removeFormatTags.replace(/,/g, '|') + ')$', 'i')), c = a._.removeAttributes || (a._.removeAttributes = a.config.removeFormatAttributes.split(',')), d = a.getSelection().getRanges();
    for (var e = 0, f; f = d[e]; e++) {
        if (f.collapsed)continue;
        f.enlarge(CKEDITOR.ENLARGE_ELEMENT);
        var g = f.createBookmark(), h = g.startNode, i = g.endNode, j = function (m) {
            var n = new CKEDITOR.dom.elementPath(m), o = n.elements;
            for (var p = 1, q; q = o[p]; p++) {
                if (q.equals(n.block) || q.equals(n.blockLimit))break;
                if (b.test(q.getName()))m.breakParent(q);
            }
        };
        j(h);
        j(i);
        var k = h.getNextSourceNode(true, CKEDITOR.NODE_ELEMENT);
        while (k) {
            if (k.equals(i))break;
            var l = k.getNextSourceNode(false, CKEDITOR.NODE_ELEMENT);
            if (k.getName() != 'img' || !k.getAttribute('_cke_protected_html'))if (b.test(k.getName()))k.remove(true); else k.removeAttributes(c);
            k = l;
        }
        f.moveToBookmark(g);
    }
    a.getSelection().selectRanges(d);
}}}};
CKEDITOR.config.removeFormatTags = 'b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var';
CKEDITOR.config.removeFormatAttributes = 'class,style,lang,width,height,align,hspace,valign';