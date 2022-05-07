<?php $items = getViewArgs($args, 'items'); ?>
<div class="popup" style="display: none;">
    <div class="inner-popup">
        <div class="block1" style="width: 230px;">
            <div class="column last col1">
                <div class="itemMenu level1">
                    <?php if (!empty($items)): ?>
                    <?php $item_key_first = array_key_first($items); ?>
                    <?php foreach ($items as $key => $item): ?>
                    <a class="itemMenuName nochild" href="<?= $item['url'] ?>"><span><?= $item['title'] ?></span></a>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clearBoth"></div>
        </div>
    </div>
</div>