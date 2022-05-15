<header class="hd1 bottom-menu">
    <div class="header-inner">
        <div class="container-inner">
            <div class="logo-container">
                <div id="logo">
                    <a href="/" itemprop="url">
                        <?= get_custom_logo_html(); ?>
                    </a>
                </div>
            </div>
            <div class="box box-left">
                <div class="hozmenu-container">
                    <?php do_action( 'mobile_nav_content' ); ?>
                    <?php do_action( 'pc_nav_content' ); ?>
                </div>
                <div id="sticky-menu" data-sticky="0"></div>
                <script type="text/javascript">
                    //<![CDATA[
                    var body_class = $("body").attr("class");
                    if (body_class.search("common-home") != -1) {
                        $("#pt_menu_home").addClass("act");
                    }
                    var CUSTOMMENU_POPUP_EFFECT = 0;
                    var CUSTOMMENU_POPUP_TOP_OFFSET = 70;
                    //]]>
                </script>
            </div>
            <div class="box box-right">
                <div id="search" class="input-group">
                    <div class="btn-group">
                        <div class="dropdown-toggle search-button" data-toggle="dropdown"></div>

                        <div class="dropdown-menu search-content">
                            <input type="text" name="q" id="text-search" value="" placeholder="Tìm kiếm sản phẩm" class="form-control input-lg" aria-label="Tìm kiếm sản phẩm" autocomplete="off" />

                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-lg"></button>
                            </span>
                            <ul class="search-results" style="display: none; position: absolute; left: 0px; top: 35px;" ;=""></ul>
                        </div>
                    </div>
                </div>

                <div class="box-setting">
                    <div class="btn-group">
                        <div class="dropdown-toggle setting-button" data-toggle="dropdown">
                            <i class="icon ion-grid"></i>
                        </div>
                        <div class="dropdown-menu setting-content">
                            <div class="account">
                                <button class="btn btn-link btn-link-current">Tài khoản <i class="fa fa-angle-down"></i></button>
                                <div class="content" id="top-links">
                                    <ul class="ul-account list-unstyled">
                                        <li>
                                            <a href="<?= site_url('/wp-login.php?action=login'); ?>" id="customer_login_link"><span>Đăng nhập</span></a>
                                        </li>

                                        <li>
                                            <a href="<?= site_url('/wp-login.php?action=register'); ?>" id="customer_register_link"><span>Đăng ký</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">
                    $(document).ready(function () {
                        var total = $("#cart .table .text-right").html();
                        $("#cart .total-price").html(total);
                    });
                </script>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</header>
