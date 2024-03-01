import { useState } from 'react';
import { CustomSelectControl } from '@wordpress/components';
import metadata from '../block.json';

export default function InputStyle({ attributes, setAttributes }) {
	const [style, setStyle] = useState(attributes.style);

	const options = metadata?.attributes?.style?.enum.map(v => {
		return {
			key: v,
			name: v.toUpperCase(),
		};
	});

	return (
		<div className="components-base-control">
			<CustomSelectControl
				__nextUnconstrainedWidth
				label="Button Style"
				options={options}
				value={options.find(v => v.key == style)}
				onChange={({ selectedItem }) => {
					setStyle(selectedItem.size);
					setAttributes({ style: selectedItem.key });
				}}
			/>
		</div>
	);
}
