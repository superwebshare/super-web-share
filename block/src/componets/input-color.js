import { useState } from 'react';
import { ColorPalette } from '@wordpress/components';
export default function InputColor({ attributes, setAttributes }) {
	const [color, setColor] = useState(attributes?.color);
	const colors = [
		{ name: 'Default', color: '#BD3854' },
		{ name: 'Black', color: '#1d2327' },
		{ name: 'Blue', color: '#2271b1' },
		{ name: 'Turquoise', color: '#40E0D0' },
		{ name: 'Coral', color: '#FF7F50' },
		{ name: 'Navy', color: '#000080' },
	];

	return (
		<div className="components-base-control">
			<label className="sws-block-label">Background Color</label>
			<ColorPalette
				colors={colors}
				onChange={value => {
					if (value) {
						setColor(value);
						setAttributes({ color: value });
					}
				}}
				disableCustomColors={false}
				value={color}
				defaultValue="#BD3854"
				clearable={!1}
			/>
		</div>
	);
}
