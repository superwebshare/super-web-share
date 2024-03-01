/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./helpers/helpers.js":
/*!****************************!*\
  !*** ./helpers/helpers.js ***!
  \****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   sanitize: () => (/* binding */ sanitize)
/* harmony export */ });
const sanitize = val => val.replace(/[\[\]"']+/g, '');

/***/ }),

/***/ "./src/componets/input-alignment.js":
/*!******************************************!*\
  !*** ./src/componets/input-alignment.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputAlignment)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function InputAlignment({
  attributes,
  setAttributes
}) {
  const [active, setActive] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes.align);
  const options = [{
    name: 'start',
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
      icon: "align-left"
    })
  }, {
    name: 'center',
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
      icon: "align-center"
    })
  }, {
    name: 'end',
    icon: (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Icon, {
      icon: "align-right"
    })
  }];
  const styleUl = {
    display: 'flex',
    width: '100%',
    justifyContent: 'flex-start',
    gap: '10px',
    margin: 0
  };
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "sws-block-label"
  }, "ALIGN"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    class: "sws-input-alignment",
    style: styleUl
  }, options.map(o => (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
    key: o.name,
    className: o.name == active ? 'active' : '',
    onClick: function () {
      setActive(o.name);
      setAttributes({
        align: o.name
      });
    },
    title: o.name.toUpperCase()
  }, o.icon))));
}

/***/ }),

/***/ "./src/componets/input-color.js":
/*!**************************************!*\
  !*** ./src/componets/input-color.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputColor)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function InputColor({
  attributes,
  setAttributes
}) {
  const [color, setColor] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes?.color);
  const colors = [{
    name: 'Default',
    color: '#BD3854'
  }, {
    name: 'Black',
    color: '#1d2327'
  }, {
    name: 'Blue',
    color: '#2271b1'
  }, {
    name: 'Turquoise',
    color: '#40E0D0'
  }, {
    name: 'Coral',
    color: '#FF7F50'
  }, {
    name: 'Navy',
    color: '#000080'
  }];
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "sws-block-label"
  }, "Background Color"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorPalette, {
    colors: colors,
    onChange: value => {
      if (value) {
        setColor(value);
        setAttributes({
          color: value
        });
      }
    },
    disableCustomColors: false,
    value: color,
    defaultValue: "#BD3854",
    clearable: !1
  }));
}

/***/ }),

/***/ "./src/componets/input-icon.js":
/*!*************************************!*\
  !*** ./src/componets/input-icon.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputIcon)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function InputIcon({
  attributes,
  setAttributes
}) {
  const [icon, setIcon] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes?.icon);
  const [icons, setIcons] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({});
  const iconElem = [];
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(function () {
    const icons = window.sessionStorage.getItem('sws_icons');
    setIcons(JSON.parse(icons));
  }, []);
  for (let i in icons) {
    iconElem.push((0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      key: i,
      className: i == icon ? 'active' : '',
      onClick: function () {
        setAttributes({
          icon: i
        });
        setIcon(i);
      },
      role: "button"
    }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      dangerouslySetInnerHTML: {
        __html: icons[i]
      }
    }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", null, " ", i.substring(6, i.length))));
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: "sws-block-label"
  }, "SHARE ICON"), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    className: "sws-block-icons-list"
  }, iconElem));
}

/***/ }),

/***/ "./src/componets/input-size.js":
/*!*************************************!*\
  !*** ./src/componets/input-size.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputSize)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function InputSize({
  attributes,
  setAttributes
}) {
  const [size, setSize] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes.size);
  const options = [{
    key: 'small',
    name: 'Small',
    style: {
      fontSize: '80%'
    }
  }, {
    key: 'medium',
    name: 'Medium',
    style: {
      fontSize: '100%'
    }
  }, {
    key: 'large',
    name: 'Large',
    style: {
      fontSize: '120%'
    }
  }];
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.CustomSelectControl, {
    __nextUnconstrainedWidth: true,
    label: "Button Size",
    options: options,
    value: options.find(v => v.key == size),
    onChange: ({
      selectedItem
    }) => {
      setSize(selectedItem.size);
      setAttributes({
        size: selectedItem.key
      });
    }
  }));
}

/***/ }),

/***/ "./src/componets/input-style.js":
/*!**************************************!*\
  !*** ./src/componets/input-style.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputStyle)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../block.json */ "./src/block.json");




function InputStyle({
  attributes,
  setAttributes
}) {
  const [style, setStyle] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes.style);
  const options = _block_json__WEBPACK_IMPORTED_MODULE_2__?.attributes?.style?.enum.map(v => {
    return {
      key: v,
      name: v.toUpperCase()
    };
  });
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.CustomSelectControl, {
    __nextUnconstrainedWidth: true,
    label: "Button Style",
    options: options,
    value: options.find(v => v.key == style),
    onChange: ({
      selectedItem
    }) => {
      setStyle(selectedItem.size);
      setAttributes({
        style: selectedItem.key
      });
    }
  }));
}

/***/ }),

/***/ "./src/componets/input-text.js":
/*!*************************************!*\
  !*** ./src/componets/input-text.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ InputText)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function InputText({
  attributes,
  setAttributes
}) {
  const [text, setText] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes?.text);
  if (attributes.style != 'default') {
    return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null);
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "components-base-control"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.TextControl, {
    label: "Share Text",
    value: text,
    onChange: value => {
      setText(value);
      setAttributes({
        text: value
      });
    }
  }));
}

/***/ }),

/***/ "./src/edit.js":
/*!*********************!*\
  !*** ./src/edit.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Edit)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./editor.scss */ "./src/editor.scss");
/* harmony import */ var _componets_input_alignment__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./componets/input-alignment */ "./src/componets/input-alignment.js");
/* harmony import */ var _componets_input_size__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./componets/input-size */ "./src/componets/input-size.js");
/* harmony import */ var _componets_input_color__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./componets/input-color */ "./src/componets/input-color.js");
/* harmony import */ var _componets_input_text__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./componets/input-text */ "./src/componets/input-text.js");
/* harmony import */ var _componets_input_icon__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./componets/input-icon */ "./src/componets/input-icon.js");
/* harmony import */ var _componets_input_style__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./componets/input-style */ "./src/componets/input-style.js");
/* harmony import */ var _helpers_helpers__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ../helpers/helpers */ "./helpers/helpers.js");

/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */


/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */





/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */









/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
function Edit({
  attributes,
  setAttributes
}) {
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)();
  const [iconName, setIconName] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(attributes.icon);
  const [icons, setIcons] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)({});
  const styles = {
    backgroundColor: attributes?.color || color,
    boxSizing: 'border-box'
  };
  const buttonClasses = ['superwebshare_tada', 'superwebshare_prompt', 'superwebshare-button-default', 'superwebshare_button_svg', 'superwebshare-button-' + attributes.size, 'superwebshare-button-' + attributes.style, attributes.className];
  blockProps.style = {
    textAlign: attributes.align
  };
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const cachedIcons = window.sessionStorage.getItem('sws_icons');
    if (!cachedIcons) {
      jQuery.ajax({
        url: wp?.ajax?.settings?.url || '/wp-admin/admin-ajax.php',
        data: {
          action: 'sws_get_icons'
        },
        success: function (d) {
          setIcons(d);
          window.sessionStorage.setItem('sws_icons', JSON.stringify(d));
        },
        error: function (err) {
          alert('Oh No, No something went wrong.');
        }
      });
    } else {
      setIcons(JSON.parse(cachedIcons));
    }
    return () => {};
  }, []);
  return [(0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InspectorControls, null, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: "Appearance"
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_style__WEBPACK_IMPORTED_MODULE_10__["default"], {
    attributes,
    setAttributes
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_text__WEBPACK_IMPORTED_MODULE_8__["default"], {
    attributes,
    setAttributes
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_color__WEBPACK_IMPORTED_MODULE_7__["default"], {
    attributes,
    setAttributes
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_alignment__WEBPACK_IMPORTED_MODULE_5__["default"], {
    attributes,
    setAttributes
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_size__WEBPACK_IMPORTED_MODULE_6__["default"], {
    attributes,
    setAttributes
  }), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(_componets_input_icon__WEBPACK_IMPORTED_MODULE_9__["default"], {
    attributes,
    setAttributes
  }))), (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: buttonClasses.join(' '),
    style: styles,
    dangerouslySetInnerHTML: {
      __html: (icons[attributes.icon] || '⏳') + `<span>${(0,_helpers_helpers__WEBPACK_IMPORTED_MODULE_11__.sanitize)(attributes.text)}</span>`
    }
  }))];
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

/***/ }),

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./style.scss */ "./src/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./src/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./src/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./src/save.js");
/**
 * Registers a new block provided a unique name and an object defining its behavior.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */


/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * All files containing `style` keyword are bundled together. The code used
 * gets applied both to the front of your site and to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */


/**
 * Internal dependencies
 */




/**
 * Every block starts by registering a new block type definition.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-registration/
 */
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_3__.name, {
  /**
   * @see ./edit.js
   */
  attributes: _block_json__WEBPACK_IMPORTED_MODULE_3__.attributes,
  example: {
    attributes: {
      className: 'on-block-preview'
    }
  },
  edit: _edit__WEBPACK_IMPORTED_MODULE_2__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_4__["default"]
});

/***/ }),

/***/ "./src/save.js":
/*!*********************!*\
  !*** ./src/save.js ***!
  \*********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (/* binding */ Save)
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _helpers_helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../helpers/helpers */ "./helpers/helpers.js");


function Save({
  attributes
}) {
  let shortCodeAttrString = '';
  const clonedAttributes = Object.assign({}, attributes);
  for (let i in clonedAttributes) {
    let val = clonedAttributes[i];
    if (typeof val !== 'string') {
      continue;
    }
    val = val.replace('"', '\\"');
    shortCodeAttrString += `${i}="${(0,_helpers_helpers__WEBPACK_IMPORTED_MODULE_1__.sanitize)(val)}" `;
  }
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.createElement)(react__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, "[super_web_share ", shortCodeAttrString, " ]");
}

/***/ }),

/***/ "./src/editor.scss":
/*!*************************!*\
  !*** ./src/editor.scss ***!
  \*************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/style.scss":
/*!************************!*\
  !*** ./src/style.scss ***!
  \************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

module.exports = window["React"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./src/block.json":
/*!************************!*\
  !*** ./src/block.json ***!
  \************************/
/***/ ((module) => {

module.exports = /*#__PURE__*/JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":3,"name":"create-block/super-web-share-block","version":"0.1.0","title":"Super Web Share Block","category":"widgets","icon":"share","description":"Super Web share block editor","example":{},"supports":{"html":true},"keywords":["share","native share","facebook","twitter","whatsapp","mobile"],"textdomain":"super-web-share","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css","render":"file:./render.php","attributes":{"type":{"type":"string","default":"inline"},"color":{"type":"string","default":"#BD3854"},"text":{"type":"string","default":"Share"},"icon":{"type":"string","default":"share-icon-1"},"style":{"type":"string","enum":["default","curved","square","circle"],"default":"default"},"size":{"type":"string","enum":["large","medium","small"],"default":"large"},"align":{"type":"string","enum":["start","center","end"],"default":"start"},"fallback":{"type":"boolean","default":true},"className":{"type":"string","default":""},"metadata":{"type":"object"}}}');

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"./style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = globalThis["webpackChunksuper_web_share_block"] = globalThis["webpackChunksuper_web_share_block"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["./style-index"], () => (__webpack_require__("./src/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map