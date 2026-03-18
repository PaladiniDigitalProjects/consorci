<?php

function gutenberghub_get_query_accordion_datasets($attributes)
{
	return sprintf(
		'%1$s %2$s',
		array_key_exists('ghubQaTriggers', $attributes) ? 'data-trigger=' . $attributes['ghubQaTriggers'] : 'data-trigger=onhover', //2
		array_key_exists('ghubQaActiveFirstItem', $attributes) ? 'data-active-first-item=true ' : 'data-active-first-item=false', //3
	);
}

function gutenberghub_style_variables($attributes)
{
	return sprintf(
		'style="%1$s%2$s%3$s%4$s"',
		array_key_exists('ghubQaHeight', $attributes) ? '--ghubQa-accordion-height:' . $attributes['ghubQaHeight'] . 'px' . ';' : "", //1
		array_key_exists('ghubQaGap', $attributes) ? '--ghubQa-accordion-gap:' . $attributes['ghubQaGap'] . 'px' . ';' : "", //2
		array_key_exists('ghubQaSpeed', $attributes) ? '--ghubQa-accordion-speed:' . $attributes['ghubQaSpeed'] . 's' . ';' : "", //3
		array_key_exists('ghubQaActiveItemSize', $attributes) ? '--ghubQa-accordion-active-item-size:' . $attributes['ghubQaActiveItemSize'] . ';' : "", //4
	);
}
