/* PrismJS 1.29.0 - Core + Markup, CSS, C-like, JS, PHP, SQL */
var _self = "undefined" != typeof window ? window : "undefined" != typeof WorkerGlobalScope && self instanceof WorkerGlobalScope ? self : {},
    Prism = function(e) {
        var n = /(?:^|\s)lang(?:uage)?-([\w-]+)(?=\s|$)/i,
            t = 0,
            r = {},
            a = {
                manual: e.Prism && e.Prism.manual,
                disableWorkerMessageHandler: e.Prism && e.Prism.disableWorkerMessageHandler,
                util: {
                    encode: function e(n) {
                        return n instanceof i ? new i(n.type, e(n.content), n.alias) : Array.isArray(n) ? n.map(e) : n.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/\u00a0/g, " ")
                    },
                    type: function(e) {
                        return Object.prototype.toString.call(e).slice(8, -1)
                    },
                    objId: function(e) {
                        return e.__id || Object.defineProperty(e, "__id", { value: ++t }), e.__id
                    },
                    clone: function e(n, t) {
                        var r, i;
                        switch (t = t || {}, a.util.type(n)) {
                            case "Object":
                                if (i = a.util.objId(n), t[i]) return t[i];
                                for (var l in r = {}, t[i] = r, n) n.hasOwnProperty(l) && (r[l] = e(n[l], t));
                                return r;
                            case "Array":
                                return i = a.util.objId(n), t[i] ? t[i] : (r = [], t[i] = r, n.forEach((function(n, a) { r[a] = e(n, t) })), r);
                            default:
                                return n
                        }
                    },
                    getLanguage: function(e) {
                        for (; e;) {
                            var t = n.exec(e.className);
                            if (t) return t[1].toLowerCase();
                            e = e.parentElement
                        }
                        return "none"
                    },
                    currentScript: function() {
                        if ("undefined" == typeof document) return null;
                        if ("currentScript" in document) return document.currentScript;
                        try { throw new Error } catch (r) {
                            var e = (/at [^(\r\n]*\((.*):.+:.+\)$/gi.exec(r.stack) || [])[1];
                            if (e) {
                                var n = document.getElementsByTagName("script");
                                for (var t in n) if (n[t].src == e) return n[t]
                            }
                            return null
                        }
                    },
                    isActive: function(e, n, t) {
                        for (var r = "no-" + n; e;) {
                            var a = e.classList;
                            if (a.contains(n)) return !0;
                            if (a.contains(r)) return !1;
                            e = e.parentElement
                        }
                        return !!t
                    }
                },
                languages: {
                    plain: r,
                    plaintext: r,
                    text: r,
                    txt: r,
                    extend: function(e, n) {
                        var t = a.util.clone(a.languages[e]);
                        for (var r in n) t[r] = n[r];
                        return t
                    },
                    insertBefore: function(e, n, t, r) {
                        var i = (r = r || a.languages)[e], l = {};
                        for (var o in i) if (i.hasOwnProperty(o)) {
                            if (o == n) for (var s in t) t.hasOwnProperty(s) && (l[s] = t[s]);
                            t.hasOwnProperty(o) || (l[o] = i[o])
                        }
                        var u = r[e];
                        return r[e] = l, a.languages.DFS(a.languages, (function(n, t) {
                            t === u && n != e && (this[n] = l)
                        })), l
                    },
                    DFS: function e(n, t, r, i) {
                        i = i || {};
                        var l = a.util.objId;
                        for (var o in n) if (n.hasOwnProperty(o)) {
                            t.call(n, o, n[o], r || o);
                            var s = n[o], u = a.util.type(s);
                            "Object" !== u || i[l(s)] ? "Array" !== u || i[l(s)] || (i[l(s)] = !0, e(s, t, o, i)) : (i[l(s)] = !0, e(s, t, null, i))
                        }
                    }
                },
                plugins: {},
                highlightAll: function(e, n) {
                    a.highlightAllUnder(document, e, n)
                },
                highlightAllUnder: function(e, n, t) {
                    var r = { callback: t, container: e, selector: 'code[class*="language-"], [class*="language-"] code, code[class*="lang-"], [class*="lang-"] code' };
                    a.hooks.run("before-highlightall", r), r.elements = Array.prototype.slice.apply(r.container.querySelectorAll(r.selector)), a.hooks.run("before-all-elements-highlight", r);
                    for (var i, l = 0; i = r.elements[l++];) a.highlightElement(i, !0 === n, r.callback)
                },
                highlightElement: function(n, t, r) {
                    var i = a.util.getLanguage(n), l = a.languages[i];
                    a.util.setLanguage(n, i);
                    var o;
                    n.parentElement && "pre" === n.parentElement.nodeName.toLowerCase() && (o = n.parentElement);
                    var s = { element: n, language: i, grammar: l, code: n.textContent };
                    function u(e) {
                        s.highlightedCode = e, a.hooks.run("before-insert", s), s.element.innerHTML = s.highlightedCode, a.hooks.run("after-highlight", s), a.hooks.run("complete", s), r && r.call(s.element)
                    }
                    if (a.hooks.run("before-sanity-check", s), (o = s.element.parentElement) && "pre" === o.nodeName.toLowerCase() && !o.hasAttribute("tabindex") && o.setAttribute("tabindex", "0"), !s.code) return a.hooks.run("complete", s), void(r && r.call(s.element));
                    if (a.hooks.run("before-highlight", s), s.grammar)
                        u(a.highlight(s.code, s.grammar, s.language));
                    else u(a.util.encode(s.code))
                },
                highlight: function(e, n, t) {
                    var r = { code: e, grammar: n, language: t };
                    if (a.hooks.run("before-tokenize", r), !r.grammar) throw new Error('Grammar not found: "' + r.language + '"');
                    return r.tokens = a.tokenize(r.code, r.grammar), a.hooks.run("after-tokenize", r), i.stringify(a.util.encode(r.tokens), r.language)
                },
                tokenize: function(e, n) {
                    var t = n.rest;
                    if (t) {
                        for (var r in t) n[r] = t[r];
                        delete n.rest
                    }
                    var a = new s;
                    return u(a, a.head, e), c(e, a, n, a.head, 0), function(e) {
                        var n = [], t = e.head.next;
                        for (; t !== e.tail;) n.push(t.value), t = t.next;
                        return n
                    }(a)
                },
                hooks: {
                    all: {},
                    add: function(e, n) {
                        var t = a.hooks.all;
                        t[e] = t[e] || [], t[e].push(n)
                    },
                    run: function(e, n) {
                        var t = a.hooks.all[e];
                        if (t && t.length) for (var r, i = 0; r = t[i++];) r(n)
                    }
                },
                Token: i
            };
        function i(e, n, t, r) {
            this.type = e, this.content = n, this.alias = t, this.length = 0 | (r || "").length
        }
        function l(e, n, t, r) {
            e.lastIndex = n;
            var a = e.exec(t);
            if (a && r && a.index == n) {
                var i = a[0].length - 1;
                a.index += i, a[0] = a[0].slice(i)
            }
            return a
        }
        function o(e, n, t, r, o, d) {
            for (var g in t) if (t.hasOwnProperty(g) && t[g]) {
                var p = t[g];
                p = Array.isArray(p) ? p : [p];
                for (var b = 0; b < p.length; ++b) {
                    if (d && d.cause == g + "," + b) return;
                    var m = p[b], y = m.inside, h = !!m.lookbehind, v = !!m.greedy, k = m.alias;
                    if (v && !m.pattern.global) {
                        var w = m.pattern.toString().match(/[imsuy]*$/)[0];
                        m.pattern = RegExp(m.pattern.source, w + "g")
                    }
                    for (var x = m.pattern || m, F = r.next, A = o; F !== e.tail; A += F.value.length, F = F.next) {
                        if (d && A >= d.reach) return;
                        var $ = F.value;
                        if (e.length > n.length) return;
                        if (!($ instanceof i)) {
                            var j, C = 1;
                            if (v) {
                                if (!(j = l(x, A, n, h)) || j.index >= n.length) break;
                                var P = j.index, E = j.index + j[0].length, N = A;
                                for (N += F.value.length; P >= N;) N += (F = F.next).value.length;
                                if (A = N -= F.value.length, F.value instanceof i) continue;
                                for (var S = F; S !== e.tail && (N < E || "string" == typeof S.value); S = S.next) C++, N += S.value.length;
                                C--, $ = n.slice(A, N), j.index -= A
                            } else if (!(j = l(x, 0, $, h))) continue;
                            P = j.index;
                            var T = j[0], O = $.slice(0, P), L = $.slice(P + T.length), z = A + $.length;
                            d && z > d.reach && (d.reach = z);
                            var I = F.prev;
                            if (O && (I = u(e, I, O), A += O.length), s(e, I, C), F = u(e, I, new i(g, y ? a.tokenize(T, y) : T, k, T)), L && u(e, F, L), 1 < C) {
                                var B = { cause: g + "," + b, reach: z };
                                c(n, e, t, F.prev, A, B), d && B.reach > d.reach && (d.reach = B.reach)
                            }
                        }
                    }
                }
            }
        }
        function s() {
            var e = { value: null, prev: null, next: null }, n = { value: null, prev: e, next: null };
            e.next = n, this.head = e, this.tail = n, this.length = 0
        }
        function u(e, n, t) {
            var r = n.next, a = { value: t, prev: n, next: r };
            return n.next = a, r.prev = a, e.length++, a
        }
        function c(e, n, t, r, a, i) {
            var l = r.next, s = a;
            for (; l !== n.tail;) {
                if (i && s >= i.reach) return;
                if ("string" == typeof l.value) o(n, e, t, l, s, i);
                s += l.value.length, l = l.next
            }
        }
        return a.util.setLanguage = function(e, n) {
            e.className = e.className.replace(RegExp(n, "gi"), ""), e.classList.add("language-" + n)
        }, i.stringify = function e(n, t) {
            if ("string" == typeof n) return n;
            if (Array.isArray(n)) {
                var r = "";
                return n.forEach((function(n) { r += e(n, t) })), r
            }
            var i = { type: n.type, content: e(n.content, t), tag: "span", classes: ["token", n.type], attributes: {}, language: t },
                l = n.alias;
            l && (Array.isArray(l) ? Array.prototype.push.apply(i.classes, l) : i.classes.push(l)), a.hooks.run("wrap", i);
            var o = "";
            for (var s in i.attributes) o += " " + s + '="' + (i.attributes[s] || "").replace(/"/g, "&quot;") + '"';
            return "<" + i.tag + ' class="' + i.classes.join(" ") + '"' + o + ">" + i.content + "</" + i.tag + ">"
        }, _self.Prism = a, e.Prism = a, a
    }(_self);

// Basic PHP, HTML, CSS & JS definitions
Prism.languages.markup = {
    comment: /<!--[\s\S]*?-->/,
    prolog: /<\?[\s\S]*?\?>/,
    doctype: /<!DOCTYPE[\s\S]+?>/i,
    cdata: /<!\[CDATA\[[\s\S]*?\]\]>/i,
    tag: {
        pattern: /<\/?(?!\d)[^\s>\/=$<%]+(?:\s(?:\s*[^\s>\/=]+(?:\s*=\s*(?:"[^"]*"|'[^']*'|[^\s'">=]+(?=[\s>]))|(?=[ \t\r\n\/>])))*\s*\/?>/,
        greedy: !0,
        inside: {
            tag: { pattern: /^<\/?[^\s>\/]+/, inside: { punctuation: /^<\/?/, namespace: /^[^\s>\/:]+:/ } },
            "special-attr": [],
            "attr-value": { pattern: /=\s*(?:"[^"]*"|'[^']*'|[^\s'">=]+)/, inside: { punctuation: [/^=/, /^['"]|['"]$/] } },
            punctuation: /\/?>/,
            "attr-name": { pattern: /[^\s>\/]+/, inside: { namespace: /^[^\s>\/:]+:/ } }
        }
    },
    entity: [ { pattern: /&[\da-z]{1,8};/i }, { pattern: /&#x?[\da-f]{1,8};/i } ]
};

Prism.languages.clike = {
    comment: [ { pattern: /(^|[^\\])\/\*[\s\S]*?(?:\*\/|$)/, lookbehind: !0 }, { pattern: /(^|[^\\:])\/\/.*/, lookbehind: !0 } ],
    string: { pattern: /(["'])(?:\\(?:\r\n|[\s\S])|(?!\1)[^\\\r\n])*\1/, greedy: !0 },
    "class-name": { pattern: /(\b(?:class|interface|extends|implements|trait|instanceof|new)\s+|\bcatch\s+\()[\w.\\]+/i, lookbehind: !0, inside: { punctuation: /[.\\]/ } },
    keyword: /\b(?:if|else|while|do|for|return|in|instanceof|function|new|try|throw|catch|finally|null|break|continue)\b/,
    boolean: /\b(?:true|false)\b/,
    function: /\b\w+(?=\()/,
    number: /\b0x[\da-f]+\b|(?:\b\d+(?:\.\d*)?|\B\.\d+)(?:e[+-]?\d+)?/i,
    operator: /[<>]=?|[!=]=?=?|--?|\+\+?|&&?|\|\|?|[?*/~^%]/,
    punctuation: /[{}[\];(),.:]/
};

Prism.languages.javascript = Prism.languages.extend("clike", {
    "class-name": [
        Prism.languages.clike["class-name"],
        { pattern: /(^|[^$\w\xA0-\uFFFF])(?!\s)[A-Z][$\w\xA0-\uFFFF]*(?=\.(?:prototype|constructor))/, lookbehind: !0 }
    ],
    keyword: [
        { pattern: /((?:^|\})\s*)catch\b/, lookbehind: !0 },
        { pattern: /(^|[^.]|\.\.\.\s*)\b(?:as|async(?=\s*(?:function\b|\(|[$\w\xA0-\uFFFF]|$))|await|break|case|class|const|continue|debugger|default|delete|do|else|enum|export|extends|finally|for|from|function|(?:get|set)(?=\s*[\[$\w\xA0-\uFFFF])|if|implements|import|in|instanceof|interface|let|new|null|of|package|private|protected|public|return|static|super|switch|this|throw|try|typeof|undefined|var|void|while|with|yield)\b/, lookbehind: !0 }
    ]
});

Prism.languages.php = Prism.languages.extend("clike", {
    keyword: /\b(?:__halt_compiler|abstract|and|array|as|break|callable|case|catch|class|clone|const|continue|declare|default|die|do|echo|else|elseif|empty|enddeclare|endfor|endforeach|endif|endswitch|endwhile|eval|exit|extends|final|finally|fn|for|foreach|function|global|goto|if|implements|include|include_once|instanceof|insteadof|interface|isset|list|match|namespace|new|or|parent|print|private|protected|public|require|require_once|return|static|switch|throw|trait|try|unset|use|var|while|xor|yield)\b/i,
    boolean: { pattern: /\b(?:false|true)\b/i, alias: "boolean" },
    number: /\b0b[01]+(?:_[01]+)*\b|\b0o[0-7]+(?:_[0-7]+)*\b|\b0x[\da-f]+(?:_[\da-f]+)*\b|(?:\b\d+(?:_\d+)*\.?(?:\d+(?:_\d+)*)?|\B\.\d+)(?:e[+-]?\d+)?/i,
    operator: /<?=>|<<=?|>>>?=?|--|\+\+|&&|\|\||->|::|[*\/%^&|!~?:]=?|[=!]=?=?|[<>]=?|===?/,
    variable: /\$+(?:\w+\b|(?=\{))/
});
