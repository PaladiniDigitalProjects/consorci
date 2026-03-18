/**
 * WordPress Dependencies
 */
import { assign, get } from 'lodash';
import { __ } from '@wordpress/i18n';
import { addFilter } from '@wordpress/hooks';
import { useEffect, useRef } from '@wordpress/element';
import { PanelBody } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { createHigherOrderComponent } from '@wordpress/compose';

/**
 * Custom Dependencies
 */
import { PostSelector } from '../components';

const withSelectivePostControl = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const isInitialRender = useRef(true);
		const postType = get(props, 'attributes.query.postType', 'post');
		const currentQuery = get(props, 'attributes.query', {});

		const currentSelectivePosts = get(
			currentQuery,
			'qlpspSelectivePosts',
			[]
		);

		const inherit = get(currentQuery, 'inherit', false);

		useEffect(() => {
			if (isInitialRender.current) {
				isInitialRender.current = false;
				return;
			}

			/** Resetting the selective posts, due to post type change. */
			props.setAttributes({
				query: {
					...currentQuery,
					qlpspSelectivePosts: [],
				},
			});
		}, [postType, inherit]);

		if ('core/query' !== props.name) {
			return <BlockEdit {...props} />;
		}

		return (
			<>
				<BlockEdit {...props} />
				{!inherit && (
					<InspectorControls>
						<PanelBody
							title={__(
								'Selective Posts',
								'query-loop-post-selector'
							)}
						>
							<PostSelector
								postType={postType}
								value={currentSelectivePosts}
								onChange={(newSelectivePosts) =>
									props.setAttributes({
										query: {
											...currentQuery,
											qlpspSelectivePosts:
												newSelectivePosts,
										},
									})
								}
							/>
						</PanelBody>
					</InspectorControls>
				)}
			</>
		);
	};
}, 'withSelectivePostControl');

addFilter(
	'editor.BlockEdit',
	'small-plugins/with-query-loop-selective-post-control',
	withSelectivePostControl
);
