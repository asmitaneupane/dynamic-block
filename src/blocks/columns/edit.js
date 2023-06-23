/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from "@wordpress/i18n";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	useBlockProps,
	ColorPalette,
	InspectorControls,
	InnerBlocks,
} from "@wordpress/block-editor";
import { useSelect } from "@wordpress/data";

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import "./editor.scss";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {WPElement} Element to render.
 */
export default function Edit({
	attributes: { bgColor, textColor },
	setAttributes,
}) {
	const posts = useSelect((select) => {
		return select("core").getEntityRecords("postType", "post", {
			per_page: 10,
		});
	}, []);
	console.log(posts);

	const onChangeBGColor = (hexColor) => {
		setAttributes({ bgColor: hexColor });
	};
	const onChangeTextColor = (newColor) => {
		setAttributes({ textColor: newColor });
	};

	return (
		<div {...useBlockProps()}>
			<InspectorControls key="setting">
				<fieldset>
					<legend className="blocks-base-control__label">
						{__("Background Color")}
					</legend>
					<ColorPalette onChange={onChangeBGColor} />
				</fieldset>
				<fieldset>
					<legend className="blocks-base-control__label">
						{__("Text Color")}
					</legend>
					<ColorPalette onChange={onChangeTextColor} />
				</fieldset>
			</InspectorControls>
			<InnerBlocks
				template={[
					["create-block/column", {}],
					["create-block/column", {}],
				]}
				allowedBlocks={["create-block/column"]}
				templateLock="all"
				orientation="horizontal"
				className="dynamic-column-block"
			/>
		</div>
	);
}
