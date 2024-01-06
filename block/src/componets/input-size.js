import { useState } from 'react';
import { CustomSelectControl } from '@wordpress/components';

export default function InputSize({ attributes, setAttributes }) {
	const [size, setSize] = useState(attributes.size);

	const options = [
		{
			key: 'small',
			name: 'Small',
			style: { fontSize: '80%' },
		},
		{
			key: 'medium',
			name: 'Medium',
			style: { fontSize: '100%' },
		},
		{
			key: 'large',
			name: 'Large',
			style: { fontSize: '120%' },
		},
	];

	return (
		<div className="components-base-control">
			<CustomSelectControl
				__nextUnconstrainedWidth
				label="Button Size"
				options={options}
				value={options.find(v => v.key == size)}
				onChange={({ selectedItem }) => {
					setSize(selectedItem.size);
					setAttributes({ size: selectedItem.key });
				}}
			/>
		</div>
	);
}
