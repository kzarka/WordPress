<?php $items = getViewArgs($args, 'items'); ?>
<footer class="" style="background-image: url('//cdn.shopify.com/s/files/1/3012/8606/files/bkg_footer_c0f71867-38e3-492b-995f-7d0269b97db1.jpg?v=1625767911') !important">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col1 col-md-4 col-sm-12 col-footer">
                    <div class="footer-content">
                        <a href="/" itemprop="url" class="logo-footer">
                            <img class=" lazyloaded" data-src="//cdn.shopify.com/s/files/1/3012/8606/files/logo-aero1_c79eb9d5-3b65-4c27-ac70-8b4c0c3ec086.png?v=1520968132" alt="aero-theme" itemprop="logo" src="//cdn.shopify.com/s/files/1/3012/8606/files/logo-aero1_c79eb9d5-3b65-4c27-ac70-8b4c0c3ec086.png?v=1520968132">
                        </a>
                        <p class="des">We are a team of designers and developers who creates high quality premium Shopify themes.</p>
                        <ul class="footer-contact">
                            <li class="address">
                                <span>Address :</span>No 40 Baria Sreet 133/2, NewYork, USA.
                            </li>
                            <li class="phone">
                                <span>Phone :</span>(012) 800 456 789
                            </li>
                            <li class="email">
                                <span>Email :</span>support@masstechnologist
                            </li>
                        </ul>
                    </div>
                </div>
                <?php if (!empty($items)): ?>
                <?php foreach ($items as $key => $item): ?>
                <div class="col col-md-2 col-sm-6 col-footer">
                    <div class="footer-title">
                        <h3><?= $item['title'] ?></h3>
                    </div>
                    <?php if (!empty($item['children'])): ?>
                    <?php $children = $item['children']; ?>
                    <div class="footer-content">
                        <ul class="list-unstyled text-content">
                            <?php foreach ($children as $key2 => $item2): ?>
                            <li>
                                <a href="<?= $item2['url'] ?>"><?= $item2['title'] ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="container-inner">
                <div class="footer-copyright">
                    <span>Copyright © 2021 <a href="http://masstechnologist.com/">MassTechnologist.com.</a> All rights reserved. </span>
                </div>
                <ul class="link-follow">
                    <li class="first">
                        <a class="fab fa-facebook-f facebook" data-toggle="tooltip" data-placement="bottom" href="https://facebook.com/shopify" title="" data-original-title="aero-theme on Facebook"></a>
                    </li>
                    <li>
                        <a class="fab fa-twitter twitter" data-toggle="tooltip" data-placement="bottom" href="https://twitter.coms/thopify" title="" data-original-title="aero-theme on Twitter"></a>
                    </li>
                    <li>
                        <a class="fab fa-pinterest-p pinterest" data-toggle="tooltip" data-placement="bottom" href="https://pinterest.com/shopify" title="" data-original-title="aero-theme on Pinterest"></a>
                    </li>
                    <li>
                        <a class="fab fa-google-plus-g google" data-toggle="tooltip" data-placement="bottom" href="https://plus.google.com/+shopify" title="" rel="publisher" data-original-title="aero-theme on Google"></a>
                    </li>
                    <li>
                        <a class="fab fa-instagram instagram" data-toggle="tooltip" data-placement="bottom" href="https://instagram.com/shopify" title="" data-original-title="aero-theme on Instagram"></a>
                    </li>
                </ul>
                <div class="footer-payment">
                    <a href="#">
                        <img src="//cdn.shopify.com/s/files/1/3012/8606/files/payment.png?v=1519662556" alt="payment">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="back-top" style="display: block;">
        <i class="fa fa-angle-up"></i>
    </div>
</footer>