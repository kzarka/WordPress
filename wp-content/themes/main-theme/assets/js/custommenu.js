$(document).ready(function() {
    $(".pt_menu_link ul li").each(function() {
        var i = document.URL;
        $(".pt_menu_link ul li a").removeClass("act"), $('.pt_menu_link ul li a[href="' + i + '"]').addClass("act")
    }), $(".pt_menu_link a").each(function() {
        var i = document.URL,
            u = $(this).attr("href"),
            s = i.split("/");
        s[4] && s[4] != "" ? (url3 = s[4].split("&"), url2 = "/" + s[3] + "/" + url3[0]) : url2 = "/" + s[3], $(".pt_menu_link a").removeClass("act"), i.indexOf(u) != -1 && $(this).parent().parent().addClass("act"), $('.pt_menu_link a[href="' + url2 + '"]').parent().parent().addClass("act"), $('.pt_menu_link a[href="' + i + '"]').parent().parent().addClass("act")
    }), $(".pt_menu_no_child").hover(function() {
        $(this).addClass("active")
    }, function() {
        $(this).removeClass("active")
    }), $(".pt_menu").hover(function() {
        $(this).attr("id") != "pt_menu_link" && $(this).addClass("active")
    }, function() {
        $(this).removeClass("active")
    }), $(".pt_menu").hover(function() {
        $(this).find(".popup:first").css("display", "inline-block");
        var i = 0,
            u = $(this).find(".popup").outerWidth(!0),
            s = $(this).find(".popup").width();
        i = u - s;
        var p = $(this).find(".popup .block1").outerWidth(!0),
            o = $(this).find(".popup .block2").outerWidth(!0),
            t = 0;
            window.this = $(this);
        p && !o && (t = p), !p && o && (t = o), p && o && (t = p);
        var r = t + i,
            n = $("#pt_custommenu"),
            a = n.outerWidth(),
            h = n.offset(),
            d = $(this).offset(),
            f = d.top - h.top + $(this).find(".parentMenu > a").outerHeight(!0),
            e = d.left - h.left;
        e + r > a && (e = a - r), $(this).find(".popup").css("top", f), e < 0 ? $(this).find(".popup").css("left", 0) : $(this).find(".popup").css("left", e), $(this).find(".popup").css("width", t), $(this).find(".popup .block1").css("width", t), $(this).find(".popup").css("display", "none"), $(this).find(".popup:first").stop(!0, !0).show()
    }, function() {
        $(this).find(".popup").stop(!0, !0).hide()
    }), $(".pt_submenu").hover(function() {
        window.this = $(this);
        $(this).find(".popup").css("display", "inline-block");
        var i = 0,
            u = $(this).find(".popup").outerWidth(!0),
            s = $(this).find(".popup").width();
        i = u - s;
        var p = $(this).find(".popup .block1").outerWidth(!0),
            o = $(this).find(".popup .block2").outerWidth(!0),
            t = 0;

        p && !o && (t = p), !p && o && (t = o), p && o && (t = p);
        var r = t + i,
            n = $(this).closest(".popup"),
            a = n.outerWidth(),
            h = n.offset(),
            d = $(this).offset(),
            f = d.top - h.top - $(this).find(".parentSubMenu > a").outerHeight(!0),
            e = d.left - h.left;
        e + r > a && (e = a - r), $(this).find(".popup").css("top", f), e = r - 15, e < 0 ? $(this).find(".popup").css("left", 0) : $(this).find(".popup").css("left", e), $(this).find(".popup").css("width", t), $(this).find(".popup .block1").css("width", t), $(this).find(".popup").css("display", "none"), $(this).find(".popup").stop(!0, !0).show()
    }, function() {
        $(this).find(".popup").stop(!0, !0).hide()
    })
});
//# sourceMappingURL=/s/files/1/3012/8606/t/19/assets/custommenu.js.map?v=8011667013815211741&_accept=image/webp