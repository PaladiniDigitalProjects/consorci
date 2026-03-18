/**
 * WordPress Dependencies
 */
import { useSelect } from '@wordpress/data';
import { safeHTML } from '@wordpress/dom';
import { __, sprintf } from '@wordpress/i18n';
import { toString, capitalize, unescape } from 'lodash';
import { useState, useEffect } from '@wordpress/element';
import { FormTokenField, Spinner } from '@wordpress/components';

/**
 * Internal Dependencies
 */
import { isJSON } from '../../utils';

/**
 * A custom post selector component that renders a search bar
 * along with a dropdown so user can select posts leveraging the LinkControl behind the scenes.
 */
function PostSelector(props) {
	const [search, setSearch] = useState('');
	const [selectedPosts, setSelectedPosts] = useState([]);

	const { posts } = useSelect(
		(select) => {
			const queryArgs = { search, search_columns: ['post_title'] };
			const selectorArgs = ['postType', props.postType, queryArgs];

			const isNumeric = !isNaN(parseInt(search));

			if (isNumeric) {
				const parsedSearchId = parseInt(search);
				queryArgs.include = [parsedSearchId];
				delete queryArgs.search;
				delete queryArgs.search_columns;
			}

			return {
				posts: select('core').getEntityRecords(...selectorArgs),
			};
		},
		[search, props.postType]
	);

	const decodeHtmlEntity = (string) => unescape(safeHTML(string));

	const finalPosts = Array.isArray(posts) ? posts : [];
	const postIds = finalPosts.map((post) => post?.id);

	const postTitles = finalPosts
		.map((post) => post?.title?.rendered)
		.map(decodeHtmlEntity);

	const selectedPostsTitles = props.value
		.map((post) => {
			return post?.title;
		})
		.map(decodeHtmlEntity);

	const normalizedPostType = capitalize(props.postType);

	return (
		<div className="qlpsp-post-selector">
			<FormTokenField
				suggestions={
					finalPosts
						?.map((post) => ({
							title: post?.title?.rendered,
							id: post?.id,
						}))
						.map((post) => JSON.stringify(post)) ?? []
				}
				value={props?.value?.map((post) => JSON.stringify(post)) ?? []}
				__experimentalExpandOnFocus
				__experimentalShowHowTo={false}
				displayTransform={(post) => {
					try {
						const parsedPost = JSON.parse(post);
						return parsedPost?.title + ` (ID: ${parsedPost?.id})`;
					} catch (error) {
						return post;
					}
				}}
				__experimentalRenderItem={({ item: post }) => {
					const parsedPost = JSON.parse(post);
					const title = decodeHtmlEntity(parsedPost?.title);
					const id = parsedPost?.id;
					return (
						<span
							style={{
								display: 'flex',
								flexDirection: 'row',
								justifyContent: 'space-between',
							}}
						>
							<span>{title}</span>
							<span>ID: {id}</span>
						</span>
					);
				}}
				onInputChange={setSearch}
				label={normalizedPostType}
				placeholder={sprintf(
					__('Select %s', 'query-loop-post-selector'),
					props.postType
				)}
				onChange={(newSelectedPosts) => {
					const withIds = newSelectedPosts.map((post) => {
						const parsedPost = JSON.parse(post);

						const isAlreadyAdded = props.value.find(
							(currentPost) => currentPost?.id === parsedPost?.id
						);

						if (isAlreadyAdded) {
							return isAlreadyAdded;
						}

						return parsedPost;
					});
					props.onChange(withIds);
				}}
			/>
		</div>
	);
}

export default PostSelector;
