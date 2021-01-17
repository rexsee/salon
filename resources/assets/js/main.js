jQuery(document).ready(function ($) {
    "use strict";

    function e() {
        return function (e, t) {
            var i = "";
            return i += '<a class="slider-dot"></a>'
        }
    }

    function t() {
        $(".compactlist").each(function () {
            if (!$(this).parent().hasClass("togglebox")) {
                var e = $(this).attr("data-label"), t = $(this).find(".active").text();
                0 == t.length && (t = $(this).attr("data-default")), $(this).wrap('<div class="togglebox"></div>'), $(this).parent().prepend('<div class="filterselect"><span class="selectlabel">' + e + '</span><span class="filtered">' + t + "</span></div>"), $(this).find(".label").hide(), $(this).hide()
            }
        }), $(".togglebox").on("mouseenter", function () {
            $(this).find(".filterlist").show()
        }).on("mouseleave", function () {
            $(this).find(".filterlist").hide()
        }), $(".controls .togglebox").last().addClass("last"), $(".compactlist a").on("click", function () {
            if (!$(this).parent().hasClass("multilist")) {
                var e = $(this).text();
                $(this).parent().parent().parent().find(".filtered").text(e)
            }
        }), $(".compactlist.maplist a").on("click", function () {
            var e = $(this).text();
            $(this).closest(".togglebox").find(".filtered").text(e)
        })
    }

    function i() {
        $("article h1").each(function () {
            var e = s($(this).html());
            $(this).html(e)
        }), $(".stripes h2").each(function () {
            var e = s($(this).html());
            $(this).html(e)
        })
    }

    function s(e) {
        if (e.indexOf("</span>") < 0) {
            for (var t = e.split(" "), i = "", s = t.length, a = [], n = 0; n < s; n++) a[n] = "<span>" + t[n] + "</span>";
            return i += a.join(" ")
        }
    }

    function a(e) {
        if (!$("body").hasClass("nosnapres")) {
            var t = e.attr("href"), i = $(t), s = $(i).data("intrans"), a = $(i).data("outtrans");
            s || (s = $("body").data("intrans")), a || (a = $("body").data("outtrans")), $("#mainmenu a").removeClass("active").removeClass("activeparent"), e.addClass("active");
            var n = i.attr("id"), o = $("#mainmenu a[data-panel='" + n + "']"), l = o.parent().parent("ul");
            l.hasClass("sub-menu") && l.parents("li").children("a").addClass("activeparent");
            var r = $("section.active"), c = r.data("intrans"), d = r.data("outtrans");
            c || (c = $("body").data("intrans")), d || (d = $("body").data("outtrans"));
            var p = $("section:first"), h = "#" + p.attr("id");
            h === t ? $("header").addClass("bottom") : $("header").removeClass("bottom"), r.removeClass(c).addClass(d).one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                r.removeClass(d).removeClass("active"), i.addClass(s).addClass("active").one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function () {
                    i.removeClass(s)
                })
            })
        }
    }

    function n() {
        $(".single-post .meta-top").each(function () {
            var e = $(this).width();
            $(".meta-bottom").css("width", e).addClass("positioned")
        })
    }

    function o() {
        $(".filterlist").each(function () {
            var e = $(this).height();
            e > 55 && $(".filterlist").addClass("compactlist")
        }), t()
    }

    function l() {
        var e = "res_big res_nbl res_tbl res_stbl res_phl res_phs", t = "nosnapres",
            i = window.getComputedStyle(document.querySelector("body"), ":after").getPropertyValue("content"),
            s = window.getComputedStyle(document.querySelector("header"), ":after").getPropertyValue("content"),
            a = i.replace(/["']/g, ""), n = s.replace(/["']/g, "");
        $("body").removeClass(e).addClass(a), $("body").removeClass(s).addClass(n)
    }

    function r() {
        $("body").hasClass("nosnapres") || $("body").hasClass("res_stbl") || $("body").hasClass("res_phl") || $("body").hasClass("res_phs") ? $("body.panelsnap").panelSnap("disable") : $("body.panelsnap").panelSnap("enable")
    }

    function c() {
        r(), $("body").hasClass("res_big") ? ($(".supermix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 4})
        }), $(".simplemix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 4})
        }), d("hide"), h("restore"), p("restore"), u("restore"), f("destroy")) : $("body").hasClass("res_nbl") ? ($(".supermix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 3})
        }), $(".simplemix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 3})
        }), d("hide"), h("restore"), p("restore"), u("restore"), f("destroy")) : $("body").hasClass("res_tbl") ? ($(".supermix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 2})
        }), $(".simplemix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 2})
        }), d("hide"), h("restore"), p("repos"), u("repos"), f("create")) : ($("body").hasClass("res_stbl") || $("body").hasClass("res_phl") || $("body").hasClass("res_phs")) && ($(".supermix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 1})
        }), $(".simplemix").each(function () {
            var e = $(this).attr("data-mixid");
            $("." + e + " .filteritems").mixItUp("paginate", {limit: 1})
        }), d("show"), h("repos"), p("repos"), u("restore"), f("create"))
    }

    function d(e) {
        var t = "";
        "show" === e ? t = "block" : "hide" === e && (t = "none"), $(".colx-3.hl-text-pic .imgLiquid_ready img").css("display", t), $(".colx-3.hl-pic-text .imgLiquid_ready img").css("display", t), $(".colx-3.pic-text-hl .imgLiquid_ready img").css("display", t), $(".colx-3.pic-hl-text .imgLiquid_ready img").css("display", t), $(".colx-3.text-hl-pic .imgLiquid_ready img").css("display", t), $(".colx-3.text-pic-pic .imgLiquid_ready img").css("display", t), $(".colx-2.grid .imgLiquid_ready img").css("display", t), $(".colx-2 .artwork_image img").css("display", t), $(".carousel .imgLiquid_ready img").css("display", t), $(".mixitup .imgLiquid_ready img").css("display", t)
    }

    function p(e) {
        "repos" === e ? ($(".pic-text-hl").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".pic")).show()
        }), $(".pic-hl-text").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".pic")).show()
        }), $(".text-hl-pic").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content:first-child")).show()
        }), $(".text-pic-hl").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content:first-child")).show()
        }), $(".slider-text-hl").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".sliderwrapper")).show()
        }), $(".slider-hl-text").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".sliderwrapper")).show()
        }), $(".text-hl-slider").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content:first-child")).show()
        })) : "restore" === e && ($(".colx-3 .repos-clone").remove(), $(".colx-3").each(function () {
            $(this).hasClass("stripes") || $(this).find(".hlblock").show()
        }))
    }

    function h(e) {
        "repos" === e ? ($(".default-right").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content")).show()
        }), $(".grid-right").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content")).show()
        }), $(".panorama-right").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content")).show()
        }), $(".slider-right").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content")).show()
        }), $(".testimonials-right").each(function () {
            0 == $(this).find(".repos-clone").length && $(this).find(".hlblock").hide().clone().addClass("repos-clone").insertBefore($(this).find(".content")).show()
        })) : "restore" === e && ($(".colx-2 .repos-clone").remove(), $(".colx-2 .hlblock").show())
    }

    function u(e) {
        "repos" === e ? $(".colx-3.stripes").each(function () {
            if (!$(this).hasClass("stripes-original") && !$(this).hasClass("stripes-clone")) {
                var e = $(this).clone().addClass("stripes-clone");
                $(this).before(e).addClass("stripes-original")
            }
        }) : "restore" === e && ($(".colx-3.stripes-clone").remove(), $(".colx-3.stripes").removeClass("stripes-original"))
    }

    function f(e) {
        if ("create" === e) {
            if ($("header #mobilenav").length <= 0) {
                var t = $("#mainmenu").clone();
                t.attr("class", "menu-mobile"), t.removeAttr("id");
                var i = $('<a id="mobilenav_trigger" class="icon-"></a>');
                $("header").append(t), $("header .menu-mobile").wrap('<div id="mobilenav"></div>'), $("header #mobilenav").prepend(i)
            }
            var s = $(window).height(), n = Math.round(s - 80);
            $("#mobilenav nav").css("max-height", n), $("#mobilenav nav li").each(function () {
                $(this).hasClass("has-sub") && $(this).append('<span class="sub-trigger icon-"></span>')
            }), $(".sub-trigger").on("click", function () {
                $(this).parent("li").toggleClass("open-sub")
            }), $("#mobilenav nav a").on("click", function () {
                $("#mobilenav").removeClass("on"), $("#mobilenav li").removeClass("open-sub"), $("body").hasClass("animsections") && a($(this))
            }), $(i).on("click", function () {
                $("#mobilenav").toggleClass("on")
            })
        } else "destroy" === e && $("header #mobilenav").remove()
    }

    $("#intro").each(function () {
        window.addEventListener("scroll", noscroll), setTimeout(function () {
            $("#intro").addClass("loaded")
        }, 4e3), setTimeout(function () {
            window.removeEventListener("scroll", noscroll), $("#intro").remove(), $("body").addClass("loaded")
        }, 5500)
    }), $("body.panelsnap").panelSnap({
        $menu: $("#mainmenu ul"),
        menuSelector: "a",
        panelSelector: "> section",
        namespace: ".panelSnap",
        onSnapStart: function () {
        },
        onSnapFinish: function (e) {
            $("#mainmenu a").removeClass("activeparent");
            var t = e.attr("id"), i = $("#mainmenu a[data-panel='" + t + "']"), s = i.parent().parent("ul");
            s.hasClass("sub-menu") && s.parents("li").children("a").addClass("activeparent"), "end" == t ? $("header").addClass("hidden") : $("header").removeClass("hidden")
        },
        onActivate: function () {
        },
        directionThreshold: 150,
        slideSpeed: 200,
        easing: "linear",
        offset: 0,
        keyboardNavigation: {enabled: !1, nextPanelKey: 40, previousPanelKey: 38, wrapAround: !0}
    }), $(".onepage.flexheader #hero").each(function () {
        var e = new Waypoint.Sticky({element: $("header")[0]})
    }), $(".grid li").imgLiquid({
        horizontalAlign: "center",
        verticalAlign: "center",
        fill: !1
    }), $(".colx-3 .pic").imgLiquid({
        horizontalAlign: "center",
        verticalAlign: "center"
    }), $(".imgLiquid").imgLiquid(), $(".imgLiquidCenterLeft").imgLiquid({
        verticalAlign: "center",
        horizontalAlign: "left"
    }), $(".imgLiquidCenterRight").imgLiquid({
        verticalAlign: "center",
        horizontalAlign: "right"
    }), $(".imgLiquidTopLeft").imgLiquid({
        verticalAlign: "top",
        horizontalAlign: "left"
    }), $(".imgLiquidTopRight").imgLiquid({
        verticalAlign: "top",
        horizontalAlign: "right"
    }), $(".imgLiquidTopCenter").imgLiquid({
        verticalAlign: "top",
        horizontalAlign: "center"
    }), $(".imgLiquidBottomLeft").imgLiquid({
        verticalAlign: "bottom",
        horizontalAlign: "left"
    }), $(".imgLiquidBottomRight").imgLiquid({
        verticalAlign: "bottom",
        horizontalAlign: "right"
    }), $(".imgLiquidBottomCenter").imgLiquid({
        verticalAlign: "bottom",
        horizontalAlign: "center"
    }), $(".testimonials .slick").slick({
        infinite: !0,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: !0,
        autoplay: !1,
        fade: !1,
        prevArrow: '<button class="slick-prev slick-prev-light icon-salon_arrowleft"></button>',
        nextArrow: '<button class="slick-next slick-next-light icon-salon_arrowright"></button>',
        customPaging: e()
    }), $(".grid .slick").slick({
        infinite: !0,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: !0,
        autoplaySpeed: 3e3,
        fade: !1,
        prevArrow: '<button class="slick-prev slick-prev-dark icon-salon_arrowleft"></button>',
        nextArrow: '<button class="slick-next slick-next-dark icon-salon_arrowright"></button>',
        responsive: [{breakpoint: 801, settings: {slidesToShow: 1, autoplay: !1, infinite: !1}}]
    }), $(".slider .slick").slick({
        infinite: !0,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1e3,
        autoplay: !0,
        autoplaySpeed: 4e3,
        fade: !1,
        prevArrow: '<button class="slick-prev slick-prev-dark icon-salon_arrowleft"></button>',
        nextArrow: '<button class="slick-next slick-next-dark icon-salon_arrowright"></button>',
        responsive: [{breakpoint: 801, settings: {slidesToShow: 1, autoplay: !1, infinite: !1}}]
    }), $(".slickexpandable").prepend('<a class="slider-init icon-salon_plus"></a><a class="slider-hide icon-salon_minus"></a>'), $(".slider-init").on("click", function () {
        var e = $(this).parent(".sliderwrapper");
        e.toggleClass("slickexpandable slickexpanded")
    }), $(".slider-hide").on("click", function () {
        var e = $(this).parent(".sliderwrapper");
        e.toggleClass("slickexpandable slickexpanded")
    }), $(".carousel .slickcarousel").each(function () {
        var e = $(this).find(".item").length;
        e >= 4 && $(".carousel .slickcarousel").slick({
            infinite: !0,
            slidesToShow: 4,
            slidesToScroll: 2,
            speed: 1e3,
            autoplay: !0,
            autoplaySpeed: 2e3,
            fade: !1,
            prevArrow: '<button class="slick-prev slick-prev-dark icon-salon_arrowleft"></button>',
            nextArrow: '<button class="slick-next slick-next-dark icon-salon_arrowright"></button>',
            responsive: [{breakpoint: 1281, settings: {slidesToShow: 3, slidesToScroll: 1}}, {
                breakpoint: 1025,
                settings: {slidesToShow: 2, slidesToScroll: 1}
            }, {breakpoint: 801, settings: {slidesToShow: 1, autoplay: !1, infinite: !1}}]
        })
    }), $(".carousel .filtercarousel").each(function () {
        var e = $(this).find(".item").length;
        e >= 4 && $(".carousel .filtercarousel").slick({
            infinite: !0,
            slidesToShow: 4,
            slidesToScroll: 1,
            speed: 1e3,
            autoplay: !0,
            autoplaySpeed: 2e3,
            fade: !1,
            prevArrow: '<button class="slick-prev slick-prev-dark icon-salon_arrowleft"></button>',
            nextArrow: '<button class="slick-next slick-next-dark icon-salon_arrowright"></button>',
            responsive: [{breakpoint: 1281, settings: {slidesToShow: 3, slidesToScroll: 1}}, {
                breakpoint: 1025,
                settings: {slidesToShow: 2, slidesToScroll: 1}
            }, {breakpoint: 801, settings: {slidesToShow: 1, autoplay: !1, infinite: !1}}]
        })
    }), $(".carousel .filternewscarousel").slick({
        infinite: !0,
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 1e3,
        autoplay: !0,
        autoplaySpeed: 2e3,
        fade: !1,
        prevArrow: '<button class="slick-prev slick-prev-dark icon-salon_arrowleft"></button>',
        nextArrow: '<button class="slick-next slick-next-dark icon-salon_arrowright"></button>',
        responsive: [{breakpoint: 1281, settings: {slidesToShow: 3, slidesToScroll: 1}}, {
            breakpoint: 1025,
            settings: {slidesToShow: 2, slidesToScroll: 1}
        }, {breakpoint: 801, settings: {slidesToShow: 1, autoplay: !1, infinite: !1}}]
    }), $(".carousel .filterlist a").on("click", function () {
        var e = $(this).attr("data-filter");
        "all" == e ? ($(".carousel .filtercarousel").slick("slickUnfilter"), $(".carousel .filternewscarousel").slick("slickUnfilter")) : ($(".carousel .filtercarousel").slick("slickFilter", e), $(".carousel .filternewscarousel").slick("slickFilter", e)), $(".carousel .filterlist a").removeClass("active"), $(this).addClass("active")
    }), $(".simplemix").each(function () {
        var e = ID();
        $(this).addClass(e), $(this).attr("data-mixid", e);
        var t = "." + e;
        $(t + " .filteritems").mixItUp({
            animation: {effects: "fade", animateChangeLayout: !1},
            load: {filter: "all"},
            selectors: {target: ".item", filter: t + " .filter", pagersWrapper: t + " .pagerlist"},
            pagination: {
                limit: 4,
                loop: !0,
                generatePagers: !0,
                maxPagers: 5,
                pagerClass: "",
                prevButtonHTML: "&laquo;",
                nextButtonHTML: "&raquo;"
            }
        })
    }), $(".sixmix").each(function () {
        var e = ID();
        $(this).addClass(e), $(this).attr("data-mixid", e);
        var t = "." + e;
        $(t + " .filteritems").mixItUp({
            animation: {effects: "fade", animateChangeLayout: !1},
            load: {filter: "all"},
            selectors: {target: ".item", filter: t + " .filter", pagersWrapper: t + " .pagerlist"},
            pagination: {
                limit: 6,
                loop: !0,
                generatePagers: !0,
                maxPagers: 5,
                pagerClass: "",
                prevButtonHTML: "&laquo;",
                nextButtonHTML: "&raquo;"
            }
        })
    }), $(".supermix").each(function () {
        var e = ID();
        $(this).addClass(e), $(this).attr("data-mixid", e);
        var t = "." + e, i = {
            $filters: null, $reset: null, groups: [], outputArray: [], outputString: "", init: function () {
                var e = this;
                e.$filters = $(t + " .multilist"), e.$reset = $(t + " .reset"), e.$container = $(t + " .filteritems"), e.$filters.find("ul").each(function () {
                    e.groups.push({$buttons: $(this).find(".filter"), active: ""})
                }), e.bindHandlers()
            }, bindHandlers: function () {
                var e = this;
                e.$filters.on("click", ".filter", function (t) {
                    t.preventDefault();
                    var i = $(this);
                    if (i.hasClass("active")) {
                        i.removeClass("active");
                        var s = i.parent().parent().attr("data-default");
                        i.parent().parent().parent().find(".filtered").text(s)
                    } else i.addClass("active").parent().siblings().find("a").removeClass("active"), i.parent().siblings(".label").find("a").removeClass("default"), i.parent().parent().parent().find(".filtered").text(i.text());
                    0 == i.parent().parent().find(".active").length && i.parent().parent().find(".label > a").addClass("default"), e.parseFilters()
                }), e.$reset.on("click", function (t) {
                    t.preventDefault(), e.$filters.find(".filter").removeClass("active"), e.$filters.find(".label > a").addClass("default");
                    var i = e.$filters.parent().find(".compactlist").attr("data-default");
                    e.$filters.parent().find(".filtered").text(i), e.parseFilters()
                })
            }, parseFilters: function () {
                for (var e = this, t = 0, i; i = e.groups[t]; t++) i.active = i.$buttons.filter(".active").attr("data-filter") || "";
                e.concatenate()
            }, concatenate: function () {
                var e = this;
                e.outputString = "";
                for (var t = 0, i; i = e.groups[t]; t++) e.outputString += i.active;
                !e.outputString.length && (e.outputString = "all"), console.log(e.outputString), e.$container.mixItUp("isLoaded") && e.$container.mixItUp("filter", e.outputString)
            }
        };
        i.init(), $(t + " .filteritems").mixItUp({
            controls: {enable: !0},
            animation: {effects: "fade", animateChangeLayout: !1},
            selectors: {target: ".item", filter: t + " .dontlookforme", pagersWrapper: t + " .pagerlist"},
            pagination: {
                limit: 4,
                loop: !0,
                generatePagers: !0,
                maxPagers: 5,
                pagerClass: "",
                prevButtonHTML: "&laquo;",
                nextButtonHTML: "&raquo;"
            }
        })
    }), t(), $(".panorama").each(function () {
        var e = $(this).attr("data-panorama");
        $(this).css({"background-image": "url(" + e + ")"});
        var t = ID();
        $(this).addClass(t);
        var i = "." + t, s = document.querySelector(i), a = new Motio(s, {fps: 40, speedX: "-50"});
        $(i + " .pan_controls").on("click", function () {
            a.toggle(), $(this).toggleClass("icon-salon_play").toggleClass("icon-salon_pause"), $(i).toggleClass("panocursor")
        });
        var n = $(i).offset();
        $(i).on("mousemove", function (e) {
            a.set("speedX", e.pageX - n.left - a.width / 2)
        })
    }), i(), $(".photostack").each(function () {
        var e = ID();
        $(this).attr("id", e);
        var t = "#" + e, i = e + "phostack";
        i = new Photostack(document.getElementById(e), {
            showNavigation: !0, afterInit: function () {
                $(t).find("nav").prepend('<button class="stack-prev icon-salon_arrowleft"></button>').append('<button class="stack-next icon-salon_arrowright"></button>')
            }
        }), $(t + " .stack-prev").on("click", function () {
            i.navigate("prev")
        }), $(t + " .stack-next").on("click", function () {
            i.navigate("next")
        })
    }), $("select").chosen({disable_search_threshold: 20}), $(".datetime").datetimepicker({
        lang: "en",
        startDate: "+1970/01/02",
        minDate: "0",
        mask: !0,
        theme: "dark",
        step: 30,
        minTime: "10:30",
        maxTime: "20:00",
        formatDate: 'd.m.Y'
    }), $("textarea.autosize").textareaAutoSize(), $("#back2top").scroll2Top({
        appearAt: 650,
        scrollSpeed: 200
    }), $("#end").waypoint(function () {
        $(".scrollarrow_right").toggleClass("reverse"), $(".scrollarrow_left").toggleClass("reverse")
    }), $("#mainmenu li").has("ul").addClass("has-sub"), $("body.onepage").each(function () {
        $(this).append('<span class="scrollarrow_left icon-salon_scrollarrow"></span><span class="scrollarrow_right icon-salon_scrollarrow"></span>')
    }), $(".animtrans #mainmenu a").addClass("animsition-link");
    var m = $("body").attr("data-inanim"), g = $("body").attr("data-outanim");
    $(".animtrans").animsition({
        inClass: m,
        outClass: g,
        inDuration: 1700,
        outDuration: 900,
        linkElement: ".animsition-link",
        loading: !0,
        loadingParentElement: "body",
        loadingClass: "animsition-loading",
        unSupportCss: ["animation-duration", "-webkit-animation-duration", "-o-animation-duration"],
        overlay: !0,
        overlayClass: "animsition-overlay-slide",
        overlayParentElement: "body"
    }), $("html").hasClass("no-flexbox") && $("body").removeClass("animsections"), $("body.animsections").each(function () {
        $(this).find("section").addClass("animated");
        var e = $("section:first");
        $(e).addClass("active")
    }), $("body.animsections #mainmenu a").on("click", function () {
        a($(this))
    }), $("body.animsections header h1 a").on("click", function () {
        a($(this))
    }), $('body.animsections article a[href^="#"]').on("click", function () {
        a($(this))
    }), $("form.salonform").validetta({
        display: "inline",
        errorTemplateClass: "validetta-bubble",
        errorClass: "validetta-error",
        validClass: "validetta-valid",
        errorClose: !0,
        errorCloseClass: "validetta-bubbleClose",
        realTime: !1,
        custom: {},
        remote: {},
        onValid: function (e) {
            e.preventDefault();
            var t = $(this.form).serialize(), i = $(this.form).find("div.status"),
                j = $(this.form).find("div.status-error"), k = $(this.form).find("input[type=submit]");
            k.val("Processing...");
            i.hide();
            j.hide();
            $.ajax({
                url: "processing", data: t, type: "POST", beforeSend: function () {
                    console.log("Starting form request")
                }
            }).done(function (e) {
                if (e.url) {
                    window.location = e.url;
                    return;
                }
                if (e.err_msg) {
                    i.hide();
                    j.html(e.err_msg);
                    j.show();
                } else {
                    j.hide();
                    i.show();
                }
                k.val("Submit")
            }).fail(function (e) {
                i.hide();
                j.html("Over Attempt, please try again later");
                j.show();
                k.val("Submit")
            })
        },
        onError: function () {
        }
    }), n(), $(".single-post .comments").addClass("animated"), $(".single-post .commentsform").addClass("animated"), $(".single-post .commentscount").on("click", function () {
        $(this).parents("section").find(".comments").toggleClass("on"), $(this).parents("section").find(".commentsform").removeClass("on")
    }), $(".single-post .postacomment").on("click", function () {
        $(this).parents("section").find(".commentsform").toggleClass("on"), $(this).parents("section").find(".comments").removeClass("on")
    }), $(".comments .close").on("click", function () {
        $(this).parent(".comments").removeClass("on")
    }), $(".commentsform .close").on("click", function () {
        $(this).parent(".commentsform").removeClass("on")
    }), o(), l(), c(), $(window).resize(function () {
        l(), n(), o(), c()
    })
});
