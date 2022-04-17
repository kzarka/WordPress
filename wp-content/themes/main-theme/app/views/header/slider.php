<!-- BEGIN content_for_index -->
<div class="shopify-section index-section slider" id="topslider">
    <div data-section="my-slider" class="my-slider main-row full-width">
        <div class="container">
            <div class="row">
                <div class="main-col col-sm-12 col-md-12">
                    <div class="row sub-row">
                        <div class="sub-col col-sm-12 col-md-12">
                            <!--Slider Area Start-->
                            <div class="banner7">
                                <div class="oc-banner7-container" id="Slideshow-1480267833382">
                                    <div class="flexslider oc-nivoslider our_story">
                                        <div class="oc-loading"></div>
                                        <div id="oc-inivoslider1" class="nivoSlider slides static_video">
                                            <img
                                                style="display: none;"
                                                class="lazyload"
                                                data-src="//cdn.shopify.com/s/files/1/3012/8606/files/slider3-aero1-1920x846_1920x846.progressive.jpg?v=1519055913"
                                                alt=""
                                                title="#banner1480267833382-caption1"
                                            />

                                            <img
                                                style="display: none;"
                                                class="lazyload"
                                                data-src="//cdn.shopify.com/s/files/1/3012/8606/files/slider2-aero1-1920x846_1920x846.progressive.jpg?v=1519055928"
                                                alt=""
                                                title="#banner1480267833382-caption2"
                                            />

                                            <img
                                                style="display: none;"
                                                class="lazyload"
                                                data-src="//cdn.shopify.com/s/files/1/3012/8606/files/slider1-aero1-1920x846_1920x846.progressive.jpg?v=1519055942"
                                                alt=""
                                                title="#banner1480267833382-caption3"
                                            />
                                        </div>

                                        <div id="banner1480267833382-caption1" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype">
                                            <div class="timeloading"></div>
                                            <div class="banner7-content slider-2">
                                                <div class="text-content" style="top: 50%; right: 0%; left: 0%; width: 100%; text-align: center;">
                                                    <div class="banner7-des" style="float: none;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="banner1480267833382-caption2" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype">
                                            <div class="timeloading"></div>
                                            <div class="banner7-content slider-3">
                                                <div class="text-content" style="top: 50%; right: 0%; left: 0%; width: 100%; text-align: center;">
                                                    <div class="banner7-des" style="float: none;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="banner1480267833382-caption3" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype">
                                            <div class="timeloading"></div>
                                            <div class="banner7-content slider-1">
                                                <div class="text-content" style="top: 50%; right: 0%; left: 0%; width: 100%; text-align: center;">
                                                    <div class="banner7-des" style="float: none;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <script type="text/javascript">
                                            $(document).ready(function () {
                                                $(".my-slider #oc-inivoslider1").nivoSlider({
                                                    effect: "random",
                                                    slices: 15,
                                                    boxCols: 8,
                                                    boxRows: 4,
                                                    manualAdvance: false,
                                                    animSpeed: 500,
                                                    pauseTime: 10000,
                                                    startSlide: 0,
                                                    controlNav: true,
                                                    directionNav: true,
                                                    controlNavThumbs: false,
                                                    pauseOnHover: true,
                                                    prevText: '<i class="ion-chevron-left"></i>',
                                                    nextText: '<i class="ion-chevron-right"></i>',
                                                    afterLoad: function () {
                                                        $(".my-slider .oc-loading").css("display", "none");
                                                        $(".my-slider .timeloading").css("animation-duration", " 10000ms ");
                                                    },
                                                });

                                                // Move menu below slider
                                                if ($(".bottom-menu").length) {
                                                    console.log("reaching");
                                                    $("#topslider").insertBefore("#shopify-section-header");
                                                    $(".banner7").css({ "margin-bottom": "0px" });
                                                    //stickyOffset += $('.shopify-section.slider').height();
                                                }

                                                if ($(".ma-corporate-about1").length) {
                                                    $("#topslider .banner7 .oc-banner7-container .nivo-controlNav").css("bottom", "20%");
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End of Slider Area-->
                </div>
            </div>
        </div>
    </div>
</div>
