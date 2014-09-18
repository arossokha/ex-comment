﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    CKEDITOR.plugins.add('undo', {requires:['selection', 'wysiwygarea'], init:function (c) {
        var d = new b(c), e = c.addCommand('undo', {exec:function () {
            if (d.undo()) {
                c.selectionChange();
                this.fire('afterUndo');
            }
        }, state:CKEDITOR.TRISTATE_DISABLED, canUndo:false}), f = c.addCommand('redo', {exec:function () {
            if (d.redo()) {
                c.selectionChange();
                this.fire('afterRedo');
            }
        }, state:CKEDITOR.TRISTATE_DISABLED, canUndo:false});
        d.onChange = function () {
            e.setState(d.undoable() ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED);
            f.setState(d.redoable() ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED);
        };
        function g(h) {
            if (d.enabled && h.data.command.canUndo !== false)d.save();
        }

        ;
        c.on('beforeCommandExec', g);
        c.on('afterCommandExec', g);
        c.on('saveSnapshot', function () {
            d.save();
        });
        c.on('contentDom', function () {
            c.document.on('keydown', function (h) {
                if (!h.data.$.ctrlKey && !h.data.$.metaKey)d.type(h);
            });
        });
        c.on('beforeModeUnload', function () {
            c.mode == 'wysiwyg' && d.save(true);
        });
        c.on('mode', function () {
            d.enabled = c.mode == 'wysiwyg';
            d.onChange();
        });
        c.ui.addButton('Undo', {label:c.lang.undo, command:'undo'});
        c.ui.addButton('Redo', {label:c.lang.redo, command:'redo'});
        c.resetUndo = function () {
            d.reset();
            c.fire('saveSnapshot');
        };
    }});
    function a(c) {
        var e = this;
        var d = c.getSelection();
        e.contents = c.getSnapshot();
        e.bookmarks = d && d.createBookmarks2(true);
        if (CKEDITOR.env.ie)e.contents = e.contents.replace(/\s+_cke_expando=".*?"/g, '');
    }

    ;
    a.prototype = {equals:function (c, d) {
        if (this.contents != c.contents)return false;
        if (d)return true;
        var e = this.bookmarks, f = c.bookmarks;
        if (e || f) {
            if (!e || !f || e.length != f.length)return false;
            for (var g = 0; g < e.length; g++) {
                var h = e[g], i = f[g];
                if (h.startOffset != i.startOffset || h.endOffset != i.endOffset || !CKEDITOR.tools.arrayCompare(h.start, i.start) || !CKEDITOR.tools.arrayCompare(h.end, i.end))return false;
            }
        }
        return true;
    }};
    function b(c) {
        this.editor = c;
        this.reset();
    }

    ;
    b.prototype = {type:function (c) {
        var d = c && c.data.getKeystroke(), e = {8:1, 46:1}, f = d in e, g = this.lastKeystroke in e, h = f && d == this.lastKeystroke, i = {37:1, 38:1, 39:1, 40:1}, j = d in i, k = this.lastKeystroke in i, l = !f && !j, m = f && !h, n = !this.typing || l && (g || k);
        if (n || m) {
            var o = new a(this.editor);
            CKEDITOR.tools.setTimeout(function () {
                var q = this;
                var p = q.editor.getSnapshot();
                if (CKEDITOR.env.ie)p = p.replace(/\s+_cke_expando=".*?"/g, '');
                if (o.contents != p) {
                    if (!q.save(false, o, false))q.snapshots.splice(q.index + 1, q.snapshots.length - q.index - 1);
                    q.hasUndo = true;
                    q.hasRedo = false;
                    q.typesCount = 1;
                    q.modifiersCount = 1;
                    q.onChange();
                }
            }, 0, this);
        }
        this.lastKeystroke = d;
        if (f) {
            this.typesCount = 0;
            this.modifiersCount++;
            if (this.modifiersCount > 25) {
                this.save();
                this.modifiersCount = 1;
            }
        } else if (!j) {
            this.modifiersCount = 0;
            this.typesCount++;
            if (this.typesCount > 25) {
                this.save();
                this.typesCount = 1;
            }
        }
        this.typing = true;
    }, reset:function () {
        var c = this;
        c.lastKeystroke = 0;
        c.snapshots = [];
        c.index = -1;
        c.limit = c.editor.config.undoStackSize;
        c.currentImage = null;
        c.hasUndo = false;
        c.hasRedo = false;
        c.resetType();
    }, resetType:function () {
        var c = this;
        c.typing = false;
        delete c.lastKeystroke;
        c.typesCount = 0;
        c.modifiersCount = 0;
    }, fireChange:function () {
        var c = this;
        c.hasUndo = !!c.getNextImage(true);
        c.hasRedo = !!c.getNextImage(false);
        c.resetType();
        c.onChange();
    }, save:function (c, d, e) {
        var g = this;
        var f = g.snapshots;
        if (!d)d = new a(g.editor);
        if (g.currentImage && d.equals(g.currentImage, c))return false;
        f.splice(g.index + 1, f.length - g.index - 1);
        if (f.length == g.limit)f.shift();
        g.index = f.push(d) - 1;
        g.currentImage = d;
        if (e !== false)g.fireChange();
        return true;
    }, restoreImage:function (c) {
        var e = this;
        e.editor.loadSnapshot(c.contents);
        if (c.bookmarks)e.editor.getSelection().selectBookmarks(c.bookmarks); else if (CKEDITOR.env.ie) {
            var d = e.editor.document.getBody().$.createTextRange();
            d.collapse(true);
            d.select();
        }
        e.index = c.index;
        e.currentImage = c;
        e.fireChange();
    }, getNextImage:function (c) {
        var h = this;
        var d = h.snapshots, e = h.currentImage, f, g;
        if (e)if (c)for (g = h.index - 1; g >= 0; g--) {
            f = d[g];
            if (!e.equals(f, true)) {
                f.index = g;
                return f;
            }
        } else for (g = h.index + 1; g < d.length; g++) {
            f = d[g];
            if (!e.equals(f, true)) {
                f.index = g;
                return f;
            }
        }
        return null;
    }, redoable:function () {
        return this.enabled && this.hasRedo;
    }, undoable:function () {
        return this.enabled && this.hasUndo;
    }, undo:function () {
        var d = this;
        if (d.undoable()) {
            d.save(true);
            var c = d.getNextImage(true);
            if (c)return d.restoreImage(c), true;
        }
        return false;
    }, redo:function () {
        var d = this;
        if (d.redoable()) {
            d.save(true);
            if (d.redoable()) {
                var c = d.getNextImage(false);
                if (c)return d.restoreImage(c), true;
            }
        }
        return false;
    }};
})();
CKEDITOR.config.undoStackSize = 20;