import { useState } from 'react';
import { Icon } from '@wordpress/components';
export default function InputAlignment({ attributes, setAttributes }) {
	const [active, setActive] = useState(attributes.align);

	const options = [
		{
			name: 'start',
			icon: <Icon icon="align-left" />,
		},
		{
			name: 'center',
			icon: <Icon icon="align-center" />,
		},
		{
			name: 'end',
			icon: <Icon icon="align-right" />,
		},
	];

	const styleUl = {
		display: 'flex',
		width: '100%',
		justifyContent: 'flex-start',
		gap: '10px',
		margin: 0,
	};

	return (
		<div className="components-base-control">
			<label className="sws-block-label">ALIGN</label>
			<ul class="sws-input-alignment" style={styleUl}>
				{options.map(o => (
					<li
						key={o.name}
						className={o.name == active ? 'active' : ''}
						onClick={function () {
							setActive(o.name);
							setAttributes({ align: o.name });
						}}
						title={o.name.toUpperCase()}
					>
						{o.icon}
					</li>
				))}
			</ul>
		</div>
	);
}
