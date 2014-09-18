﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add('panelbutton', {requires:['button'], beforeInit:function (a) {
    a.ui.addHandler(CKEDITOR.UI_PANELBUTTON, CKEDITOR.ui.panelButton.handler);
}});
CKEDITOR.UI_PANELBUTTON = 4;
(function () {
    var a = function (b) {
        var d = this;
        var c = d._;
        if (c.state == CKEDITOR.TRISTATE_DISABLED)return;
        d.createPanel(b);
        if (c.on) {
            c.panel.hide();
            return;
        }
        c.panel.showBlock(d._.id, d.document.getById(d._.id), 4);
    };
    CKEDITOR.ui.panelButton = CKEDITOR.tools.createClass({base:CKEDITOR.ui.button, $:function (b) {
        var d = this;
        var c = b.panel;
        delete b.panel;
        d.base(b);
        d.document = c && c.parent && c.parent.getDocument() || CKEDITOR.document;
        d.hasArrow = true;
        d.click = a;
        d._ = {panelDefinition:c};
    }, statics:{handler:{create:function (b) {
        return new CKEDITOR.ui.panelButton(b);
    }}}, proto:{createPanel:function (b) {
        var c = this._;
        if (c.panel)return;
        var d = this._.panelDefinition || {}, e = d.parent || CKEDITOR.document.getBody(), f = this._.panel = new CKEDITOR.ui.floatPanel(b, e, d), g = this;
        f.onShow = function () {
            if (g.className)this.element.getFirst().addClass(g.className + '_panel');
            c.oldState = g._.state;
            g.setState(CKEDITOR.TRISTATE_ON);
            c.on = 1;
            if (g.onOpen)g.onOpen();
        };
        f.onHide = function () {
            if (g.className)this.element.getFirst().removeClass(g.className + '_panel');
            g.setState(c.oldState);
            c.on = 0;
            if (g.onClose)g.onClose();
        };
        f.onEscape = function () {
            f.hide();
            g.document.getById(c.id).focus();
        };
        if (this.onBlock)this.onBlock(f, c.id);
        f.getBlock(c.id).onHide = function () {
            c.on = 0;
            g.setState(CKEDITOR.TRISTATE_OFF);
        };
    }}});
})();