<?php
/**
 * The header for the theme
 *
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<?php wp_head(); ?>
    <link rel="preload" as="style" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" onload="this.rel='stylesheet'" crossorigin defer>
    <link rel="preload" as="style" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" onload="this.rel='stylesheet'" crossorigin defer>

</head>

<?php if (is_front_page()): ?>
<body <?php body_class('common-home'); ?> >
<?php else: ?>
<body <?php body_class(); ?> >
<?php endif; ?>
	
<a class="screen-reader-text" href="#content">Skip to content</a>
<div id="shopify-section-header" class="shopify-section"><!--Start of Header Area-->
    <?php if (!is_front_page()): ?>  
    <?php renderTemplate('header/header'); ?>
    <?php endif; ?>

    <style>
      @media(min-width:768px){
        header {
          max-width: 1920px;
          width: auto;
          margin: 0px auto 100px;
        }
        header .container {
          width: auto;
        }
        /*.header-inner{
          padding:0 !important;
        }*/
        .fix-header {
          padding:0 30px !important;
        }
      }
    </style>
</div>

<div id="content" class="site-content">
	
