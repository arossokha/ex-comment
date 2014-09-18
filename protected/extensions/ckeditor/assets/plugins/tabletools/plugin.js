﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    function a(n, o) {
        if (CKEDITOR.env.ie)n.removeAttribute(o); else delete n[o];
    }

    ;
    var b = /^(?:td|th)$/;

    function c(n) {
        var o = n.createBookmarks(), p = n.getRanges(), q = [], r = {};

        function s(A) {
            if (q.length > 0)return;
            if (A.type == CKEDITOR.NODE_ELEMENT && b.test(A.getName()) && !A.getCustomData('selected_cell')) {
                CKEDITOR.dom.element.setMarker(r, A, 'selected_cell', true);
                q.push(A);
            }
        }

        ;
        for (var t = 0; t < p.length; t++) {
            var u = p[t];
            if (u.collapsed) {
                var v = u.getCommonAncestor(), w = v.getAscendant('td', true) || v.getAscendant('th', true);
                if (w)q.push(w);
            } else {
                var x = new CKEDITOR.dom.walker(u), y;
                x.guard = s;
                while (y = x.next()) {
                    var z = y.getParent();
                    if (z && b.test(z.getName()) && !z.getCustomData('selected_cell')) {
                        CKEDITOR.dom.element.setMarker(r, z, 'selected_cell', true);
                        q.push(z);
                    }
                }
            }
        }
        CKEDITOR.dom.element.clearAllMarkers(r);
        n.selectBookmarks(o);
        return q;
    }

    ;
    function d(n) {
        var o = new CKEDITOR.dom.element(n), p = (o.getName() == 'table' ? n : o.getAscendant('table')).$, q = p.rows, r = -1, s = [];
        for (var t = 0; t < q.length; t++) {
            r++;
            if (!s[r])s[r] = [];
            var u = -1;
            for (var v = 0; v < q[t].cells.length; v++) {
                var w = q[t].cells[v];
                u++;
                while (s[r][u])u++;
                var x = isNaN(w.colSpan) ? 1 : w.colSpan, y = isNaN(w.rowSpan) ? 1 : w.rowSpan;
                for (var z = 0; z < y; z++) {
                    if (!s[r + z])s[r + z] = [];
                    for (var A = 0; A < x; A++)s[r + z][u + A] = q[t].cells[v];
                }
                u += x - 1;
            }
        }
        return s;
    }

    ;
    function e(n, o) {
        var p = CKEDITOR.env.ie ? '_cke_rowspan' : 'rowSpan';
        for (var q = 0; q < n.length; q++)for (var r = 0; r < n[q].length; r++) {
            var s = n[q][r];
            if (s.parentNode)s.parentNode.removeChild(s);
            s.colSpan = s[p] = 1;
        }
        var t = 0;
        for (q = 0; q < n.length; q++)for (r = 0; r < n[q].length; r++) {
            s = n[q][r];
            if (!s)continue;
            if (r > t)t = r;
            if (s._cke_colScanned)continue;
            if (n[q][r - 1] == s)s.colSpan++;
            if (n[q][r + 1] != s)s._cke_colScanned = 1;
        }
        for (q = 0; q <= t; q++)for (r = 0; r < n.length; r++) {
            if (!n[r])continue;
            s = n[r][q];
            if (!s || s._cke_rowScanned)continue;
            if (n[r - 1] && n[r - 1][q] == s)s[p]++;
            if (!n[r + 1] || n[r + 1][q] != s)s._cke_rowScanned = 1;
        }
        for (q = 0; q < n.length; q++)for (r = 0; r < n[q].length; r++) {
            s = n[q][r];
            a(s, '_cke_colScanned');
            a(s, '_cke_rowScanned');
        }
        for (q = 0; q < n.length; q++) {
            var u = o.ownerDocument.createElement('tr');
            for (r = 0; r < n[q].length;) {
                s = n[q][r];
                if (n[q - 1] && n[q - 1][r] == s) {
                    r += s.colSpan;
                    continue;
                }
                u.appendChild(s);
                if (p != 'rowSpan') {
                    s.rowSpan = s[p];
                    s.removeAttribute(p);
                }
                r += s.colSpan;
                if (s.colSpan == 1)s.removeAttribute('colSpan');
                if (s.rowSpan == 1)s.removeAttribute('rowSpan');
            }
            if (CKEDITOR.env.ie)o.rows[q].replaceNode(u); else {
                var v = new CKEDITOR.dom.element(o.rows[q]), w = new CKEDITOR.dom.element(u);
                v.setHtml('');
                w.moveChildren(v);
            }
        }
    }

    ;
    function f(n) {
        var o = n.cells;
        for (var p = 0; p < o.length; p++) {
            o[p].innerHTML = '';
            if (!CKEDITOR.env.ie)new CKEDITOR.dom.element(o[p]).appendBogus();
        }
    }

    ;
    function g(n, o) {
        var p = n.getStartElement().getAscendant('tr');
        if (!p)return;
        var q = p.clone(true);
        q.insertBefore(p);
        f(o ? q.$ : p.$);
    }

    ;
    function h(n) {
        if (n instanceof CKEDITOR.dom.selection) {
            var o = c(n), p = [];
            for (var q = 0; q < o.length; q++) {
                var r = o[q].getParent();
                p[r.$.rowIndex] = r;
            }
            for (q = p.length; q >= 0; q--)if (p[q])h(p[q]);
        } else if (n instanceof CKEDITOR.dom.element) {
            var s = n.getAscendant('table');
            if (s.$.rows.length == 1)s.remove(); else n.remove();
        }
    }

    ;
    function i(n, o) {
        var p = n.getStartElement(), q = p.getAscendant('td', true) || p.getAscendant('th', true);
        if (!q)return;
        var r = q.getAscendant('table'), s = q.$.cellIndex;
        for (var t = 0; t < r.$.rows.length; t++) {
            var u = r.$.rows[t];
            if (u.cells.length < s + 1)continue;
            q = new CKEDITOR.dom.element(u.cells[s].cloneNode(false));
            if (!CKEDITOR.env.ie)q.appendBogus();
            var v = new CKEDITOR.dom.element(u.cells[s]);
            if (o)q.insertBefore(v); else q.insertAfter(v);
        }
    }

    ;
    function j(n) {
        if (n instanceof CKEDITOR.dom.selection) {
            var o = c(n);
            for (var p = o.length; p >= 0; p--)if (o[p])j(o[p]);
        } else if (n instanceof CKEDITOR.dom.element) {
            var q = n.getAscendant('table'), r = n.$.cellIndex;
            for (p = q.$.rows.length - 1; p >= 0; p--) {
                var s = new CKEDITOR.dom.element(q.$.rows[p]);
                if (!r && s.$.cells.length == 1) {
                    h(s);
                    continue;
                }
                if (s.$.cells[r])s.$.removeChild(s.$.cells[r]);
            }
        }
    }

    ;
    function k(n, o) {
        var p = n.getStartElement(), q = p.getAscendant('td', true) || p.getAscendant('th', true);
        if (!q)return;
        var r = q.clone();
        if (!CKEDITOR.env.ie)r.appendBogus();
        if (o)r.insertBefore(q); else r.insertAfter(q);
    }

    ;
    function l(n) {
        if (n instanceof CKEDITOR.dom.selection) {
            var o = c(n);
            for (var p = o.length - 1; p >= 0; p--)l(o[p]);
        } else if (n instanceof CKEDITOR.dom.element)if (n.getParent().getChildCount() == 1)n.getParent().remove(); else n.remove();
    }

    ;
    var m = {thead:1, tbody:1, tfoot:1, td:1, tr:1, th:1};
    CKEDITOR.plugins.tabletools = {init:function (n) {
        var o = n.lang.table;
        n.addCommand('cellProperties', new CKEDITOR.dialogCommand('cellProperties'));
        CKEDITOR.dialog.add('cellProperties', this.path + 'dialogs/tableCell.js');
        n.addCommand('tableDelete', {exec:function (p) {
            var q = p.getSelection(), r = q && q.getStartElement(), s = r && r.getAscendant('table', true);
            if (!s)return;
            q.selectElement(s);
            var t = q.getRanges()[0];
            t.collapse();
            q.selectRanges([t]);
            if (s.getParent().getChildCount() == 1)s.getParent().remove(); else s.remove();
        }});
        n.addCommand('rowDelete', {exec:function (p) {
            var q = p.getSelection();
            h(q);
        }});
        n.addCommand('rowInsertBefore', {exec:function (p) {
            var q = p.getSelection();
            g(q, true);
        }});
        n.addCommand('rowInsertAfter', {exec:function (p) {
            var q = p.getSelection();
            g(q);
        }});
        n.addCommand('columnDelete', {exec:function (p) {
            var q = p.getSelection();
            j(q);
        }});
        n.addCommand('columnInsertBefore', {exec:function (p) {
            var q = p.getSelection();
            i(q, true);
        }});
        n.addCommand('columnInsertAfter', {exec:function (p) {
            var q = p.getSelection();
            i(q);
        }});
        n.addCommand('cellDelete', {exec:function (p) {
            var q = p.getSelection();
            l(q);
        }});
        n.addCommand('cellInsertBefore', {exec:function (p) {
            var q = p.getSelection();
            k(q, true);
        }});
        n.addCommand('cellInsertAfter', {exec:function (p) {
            var q = p.getSelection();
            k(q);
        }});
        if (n.addMenuItems)n.addMenuItems({tablecell:{label:o.cell.menu, group:'tablecell', order:1, getItems:function () {
            var p = c(n.getSelection());
            return{tablecell_insertBefore:CKEDITOR.TRISTATE_OFF, tablecell_insertAfter:CKEDITOR.TRISTATE_OFF, tablecell_delete:CKEDITOR.TRISTATE_OFF, tablecell_properties:p.length > 0 ? CKEDITOR.TRISTATE_OFF : CKEDITOR.TRISTATE_DISABLED};
        }}, tablecell_insertBefore:{label:o.cell.insertBefore, group:'tablecell', command:'cellInsertBefore', order:5}, tablecell_insertAfter:{label:o.cell.insertAfter, group:'tablecell', command:'cellInsertAfter', order:10}, tablecell_delete:{label:o.cell.deleteCell, group:'tablecell', command:'cellDelete', order:15}, tablecell_properties:{label:o.cell.title, group:'tablecellproperties', command:'cellProperties', order:20}, tablerow:{label:o.row.menu, group:'tablerow', order:1, getItems:function () {
            return{tablerow_insertBefore:CKEDITOR.TRISTATE_OFF, tablerow_insertAfter:CKEDITOR.TRISTATE_OFF, tablerow_delete:CKEDITOR.TRISTATE_OFF};
        }}, tablerow_insertBefore:{label:o.row.insertBefore, group:'tablerow', command:'rowInsertBefore', order:5}, tablerow_insertAfter:{label:o.row.insertAfter, group:'tablerow', command:'rowInsertAfter', order:10}, tablerow_delete:{label:o.row.deleteRow, group:'tablerow', command:'rowDelete', order:15}, tablecolumn:{label:o.column.menu, group:'tablecolumn', order:1, getItems:function () {
            return{tablecolumn_insertBefore:CKEDITOR.TRISTATE_OFF, tablecolumn_insertAfter:CKEDITOR.TRISTATE_OFF, tablecolumn_delete:CKEDITOR.TRISTATE_OFF};
        }}, tablecolumn_insertBefore:{label:o.column.insertBefore, group:'tablecolumn', command:'columnInsertBefore', order:5}, tablecolumn_insertAfter:{label:o.column.insertAfter, group:'tablecolumn', command:'columnInsertAfter', order:10}, tablecolumn_delete:{label:o.column.deleteColumn, group:'tablecolumn', command:'columnDelete', order:15}});
        if (n.contextMenu)n.contextMenu.addListener(function (p, q) {
            if (!p)return null;
            while (p) {
                if (p.getName() in m)return{tablecell:CKEDITOR.TRISTATE_OFF, tablerow:CKEDITOR.TRISTATE_OFF, tablecolumn:CKEDITOR.TRISTATE_OFF};
                p = p.getParent();
            }
            return null;
        });
    }, getSelectedCells:c};
    CKEDITOR.plugins.add('tabletools', CKEDITOR.plugins.tabletools);
})();
