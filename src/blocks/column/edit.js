import { InnerBlocks } from "@wordpress/block-editor";

export default function Edit() {
  const ALLOWED_BLOCKS = [ 'core/image', 'core/paragraph' ];
  const TEMPLATE = [ [ 'core/columns', {}, [
    [ 'core/column', {}, [
        [ 'core/image' ],
    ] ],
    [ 'core/column', {}, [
        [ 'core/paragraph', { placeholder: 'Enter side content...' } ],
    ] ],
] ] ];
	return (
		<div>
        <InnerBlocks
          allowedBlocks={ ALLOWED_BLOCKS }
          template={TEMPLATE}
          templateLock={false}
        />
      </div>
	);
}