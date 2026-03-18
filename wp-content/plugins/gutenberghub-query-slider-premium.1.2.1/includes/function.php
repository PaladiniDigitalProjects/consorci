<?php
function gutenberghub_split_border($attributes, $attributeKey) {
	if (!isset($attributes[$attributeKey])  || array_key_exists('top', $attributes[$attributeKey])) {
		return array();
	}
	$borderAttribute = $attributes[$attributeKey];

	$splitted_border = array();
	$splitted_border["top"] = $borderAttribute;
	$splitted_border["right"] = $borderAttribute;
	$splitted_border["bottom"] = $borderAttribute;
	$splitted_border["left"] = $borderAttribute;

	return $splitted_border;
}

function gutenberghub_apply_border_variable($border, $border_position, $prefix) {
	$color = isset($border[$border_position]['color']) ? $border[$border_position]['color'] : "";
	$width = isset($border[$border_position]['width']) ? $border[$border_position]['width'] : "";
	$border_style = isset($border[$border_position]['width']) && !isset($border[$border_position]['style'])  ? "solid" : $border[$border_position]['style'] ?? "";

	return '--ghub-' . $prefix . '-border-' . $border_position . ':'  . $width . " "  . $border_style . " " . $color . ';';
}
/**
 * Add slider classes on the slider wrapper
 */
function gutenberghub_get_query_slider_datasets($attributes) {
	return sprintf(
		'%1$s %2$s %3$s %4$s %5$s %6$s %7$s %8$s %9$s',
		array_key_exists('perPage', $attributes['query']) ? 'data-slidesperview=' . $attributes['query']['perPage'] : 'data-slidesperview=1', //1
		array_key_exists('gutenberghubAutoPlayOn', $attributes) && true === $attributes['gutenberghubAutoPlayOn'] ? 'data-autoplay=true' : 'data-autoplay=false',  //2
		array_key_exists('gutenberghubAutoPlayOn', $attributes) && true === $attributes['gutenberghubAutoPlayOn'] && array_key_exists('gutenberghubAutoPlayDelay', $attributes) ? 'data-autoplayDelay="' . $attributes['gutenberghubAutoPlayDelay'] . '"' : "data-autoplayDelay=3000",  //3
		array_key_exists('gutenberghubAutoPlayOn', $attributes) && true === $attributes['gutenberghubAutoPlayOn'] && array_key_exists('gutenberghubPauseOnHover', $attributes) && array_key_exists('gutenberghubPauseOnHover', $attributes) && true === $attributes['gutenberghubPauseOnHover'] ? 'data-pauseonhover=true' : 'data-pauseonhover=false',  //4
		array_key_exists('gutenberghubSlidesGap', $attributes) ? 'data-slidesgap="' . $attributes['gutenberghubSlidesGap'] . '"' : 'data-slidesgap=20',  //5
		array_key_exists('sliderDirection', $attributes) ? 'data-sliderdirection="' . $attributes['sliderDirection'] . '"' : 'data-sliderdirection=horizontal',  //6
		array_key_exists('gutenberghubHeight', $attributes) &&  'auto' === $attributes['gutenberghubHeight'] ? 'data-autoheight=true' : 'data-autoheight=false',  //7
		array_key_exists('ghubLoopOn', $attributes) && true === $attributes['ghubLoopOn'] ? 'data-loop=true' : 'data-loop=false',  //8
		array_key_exists('ghubSpeed', $attributes) ? 'data-speed="' . $attributes['ghubSpeed'] . '"' : 'data-speed=400',  //9
	);
}

/**
 * Create pagination according to the number of slides
 */
function get_gutenberghub_query_slider_pagination($attributes) {
	return sprintf(
		'<div class="ghub-slider-pagination %1$s %2$s %3$s"></div>',
		array_key_exists('gutenberghubIndicatorStyle', $attributes) ? $attributes['gutenberghubIndicatorStyle']  : '',
		array_key_exists('gutenberghubIndicatorVerticalAlign', $attributes) ? sprintf('ghub-pagination-vertical-%1$s', $attributes['gutenberghubIndicatorVerticalAlign']) : 'ghub-pagination-vertical-bottom',
		array_key_exists('gutenberghubIndicatorJustification', $attributes) ? sprintf('ghub-pagination-justify-%1$s', $attributes['gutenberghubIndicatorJustification']) : 'ghub-pagination-justify-center'
	);
}

/**
 * Render Navigation 
 * 
 **/

function get_gutenberghub_query_slider_navigation($attributes) {
	$splitted_border = gutenberghub_split_border($attributes, 'navigationBorder');

	return sprintf(
		'<div class="ghub-slider-navigation-wrapper %2$s %3$s" style="%4$s%5$s%6$s%7$s%8$s%9$s%10$s%11$s%12$s">
		     <div class="ghub-slider-prev">%1$s</div>
		     <div class="ghub-slider-next">%1$s</div>
		  </div>',
		array_key_exists('gutenberghubNavigationIcon', $attributes) ?  get_navigation_icon($attributes['gutenberghubNavigationIcon']) : get_navigation_icon('arrow'), //1
		array_key_exists('gutenberghubNavigationVerticalAlign', $attributes) ? sprintf('ghub-navigation-vertical-%1$s', $attributes['gutenberghubNavigationVerticalAlign']) : 'ghub-navigation-vertical-center', //2
		array_key_exists('gutenberghubNavigationJustification', $attributes) ? sprintf('ghub-navigation-justify-%1$s', $attributes['gutenberghubNavigationJustification']) : 'ghub-navigation-justify-spaceBetween', //3
		array_key_exists('top', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'top', 'slider-navigation') : "", //4
		array_key_exists('right', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'right', 'slider-navigation') : "", //5
		array_key_exists('bottom', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'bottom', 'slider-navigation') : "", //6
		array_key_exists('left', $splitted_border) ? gutenberghub_apply_border_variable($splitted_border, 'left', 'slider-navigation') : "", //7
		array_key_exists('navigationBorderRadius', $attributes) && array_key_exists('top', $attributes['navigationBorderRadius']) ? '--ghub-slider-navigation-radius-top-left:' . $attributes['navigationBorderRadius']['top'] . ';' : "", //8
		array_key_exists('navigationBorderRadius', $attributes) && array_key_exists('right', $attributes['navigationBorderRadius']) ? '--ghub-slider-navigation-radius-top-right:' . $attributes['navigationBorderRadius']['right'] . ';' : "", //9
		array_key_exists('navigationBorderRadius', $attributes) && array_key_exists('bottom', $attributes['navigationBorderRadius']) ? '--ghub-slider-navigation-radius-bottom-left:' . $attributes['navigationBorderRadius']['bottom'] . ';' : "", //10
		array_key_exists('navigationBorderRadius', $attributes) && array_key_exists('right', $attributes['navigationBorderRadius']) ? '--ghub-slider-navigation-radius-bottom-right:' . $attributes['navigationBorderRadius']['left'] . ';' : "", //11
		array_key_exists('navigationBgColor', $attributes) ? '--ghub-slider-navigation-bg-color:' . $attributes['navigationBgColor'] . ';' : "", //12
	);
}

/**
 * 
 * Navigation icon
 */
function get_navigation_icon($icon_name) {
	$icons = array(
		"chevron" =>
		'<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 32 32"
		>
			<path
				fill="currentColor"
				d="M22 16L12 26l-1.4-1.4l8.6-8.6l-8.6-8.6L12 6z"
			/>
		</svg>',
		"chevronCompact" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 16 16"
		>
			<path
				fill="currentColor"
				fill-rule="evenodd"
				d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8L6.553 2.224a.5.5 0 0 1 .223-.671z"
			/>
		</svg>'
		),
		"squareChevron" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
		>
			<path
				fill="currentColor"
				d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14c1.11 0 2-.89 2-2V5a2 2 0 0 0-2-2M9.71 18l-1.42-1.41L12.88 12L8.29 7.41L9.71 6l6 6l-6 6Z"
			/>
		</svg>'
		),
		"caretFill" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 16 16"
		>
			<path
				fill="currentColor"
				d="m12.14 8.753l-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"
			/>
		</svg>'
		),
		"roundArrow" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 256 256"
		>
			<path
				fill="currentColor"
				d="M128 24a104 104 0 1 0 104 104A104.2 104.2 0 0 0 128 24Zm47.4 107.1a8.7 8.7 0 0 1-1.8 2.6l-33.9 33.9a7.6 7.6 0 0 1-5.6 2.3a7.8 7.8 0 0 1-5.7-2.3a8 8 0 0 1 0-11.3l20.3-20.3H88a8 8 0 0 1 0-16h60.7l-20.3-20.3a8 8 0 0 1 11.3-11.3l33.9 33.9a8.7 8.7 0 0 1 1.8 2.6a8.3 8.3 0 0 1 0 6.2Z"
			/>
		</svg>'
		),
		"arrow" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
		>
			<path
				fill="currentColor"
				d="m12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8l-8-8z"
			/>
		</svg>'
		),
		"caret" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 16 16"
		>
			<path
				fill="currentColor"
				d="M6 12.796V3.204L11.481 8L6 12.796zm.659.753l5.48-4.796a1 1 0 0 0 0-1.506L6.66 2.451C6.011 1.885 5 2.345 5 3.204v9.592a1 1 0 0 0 1.659.753z"
			/>
		</svg>'
		),
		"roundIndicators" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
		>
			<path
				fill="currentColor"
				d="M16 12a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2Z"
			/>
		</svg>'
		),
		"squareIndicators" => ('<svg
			width="12"
			height="2"
			viewBox="0 0 12 2"
			fill="none"
			xmlns="http://www.w3.org/2000/svg"
		>
			<rect width="2" height="2" fill="currentColor" />
			<rect x="5" width="2" height="2" fill="currentColor" />
			<rect x="10" width="2" height="2" fill="currentColor" />
		</svg>'
		),
		"dashIndicators" => ('<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
		>
			<path
				fill="currentColor"
				d="M4 11h4v2H4v-2Zm6 0h4v2h-4v-2Zm10 0h-4v2h4v-2Z"
			/>
		</svg>'
		),
	);
	return $icons[$icon_name];
}
