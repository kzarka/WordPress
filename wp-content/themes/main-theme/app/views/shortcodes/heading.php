<?php $title = getViewArgs($args, 'title'); ?>
<?php $desc = getViewArgs($args, 'desc'); ?>
<div class="blog-title module-title">
    <h2>
        <span><?= $title; ?></span>
    </h2>
</div>
<div class="module-description">
    <p><?= $desc; ?></p>
</div>