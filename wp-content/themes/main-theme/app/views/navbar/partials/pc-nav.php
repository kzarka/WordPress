<?php $items = getViewArgs($args, 'items'); ?>
<div class="nav-container visible-lg visible-md">
    <div role="menu" id="pt_custommenu" class="pt_custommenu horizontal-menu">

        <?php if (!empty($items = $args['items'])): ?>
        <?php $item_key_first = array_key_first($items); ?>
        <?php foreach ($items as $key => $item): ?>
        <div class="pt_menu nav-1
            <?php if (!empty($item['children'])): ?> pt_menu_had_child<?php endif; ?>
            ">
            <div class="parentMenu">
                <a href="<?= $item['url'] ?>">
                    <span><?= $item['title'] ?></span>
                </a>
            </div>
            <?php if (!empty($item['children'])): ?>
            <?php if (!empty($item['total_level']) && $item['total_level'] == 3): ?>
            <?php renderTemplate('navbar/partials/pc-nav/level-three', ['items' => $item['children']]) ?>
            <?php else: ?>
            <?php renderTemplate('navbar/partials/pc-nav/level-two', ['items' => $item['children']]) ?>
            <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        
    </div>
</div>