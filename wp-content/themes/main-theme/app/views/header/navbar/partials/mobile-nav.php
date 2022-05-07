<?php $items = getViewArgs($args, 'items'); ?>
<div class="ma-nav-mobile-container">
    <div class="hozmenu">
        <div class="navbar">
            <div id="navbar-inner" class="navbar-inner navbar-inactive">
                <div class="menu-mobile">
                    <a class="btn btn-navbar navbar-toggle">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <span class="brand navbar-brand">MENU</span>
                </div>
                <?php if (!empty($items = $args['items'])): ?>
                <ul role="menu" id="ma-mobilemenu" class="mobilemenu originalmenu nav-collapse collapse">
                    <?php $item_key_first = array_key_first($items); ?>
                    <?php foreach ($items as $key => $item): ?>
                    <li class="<?php if (!empty($item['children'])): ?> had_child<?php endif; ?>">
                        <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>
                        <?php if (!empty($item['children'])): ?>
                        <?php $children = $item['children']; ?>
                        <ul class="" style="display: none;">
                            <?php foreach ($children as $key2 => $item2): ?>
                            <li class="<?php if (!empty($item2['children'])): ?> had_child<?php endif; ?>">
                                <a href="<?= $item['url'] ?>"><span><?= $item['title'] ?></span></a>
                                <?php if (!empty($item2['children'])): ?>
                                <?php $children2 = $item2['children']; ?>
                                <ul class="" style="display: none;">
                                    <?php foreach ($children2 as $key3 => $item3): ?>
                                    <li>
                                        <a href="<?= $item3['url'] ?>"><span><?= $item3['title'] ?></span></a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <span class="ttclose ttnavigation"><a href="javascript:void(0)"></a></span>
                                <?php endif; ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <span class="ttclose ttnavigation"><a href="javascript:void(0)"></a></span>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end menu area -->
</div>