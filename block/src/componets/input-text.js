import { useState } from 'react';
import { TextControl } from '@wordpress/components';
export default function InputText({ attributes, setAttributes }) {
	const [text, setText] = useState(attributes?.text);

	if (attributes.style != 'default') {
		return <></>;
	}

	return (
		<div className="components-base-control">
			<TextControl
				label="Share Text"
				value={text}
				onChange={value => {
					setText(value);
					setAttributes({ text: value });
				}}
			/>
		</div>
	);
}
