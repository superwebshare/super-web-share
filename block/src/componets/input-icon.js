import { useState, useEffect } from 'react';
import { TextControl } from '@wordpress/components';
export default function InputIcon({ attributes, setAttributes }) {
	const [icon, setIcon] = useState(attributes?.icon);
	const [icons, setIcons] = useState({});
	const iconElem = [];
	useEffect(function () {
		const icons = window.sessionStorage.getItem('sws_icons');

		setIcons(JSON.parse(icons));
	}, []);

	for (let i in icons) {
		iconElem.push(
			<li
				key={i}
				className={i == icon ? 'active' : ''}
				onClick={function () {
					setAttributes({ icon: i });
					setIcon(i);
				}}
				role="button"
			>
				<div dangerouslySetInnerHTML={{ __html: icons[i] }}></div>

				<div> {i.substring(6, i.length)}</div>
			</li>,
		);
	}

	return (
		<div className="components-base-control">
			<label className="sws-block-label">SHARE ICON</label>
			<ul className="sws-block-icons-list">{iconElem}</ul>
		</div>
	);
}
