<?php
/**
 * Header Template
 *
 * @since 2.5.0
 * @package SoliloquyWP Lite
 * @author SoliloquyWP Team <support@soliloquywp.com>
 */

$base = Soliloquy_Lite::get_instance();
$upgrade_link = Soliloquy_Common_Admin_Lite::get_instance()->get_upgrade_link( 'https://soliloquywp.com/pricing', 'topbar', 'goPro' );

?>

<div id="soliloquy-header-temp"></div>

<div id="soliloquy-header">

	<div id="soliloquy-logo"><img
			src="<?php echo esc_url( plugins_url( 'assets/images/logo-color.png', $base->file ) ); ?>"
			alt="<?php esc_html_e( 'Soliloquy', 'soliloquy' ); ?>"></div>

</div>