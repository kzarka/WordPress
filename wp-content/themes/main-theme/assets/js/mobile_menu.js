$(document).ready(function(){$("#ma-mobilemenu .had_child, ul.mobilemenu li span.button-view1, ul.mobilemenu li span.button-view2").each(function(){$(this).append('<span class="ttclose ttnavigation"><a href="javascript:void(0)"></a></span>')}),$("ul.mobilemenu li.active").each(function(){$(this).children().next("ul").css("display","block")}),$("ul.mobilemenu li ul").hide(),$("span.button-view1 span").click(function(){$(this).hasClass("ttopen")?varche=!0:varche=!1,varche==!1?($(this).addClass("ttopen"),$(this).removeClass("ttclose"),$(this).parent().parent().find("ul.level2").slideDown(),varche=!0):($(this).removeClass("ttopen"),$(this).addClass("ttclose"),$(this).parent().parent().find("ul.level2").slideUp(),varche=!1)}),$("span.button-view2 span").click(function(){$(this).hasClass("ttopen")?varche=!0:varche=!1,varche==!1?($(this).addClass("ttopen"),$(this).removeClass("ttclose"),$(this).parent().parent().find("ul.level3").slideDown(),varche=!0):($(this).removeClass("ttopen"),$(this).addClass("ttclose"),$(this).parent().parent().find("ul.level3").slideUp(),varche=!1)}),$(".originalmenu span.ttnavigation").click(function(){$(this).hasClass("ttopen")?varche=!0:varche=!1,varche==!1?($(this).addClass("ttopen"),$(this).removeClass("ttclose"),$(this).parent().children("ul").slideDown(),varche=!0):($(this).removeClass("ttopen"),$(this).addClass("ttclose"),$(this).parent().children("ul").slideUp(),varche=!1)}),$(".btn-navbar").click(function(){var e=0;$("#navbar-inner").hasClass("navbar-inactive")&&e==0&&($("#navbar-inner").removeClass("navbar-inactive"),$("#navbar-inner").addClass("navbar-active"),$("#ma-mobilemenu").slideDown(),e=1),$("#navbar-inner").hasClass("navbar-active")&&e==0&&($("#navbar-inner").removeClass("navbar-active"),$("#navbar-inner").addClass("navbar-inactive"),$("#ma-mobilemenu").slideUp(),e=1)})});
//# sourceMappingURL=/s/files/1/3012/8606/t/19/assets/mobile_menu.js.map?v=1532410474017834142&_accept=image/webp