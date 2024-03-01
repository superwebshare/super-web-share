import { sanitize } from '../helpers/helpers';
export default function Save({ attributes }) {
	let shortCodeAttrString = '';
	const clonedAttributes = Object.assign({}, attributes);

	for (let i in clonedAttributes) {
		let val = clonedAttributes[i];
		if (typeof val !== 'string') {
			continue;
		}
		val = val.replace('"', '\\"');
		shortCodeAttrString += `${i}="${sanitize(val)}" `;
	}

	return <>[super_web_share {shortCodeAttrString} ]</>;
}
