<?php
/**
 * Register block patterns
 *
 * @package Gutenberghub_Tabs
 */

/**
 * Register tabs block patterns class
 */
class Gutenberghub_Tabs_Block_Patterns {
	/**
	 * Block Patterns
	 *
	 * @var array
	 */
	private $patterns = array(
		array(
			'pattern_name' => 'Collapsible Tabs',
			'template'     => array(
				'title'      => 'Collapsible Tabs',
				'categories' => array( 'gutenberghub-tabs' ),
				'blockTypes' => array( 'ghub/tabs-container' ),
				'content'    => <<<EOD
				<!-- wp:group {"align":"full","layout":{"type":"constrained","contentSize":"1200px"}} -->
				<div class="wp-block-group alignfull"><!-- wp:ghub/tabs-container {"showPlaceholder":false} -->
				<div class="wp-block-ghub-tabs-container gutenberghub-tabs-container gutenberghub-tabs-frontend-container"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"0","left":"var:preset|spacing|50"}}}} -->
				<div class="wp-block-columns"><!-- wp:column {"verticalAlignment":"center","width":"45%"} -->
				<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%"><!-- wp:ghub/tab-buttons-container {"tabsBorder":{"top":{"width":"0px","style":"none"},"right":{"width":"0px","style":"none"},"bottom":{"width":"0px","style":"none"},"left":{"color":"#abb8c3","width":"4px"}},"tabsBorderRadius":{},"tabsTextColor":"#000000","tabsPadding":{"top":"10px","right":"26px","bottom":"10px","left":"26px"},"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","flexWrap":"wrap"}} -->
				<div class="wp-block-ghub-tab-buttons-container gutenberghub-tab-buttons-container" style="--ghub-tabs-button-text-color:#000000;--ghub-tabs-button-padding-top:10px;--ghub-tabs-button-padding-right:26px;--ghub-tabs-button-padding-bottom:10px;--ghub-tabs-button-padding-left:26px;--ghub-tabs-button-border-top:0px none ;--ghub-tabs-button-border-right:0px none ;--ghub-tabs-button-border-bottom:0px none ;--ghub-tabs-button-border-left:4px solid #abb8c3" data-trigger="click"><!-- wp:ghub/tab-button {"buttonText":"Tab 1"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"typography":{"fontSize":"25px"}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;font-size:25px">Tab 1</p>
				<!-- /wp:paragraph -->

				<!-- wp:ghub/tab-collapsible -->
				<div class="wp-block-ghub-tab-collapsible gutenberghub-tab-collapsible gutenberghub-tab-collapsible-initialized"><div class="gutenberghub-tab-collapsible-inner-container"><!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:16px">Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div></div>
				<!-- /wp:ghub/tab-collapsible --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 2"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"typography":{"fontSize":"25px"}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;font-size:25px">Tab 2</p>
				<!-- /wp:paragraph -->

				<!-- wp:ghub/tab-collapsible -->
				<div class="wp-block-ghub-tab-collapsible gutenberghub-tab-collapsible gutenberghub-tab-collapsible-initialized"><div class="gutenberghub-tab-collapsible-inner-container"><!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:16px">consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
				<!-- /wp:paragraph --></div></div>
				<!-- /wp:ghub/tab-collapsible --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 3"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}},"typography":{"fontSize":"25px"}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;font-size:25px">Tab 3</p>
				<!-- /wp:paragraph -->

				<!-- wp:ghub/tab-collapsible -->
				<div class="wp-block-ghub-tab-collapsible gutenberghub-tab-collapsible gutenberghub-tab-collapsible-initialized"><div class="gutenberghub-tab-collapsible-inner-container"><!-- wp:paragraph {"style":{"typography":{"fontSize":"16px"},"spacing":{"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;font-size:16px">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
				<!-- /wp:paragraph --></div></div>
				<!-- /wp:ghub/tab-collapsible --></div>
				<!-- /wp:ghub/tab-button --></div>
				<!-- /wp:ghub/tab-buttons-container --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":"55%"} -->
				<div class="wp-block-column" style="flex-basis:55%"><!-- wp:ghub/tab-contents-container {"contentsBorder":{"color":"#abb8c3","width":"1px"},"contentsBorderRadius":{}} -->
				<div class="wp-block-ghub-tab-contents-container gutenberghub-tab-contents-container" style="--ghub-content-padding-top:10px;--ghub-content-padding-right:20px;--ghub-content-padding-bottom:10px;--ghub-content-padding-left:20px;--ghub-content-border-top:1px solid #abb8c3;--ghub-content-border-right:1px solid #abb8c3;--ghub-content-border-bottom:1px solid #abb8c3;--ghub-content-border-left:1px solid #abb8c3"><!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">1</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">2</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">3</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content --></div>
				<!-- /wp:ghub/tab-contents-container --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns --></div>
				<!-- /wp:ghub/tabs-container --></div>
				<!-- /wp:group -->
			EOD,
			),
		),
		array(
			'pattern_name' => 'Left Style Tabs',
			'template'     => array(
				'title'      => 'Left Style Tabs',
				'categories' => array( 'gutenberghub-tabs' ),
				'blockTypes' => array( 'ghub/tabs-container' ),
				'content'    => <<<EOD
				<!-- wp:ghub/tabs-container {"showPlaceholder":false} -->
				<div class="wp-block-ghub-tabs-container gutenberghub-tabs-container gutenberghub-tabs-frontend-container"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"0","left":"10px"}}}} -->
				<div class="wp-block-columns"><!-- wp:column {"width":"30%"} -->
				<div class="wp-block-column" style="flex-basis:30%"><!-- wp:ghub/tab-buttons-container {"tabsBorder":{"color":"#abb8c3","width":"1px"},"tabsBorderRadius":{},"tabsTextColor":"#000000","tabsPadding":{"top":"10px","right":"26px","bottom":"10px","left":"26px"},"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","flexWrap":"wrap"}} -->
				<div class="wp-block-ghub-tab-buttons-container gutenberghub-tab-buttons-container" style="--ghub-tabs-button-text-color:#000000;--ghub-tabs-button-padding-top:10px;--ghub-tabs-button-padding-right:26px;--ghub-tabs-button-padding-bottom:10px;--ghub-tabs-button-padding-left:26px;--ghub-tabs-button-border-top:1px solid #abb8c3;--ghub-tabs-button-border-right:1px solid #abb8c3;--ghub-tabs-button-border-bottom:1px solid #abb8c3;--ghub-tabs-button-border-left:1px solid #abb8c3" data-trigger="click"><!-- wp:ghub/tab-button {"buttonText":"Tab 1"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 1</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 2"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 2</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 3"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 3</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button --></div>
				<!-- /wp:ghub/tab-buttons-container --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":""} -->
				<div class="wp-block-column"><!-- wp:ghub/tab-contents-container {"contentsBorder":{"color":"#abb8c3","width":"1px"},"contentsBorderRadius":{}} -->
				<div class="wp-block-ghub-tab-contents-container gutenberghub-tab-contents-container" style="--ghub-content-padding-top:10px;--ghub-content-padding-right:20px;--ghub-content-padding-bottom:10px;--ghub-content-padding-left:20px;--ghub-content-border-top:1px solid #abb8c3;--ghub-content-border-right:1px solid #abb8c3;--ghub-content-border-bottom:1px solid #abb8c3;--ghub-content-border-left:1px solid #abb8c3"><!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">1</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">2</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">3</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content --></div>
				<!-- /wp:ghub/tab-contents-container --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns --></div>
				<!-- /wp:ghub/tabs-container -->
			EOD,
			),
		),
		array(
			'pattern_name' => 'Right Style Tabs',
			'template'     => array(
				'title'      => 'Right Style Tabs',
				'categories' => array( 'gutenberghub-tabs' ),
				'blockTypes' => array( 'ghub/tabs-container' ),
				'content'    => <<<EOD
				<!-- wp:ghub/tabs-container {"showPlaceholder":false,"activeTabIndex":2} -->
				<div class="wp-block-ghub-tabs-container gutenberghub-tabs-container gutenberghub-tabs-frontend-container"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"0","left":"10px"}}}} -->
				<div class="wp-block-columns"><!-- wp:column {"width":""} -->
				<div class="wp-block-column"><!-- wp:ghub/tab-contents-container {"contentsBorder":{"color":"#abb8c3","width":"1px"},"contentsBorderRadius":{}} -->
				<div class="wp-block-ghub-tab-contents-container gutenberghub-tab-contents-container" style="--ghub-content-padding-top:10px;--ghub-content-padding-right:20px;--ghub-content-padding-bottom:10px;--ghub-content-padding-left:20px;--ghub-content-border-top:1px solid #abb8c3;--ghub-content-border-right:1px solid #abb8c3;--ghub-content-border-bottom:1px solid #abb8c3;--ghub-content-border-left:1px solid #abb8c3"><!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">1</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">2</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">3</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content --></div>
				<!-- /wp:ghub/tab-contents-container --></div>
				<!-- /wp:column -->

				<!-- wp:column {"width":"30%"} -->
				<div class="wp-block-column" style="flex-basis:30%"><!-- wp:ghub/tab-buttons-container {"tabsBorder":{"color":"#abb8c3","width":"1px"},"tabsBorderRadius":{},"tabsTextColor":"#000000","tabsPadding":{"top":"10px","right":"26px","bottom":"10px","left":"26px"},"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","flexWrap":"wrap"}} -->
				<div class="wp-block-ghub-tab-buttons-container gutenberghub-tab-buttons-container" style="--ghub-tabs-button-text-color:#000000;--ghub-tabs-button-padding-top:10px;--ghub-tabs-button-padding-right:26px;--ghub-tabs-button-padding-bottom:10px;--ghub-tabs-button-padding-left:26px;--ghub-tabs-button-border-top:1px solid #abb8c3;--ghub-tabs-button-border-right:1px solid #abb8c3;--ghub-tabs-button-border-bottom:1px solid #abb8c3;--ghub-tabs-button-border-left:1px solid #abb8c3" data-trigger="click"><!-- wp:ghub/tab-button {"buttonText":"Tab 1"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"align":"left","placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p class="has-text-align-left" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 1</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 2"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"align":"left","placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p class="has-text-align-left" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 2</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 3"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"align":"left","placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p class="has-text-align-left" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 3</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button --></div>
				<!-- /wp:ghub/tab-buttons-container --></div>
				<!-- /wp:column --></div>
				<!-- /wp:columns --></div>
				<!-- /wp:ghub/tabs-container -->
			EOD,
			),
		),
		array(
			'pattern_name' => 'Top Style Tabs',
			'template'     => array(
				'title'      => 'Top Style Tabs',
				'categories' => array( 'gutenberghub-tabs' ),
				'blockTypes' => array( 'ghub/tabs-container' ),
				'content'    => <<<EOD
				<!-- wp:ghub/tabs-container {"showPlaceholder":false,"activeTabIndex":2} -->
				<div class="wp-block-ghub-tabs-container gutenberghub-tabs-container gutenberghub-tabs-frontend-container"><!-- wp:ghub/tab-buttons-container {"tabsBorder":{"color":"#abb8c3","width":"1px"},"tabsBorderRadius":{},"tabsTextColor":"#000000","tabsPadding":{"top":"10px","right":"26px","bottom":"10px","left":"26px"},"style":{"spacing":{"blockGap":"10px","margin":{"bottom":"10px"}}}} -->
				<div class="wp-block-ghub-tab-buttons-container gutenberghub-tab-buttons-container" style="margin-bottom:10px;--ghub-tabs-button-text-color:#000000;--ghub-tabs-button-padding-top:10px;--ghub-tabs-button-padding-right:26px;--ghub-tabs-button-padding-bottom:10px;--ghub-tabs-button-padding-left:26px;--ghub-tabs-button-border-top:1px solid #abb8c3;--ghub-tabs-button-border-right:1px solid #abb8c3;--ghub-tabs-button-border-bottom:1px solid #abb8c3;--ghub-tabs-button-border-left:1px solid #abb8c3" data-trigger="click"><!-- wp:ghub/tab-button {"buttonText":"Tab 1"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 1</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 2"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 2</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 3"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 3</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button --></div>
				<!-- /wp:ghub/tab-buttons-container -->

				<!-- wp:ghub/tab-contents-container {"contentsBorder":{"color":"#abb8c3","width":"1px"},"contentsBorderRadius":{}} -->
				<div class="wp-block-ghub-tab-contents-container gutenberghub-tab-contents-container" style="--ghub-content-padding-top:10px;--ghub-content-padding-right:20px;--ghub-content-padding-bottom:10px;--ghub-content-padding-left:20px;--ghub-content-border-top:1px solid #abb8c3;--ghub-content-border-right:1px solid #abb8c3;--ghub-content-border-bottom:1px solid #abb8c3;--ghub-content-border-left:1px solid #abb8c3"><!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">1</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">2</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">3</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content --></div>
				<!-- /wp:ghub/tab-contents-container --></div>
				<!-- /wp:ghub/tabs-container -->
			EOD,
			),
		),
		array(
			'pattern_name' => 'Bottom Style Tabs',
			'template'     => array(
				'title'      => 'Bottom Style Tabs',
				'categories' => array( 'gutenberghub-tabs' ),
				'blockTypes' => array( 'ghub/tabs-container' ),
				'content'    => <<<EOD
				<!-- wp:ghub/tabs-container {"showPlaceholder":false,"activeTabIndex":2} -->
				<div class="wp-block-ghub-tabs-container gutenberghub-tabs-container gutenberghub-tabs-frontend-container"><!-- wp:ghub/tab-contents-container {"contentsBorder":{"color":"#abb8c3","width":"1px"},"contentsBorderRadius":{}} -->
				<div class="wp-block-ghub-tab-contents-container gutenberghub-tab-contents-container" style="--ghub-content-padding-top:10px;--ghub-content-padding-right:20px;--ghub-content-padding-bottom:10px;--ghub-content-padding-left:20px;--ghub-content-border-top:1px solid #abb8c3;--ghub-content-border-right:1px solid #abb8c3;--ghub-content-border-bottom:1px solid #abb8c3;--ghub-content-border-left:1px solid #abb8c3"><!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">1</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">2</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content -->

				<!-- wp:ghub/tab-content -->
				<div class="wp-block-ghub-tab-content gutenberghub-tab-content"><!-- wp:paragraph {"style":{"typography":{"fontSize":"50px","lineHeight":"1","fontStyle":"normal","fontWeight":"600"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} -->
				<p style="margin-top:0;margin-bottom:0;font-size:50px;font-style:normal;font-weight:600;line-height:1">3</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.&nbsp;</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-content --></div>
				<!-- /wp:ghub/tab-contents-container -->

				<!-- wp:ghub/tab-buttons-container {"tabsBorder":{"color":"#abb8c3","width":"1px"},"tabsBorderRadius":{},"tabsTextColor":"#000000","tabsPadding":{"top":"10px","right":"26px","bottom":"10px","left":"26px"},"style":{"spacing":{"blockGap":"10px","margin":{"top":"10px"}}}} -->
				<div class="wp-block-ghub-tab-buttons-container gutenberghub-tab-buttons-container" style="margin-top:10px;--ghub-tabs-button-text-color:#000000;--ghub-tabs-button-padding-top:10px;--ghub-tabs-button-padding-right:26px;--ghub-tabs-button-padding-bottom:10px;--ghub-tabs-button-padding-left:26px;--ghub-tabs-button-border-top:1px solid #abb8c3;--ghub-tabs-button-border-right:1px solid #abb8c3;--ghub-tabs-button-border-bottom:1px solid #abb8c3;--ghub-tabs-button-border-left:1px solid #abb8c3" data-trigger="click"><!-- wp:ghub/tab-button {"buttonText":"Tab 1"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 1</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 2"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 2</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button -->

				<!-- wp:ghub/tab-button {"buttonText":"Tab 3"} -->
				<div class="wp-block-ghub-tab-button gutenberghub-tab-button"><!-- wp:paragraph {"placeholder":"Tab Title","style":{"spacing":{"margin":{"top":"0","right":"0","bottom":"0","left":"0"}}}} -->
				<p style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0">Tab 3</p>
				<!-- /wp:paragraph --></div>
				<!-- /wp:ghub/tab-button --></div>
				<!-- /wp:ghub/tab-buttons-container --></div>
				<!-- /wp:ghub/tabs-container -->
			EOD,
			),
		),
	);

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		$this->register_block_patterns();
		$this->register_patterns_category();
	}

	/**
	 * Register block pattern categories
	 */
	public function register_patterns_category() {
		register_block_pattern_category(
			'gutenberghub-tabs',
			array( 'label' => __( 'Tabs', 'gutenberghub-tabs' ) )
		);
	}

	/**
	 * Register patterns
	 */
	public function register_block_patterns() {
		foreach ( $this->patterns as $pattern ) {
			register_block_pattern(
				$pattern['pattern_name'],
				$pattern['template']
			);
		}
	}
}

new Gutenberghub_Tabs_Block_Patterns();
