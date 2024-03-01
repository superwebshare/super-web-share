/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody } from '@wordpress/components';
import { useEffect, useState } from 'react';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

import InputAlignment from './componets/input-alignment';
import InputSize from './componets/input-size';
import InputColor from './componets/input-color';
import InputText from './componets/input-text';
import InputIcon from './componets/input-icon';
import InputStyle from './componets/input-style';
import { sanitize } from '../helpers/helpers';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const blockProps = useBlockProps();
	const [iconName, setIconName] = useState(attributes.icon);
	const [icons, setIcons] = useState({});
	const styles = {
		backgroundColor: attributes?.color || color,
		boxSizing: 'border-box',
	};

	const buttonClasses = [
		'superwebshare_tada',
		'superwebshare_prompt',
		'superwebshare-button-default',
		'superwebshare_button_svg',
		'superwebshare-button-' + attributes.size,
		'superwebshare-button-' + attributes.style,
		attributes.className,
	];

	blockProps.style = {
		textAlign: attributes.align,
	};

	useEffect(() => {
		const cachedIcons = window.sessionStorage.getItem('sws_icons');

		if (!cachedIcons) {
			jQuery.ajax({
				url: wp?.ajax?.settings?.url || '/wp-admin/admin-ajax.php',
				data: {
					action: 'sws_get_icons',
				},
				success: function (d) {
					setIcons(d);
					window.sessionStorage.setItem('sws_icons', JSON.stringify(d));
				},
				error: function (err) {
					alert('Oh No, No something went wrong.');
				},
			});
		} else {
			setIcons(JSON.parse(cachedIcons));
		}
		return () => {};
	}, []);

	return [
		<InspectorControls>
			<PanelBody title="Appearance">
				<InputStyle {...{ attributes, setAttributes }} />
				<InputText {...{ attributes, setAttributes }} />
				<InputColor {...{ attributes, setAttributes }} />
				<InputAlignment {...{ attributes, setAttributes }} />
				<InputSize {...{ attributes, setAttributes }} />
				<InputIcon {...{ attributes, setAttributes }} />
			</PanelBody>
		</InspectorControls>,
		<div {...blockProps}>
			<span
				className={buttonClasses.join(' ')}
				style={styles}
				dangerouslySetInnerHTML={{
					__html: (icons[attributes.icon] || '⏳') + `<span>${sanitize(attributes.text)}</span>`,
				}}
			></span>
		</div>,
	];
}

// attributes
// clientId
// context
// insertBlocksAfter
// isSelected : false
// isSelectionEnabled : true
// mergeBlocks : function
// name : "Name"
// onRemove : function
//  onReplace
//
// toggleSelection
// __unstableLayoutClassNames
//  __unstableParentLayout
// {contentSize: '650px', wideSize: '1200px', type: 'constrained'}
