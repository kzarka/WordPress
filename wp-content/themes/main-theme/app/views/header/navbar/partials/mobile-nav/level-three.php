<?php $items = getViewArgs($args, 'items'); ?>
<div id="popup1" class="popup" style="display: none; width: 1228px;">
    <div class="inner-popup">
        <div class="block1">
            <?php if (!empty($items)): ?>
            <?php $item_key_first = array_key_first($items); ?>
            <?php $item_key_last = array_key_last($items); ?>
            <?php foreach ($items as $key => $item): ?>
            <div class="column
            <?php if ($key == $item_key_first): ?> first<?php endif; ?>
            <?php if ($key == $item_key_last): ?> last<?php endif; ?> 
            col1">
                <div class="itemMenu level1">
                    <a class="itemMenuName level1 actParent" href="<?= $item['url'] ?>">
                        <span><?= $item['title'] ?></span>
                    </a>
                    <?php if (!empty($item['children'])): ?>
                    <div class="itemSubMenu level0">
                        <div class="itemMenu level0">
                            <?php foreach ($item['children'] as $child): ?>
                            <a class="itemMenuName act" href="<?= $child['url'] ?>"><span><?= $child['title'] ?></span></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>

            <div class="clearBoth"></div>
        </div>
    </div>
</div>