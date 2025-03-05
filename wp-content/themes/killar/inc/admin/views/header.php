<?php
/**
 * KillarWT Dashboard
 *
 * @package killarwt
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap kwt-admin-wrap">
	<div class="kwt-admin-main">
		<div class="kwt-container">
			<div class="kwt-row">
				<div class="kwt-col-12">
					<div class="kwt-about-wrap about-wrap">
						<h1><?php esc_html_e( 'Welcome to Killar!', 'killar' ); ?></h1>
						<div class="about-text">Thank you for purchasing our premium Killar theme. Here you are able
							to start creating your awesome web store by importing our dummy content and theme options.
						</div>
						<div class="kwt-logo"><span>&nbsp;</span></div>
						<div class="kwt-version"><?php esc_html_e( 'Version', 'killar' ); ?><?php echo esc_html( KILLARWT_VERSION ); ?></div>
						<p class="actions">
							<?php echo sprintf( '<a href="%s" target="_blank" class="btn-docs button">' . esc_html__( 'Documentation', 'killar' ) . '</a>', 'https://docs.templateoption.com/killar/' ); ?>
							<a href="<?php echo esc_url('https://themeforest.net/item/killar-multipurpose-wordpress-theme-for-saas-startup-business-agency/50099740/support'); ?>" class="btn-support button button-primary" target="_blank"><?php echo esc_html__( 'Support forum', 'killar' ); ?></a>
						</p>
					</div>
					<?php 
					 $dashboard_tabs_menu = array(
						'0' => array (
							'title' => __( 'Dashboard', 'killar' ),
							'page'  => 'killar-dashboard',
							'link'  => add_query_arg( array( 'page' => 'killar-dashboard' ) ),
							'class' => 'kwt-dashboard ',
						),
						'10' => array (
							'title' => __( 'Import / Export', 'killar' ),
							'page'  => 'killar-customizer-import-export',
							'link'  => add_query_arg( array( 'page' => 'killar-customizer-import-export' ) ),
							'class' => 'kwt-customizer-import-export ',
						),
					);

					$dashboard_tabs_menu = apply_filters( 'killar_dashboard_tabs_menu', $dashboard_tabs_menu );
					?>
					<div class="kwt-menu-section">
						<ul class="kwt-tab-wrap">
							<?php 
								foreach( $dashboard_tabs_menu as $tab_key => $menu ) {
								$menu['class'] .= ( !empty( $_GET['page'] ) && $_GET['page'] == $menu['page'] ) ? ' active' : '';
								?>
									<li class="tab-item <?php echo esc_attr( $menu['class'] ); ?>">
										<a href="<?php echo esc_url( ( !empty( $menu['link'] ) ? $menu['link'] : add_query_arg( array( 'page' => $menu['page'] ) ) ) ); ?>"><?php echo esc_html( $menu['title'] );?></a>
									</li>
								<?php
								}
							?>
						</ul>
					</div>
					<div class="kwt-wrap-content">
						<div class="kwt-page-content">