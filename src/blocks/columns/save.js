import { useBlockProps, InnerBlocks } from "@wordpress/block-editor";

export default function Save() {
	<div {...useBlockProps.save()}>
		<InnerBlocks.Content />
	</div>;
}
