import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";
import metadata from "./block.json";

console.log("console");
(() => {
	registerBlockType("create-block/column", {
		category: "Dynamic Blocks",
		...metadata,
		edit: Edit,
	});
})();