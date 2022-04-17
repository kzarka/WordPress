<header class="hd1 bottom-menu">
    <div class="header-inner">
        <div class="container-inner">
            <div class="logo-container">
                <div id="logo">
                    <a href="/" itemprop="url">
                        <img src="//cdn.shopify.com/s/files/1/3012/8606/files/logo-aero1.png?v=1519058255" alt="aero-theme" itemprop="logo" class="img-responsive logo" />
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
                            <input type="text" name="q" id="text-search" value="" placeholder="Search entire store here..." class="form-control input-lg" aria-label="Search entire store here..." autocomplete="off" />

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
                                <button class="btn btn-link btn-link-current">My Account <i class="fa fa-angle-down"></i></button>
                                <div class="content" id="top-links">
                                    <ul class="ul-account list-unstyled">
                                        <li>
                                            <a href="/account/login" id="customer_login_link"><span>Sign in</span></a>
                                        </li>

                                        <li>
                                            <a href="/account/register" id="customer_register_link"><span>Register</span></a>
                                        </li>

                                        <li>
                                            <a href="/pages/wishlist"><span>Wish List</span></a>
                                        </li>
                                        <li>
                                            <a href="/cart"><span>Cart</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="currency" id="form-currency">
                                <span class="pull-left hidden-xs hidden-sm hidden-md text-ex">Currency:</span>
                                <button class="btn btn-link btn-link-current selected-currency">USD</button>
                                <ul name="currencies" class="content">
                                    <li>
                                        <button class="currency-select btn btn-link btn-block item-selected" type="button" name="USD" value="USD">USD</button>
                                    </li>

                                    <li>
                                        <button class="currency-select btn btn-link btn-block" type="button" name="EUR" value="USD">EUR</button>
                                    </li>

                                    <li>
                                        <button class="currency-select btn btn-link btn-block" type="button" name="GBP" value="USD">GBP</button>
                                    </li>

                                    <li>
                                        <button class="currency-select btn btn-link btn-block" type="button" name="PKR" value="USD">PKR</button>
                                    </li>

                                    <li>
                                        <button class="currency-select btn btn-link btn-block" type="button" name="CAD" value="USD">CAD</button>
                                    </li>

                                    <li>
                                        <button class="currency-select btn btn-link btn-block" type="button" name="JPY" value="USD">JPY</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="cart" class="btn-group btn-block">
                    <button type="button" data-toggle="dropdown" data-loading-text="Loading..." class="btn dropdown-toggle"><i class="ion-bag"></i> <span id="cart-total">0</span></button>
                    <ul class="dropdown-menu pull-right">
                        <li class="has-scroll">
                            <p class="text-center cart-empty">Your shopping cart is empty!</p>
                            <table class="table">
                                <tbody></tbody>
                            </table>
                        </li>
                        <li class="hide">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="text-left"><strong>Subtotal :</strong></td>
                                        <td class="text-right" id="cart-subtotal"><span class="money" data-currency-usd="$0.00">$0.00</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-center cart-button">
                                <a href="/cart">View Cart</a>
                                <a href="/checkout">Checkout</a>
                            </p>
                        </li>
                    </ul>
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
