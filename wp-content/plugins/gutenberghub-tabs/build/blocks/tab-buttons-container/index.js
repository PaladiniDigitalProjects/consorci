/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@wordpress/icons/build-module/library/plus.js":
/*!********************************************************************!*\
  !*** ./node_modules/@wordpress/icons/build-module/library/plus.js ***!
  \********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/primitives */ "@wordpress/primitives");
/* harmony import */ var _wordpress_primitives__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__);


/**
 * WordPress dependencies
 */

const plus = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.SVG, {
  xmlns: "http://www.w3.org/2000/svg",
  viewBox: "0 0 24 24"
}, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_primitives__WEBPACK_IMPORTED_MODULE_1__.Path, {
  d: "M18 11.2h-5.2V6h-1.6v5.2H6v1.6h5.2V18h1.6v-5.2H18z"
}));
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (plus);
//# sourceMappingURL=plus.js.map

/***/ }),

/***/ "./src/blocks/tab-buttons-container/edit.js":
/*!**************************************************!*\
  !*** ./src/blocks/tab-buttons-container/edit.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_icons__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/icons */ "./node_modules/@wordpress/icons/build-module/library/plus.js");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _inspector__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./inspector */ "./src/blocks/tab-buttons-container/inspector.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _get_styles__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./get-styles */ "./src/blocks/tab-buttons-container/get-styles.js");
/* harmony import */ var _utils_get_parent_block__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ../../utils/get-parent-block */ "./src/utils/get-parent-block.js");
/* harmony import */ var _utils_get_block_type_ids__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ../../utils/get-block-type-ids */ "./src/utils/get-block-type-ids.js");

/**
 * wordpress dependencies
 */








/**
 * internal import
 */





function Edit(props) {
  const {
    attributes
  } = props;
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.useBlockProps)({
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()('gutenberghub-tab-buttons-container'),
    'data-trigger': attributes.trigger,
    style: (0,_get_styles__WEBPACK_IMPORTED_MODULE_8__.getStyles)(props.attributes)
  });
  const template = [['ghub/tab-button', {}, []]];
  const tabBlock = (0,_utils_get_parent_block__WEBPACK_IMPORTED_MODULE_9__.getParentBlock)(props.clientId, 'ghub/tabs-container');
  const blockTypeIds = (0,_utils_get_block_type_ids__WEBPACK_IMPORTED_MODULE_10__.getBlockTypeIds)(tabBlock?.clientId, 'ghub/tab-buttons-container');
  const shouldFallback = (0,lodash__WEBPACK_IMPORTED_MODULE_1__.head)(blockTypeIds) !== props.clientId;
  const isPatternModal = document.querySelector('.block-library-query-pattern__selection-modal');
  (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    props.setAttributes({
      shouldFallback
    });
  }, [shouldFallback]);
  if (shouldFallback && !isPatternModal) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      ...blockProps
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Placeholder, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Oops, Something went wrong.', 'ghub-tab'),
      instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('You cannot take tab buttons twice.', 'ghub-tab')
    }));
  }
  const insertTab = () => {
    const tabTemplate = [['ghub/tab-button', {}, []]];
    const contentTemplate = [['ghub/tab-content', {}, []]];
    const {
      insertBlocks
    } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.dispatch)('core/block-editor');
    const contentBlockIds = (0,_utils_get_block_type_ids__WEBPACK_IMPORTED_MODULE_10__.getBlockTypeIds)(tabBlock.clientId, 'ghub/tab-contents-container');
    const contentBlockId = (0,lodash__WEBPACK_IMPORTED_MODULE_1__.head)(contentBlockIds);
    const contentBlock = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.select)('core/block-editor').getBlock(contentBlockId);
    const insertionIndex = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.select)('core/block-editor').getBlock(props.clientId).innerBlocks.length + 1;
    const tabCreatedBlock = wp.blocks.createBlocksFromInnerBlocksTemplate(tabTemplate);
    const contentCreatedBlock = wp.blocks.createBlocksFromInnerBlocksTemplate(contentTemplate);
    insertBlocks(tabCreatedBlock, insertionIndex, props.clientId, true);
    insertBlocks(contentCreatedBlock, contentBlock.innerBlocks.length + 1, contentBlockId, true);
  };
  const CustomAppender = () => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
    onClick: insertTab,
    icon: _wordpress_icons__WEBPACK_IMPORTED_MODULE_11__["default"],
    variant: "secondary",
    className: "gutenberghub-tabs-appender"
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__.InnerBlocks, {
    template: template,
    allowedBlocks: ['ghub/tab-button'],
    renderAppender: CustomAppender
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_inspector__WEBPACK_IMPORTED_MODULE_6__["default"], {
    ...props
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Edit);

/***/ }),

/***/ "./src/blocks/tab-buttons-container/get-styles.js":
/*!********************************************************!*\
  !*** ./src/blocks/tab-buttons-container/get-styles.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getStyles: () => (/* binding */ getStyles)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../utils/styling-helpers */ "./src/utils/styling-helpers.js");


function getStyles(attributes) {
  const {
    tabsBorder,
    tabsBorderRadius,
    tabsTextColor,
    tabsBackgroundColor,
    tabsGradientBackground,
    tabsPadding,
    activeTabBorder,
    activeTabTextColor,
    activeTabBackgroundColor,
    activeTabGradientBackground,
    activeTabPadding,
    hoverTabTextColor,
    hoverTabBackgroundColor,
    hoverTabGradientBackground
  } = attributes;
  const tabsPaddingCss = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getSpacingCss)(tabsPadding);
  const tabsBorderVariables = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getBorderVariablesCss)(tabsBorder, 'tabs-button');
  const activeTabPaddingCss = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getSpacingCss)(activeTabPadding);
  const activeTabBorderVariables = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getBorderVariablesCss)(activeTabBorder, 'active-tab-button');
  let styles = {
    '--ghub-tabs-button-top-left-radius': tabsBorderRadius?.topLeft,
    '--ghub-tabs-button-top-right-radius': tabsBorderRadius?.topRight,
    '--ghub-tabs-button-bottom-left-radius': tabsBorderRadius?.bottomLeft,
    '--ghub-tabs-button-bottom-right-radius': tabsBorderRadius?.bottomRight,
    '--ghub-hover-tabs-button-bg-color': !(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(hoverTabBackgroundColor) ? hoverTabBackgroundColor : hoverTabGradientBackground,
    '--ghub-hover-tabs-button-text-color': hoverTabTextColor,
    '--ghub-tabs-button-bg-color': !(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(tabsBackgroundColor) ? tabsBackgroundColor : tabsGradientBackground,
    '--ghub-tabs-button-text-color': tabsTextColor,
    '--ghub-tabs-button-padding-top': tabsPaddingCss?.top,
    '--ghub-tabs-button-padding-right': tabsPaddingCss?.right,
    '--ghub-tabs-button-padding-bottom': tabsPaddingCss?.bottom,
    '--ghub-tabs-button-padding-left': tabsPaddingCss?.left,
    ...tabsBorderVariables,
    '--ghub-active-tab-button-bg-color': !(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(activeTabBackgroundColor) ? activeTabBackgroundColor : activeTabGradientBackground,
    '--ghub-active-tab-button-text-color': activeTabTextColor,
    '--ghub-active-tab-button-padding-top': activeTabPaddingCss?.top,
    '--ghub-active-tab-button-padding-right': activeTabPaddingCss?.right,
    '--ghub-active-tab-button-padding-bottom': activeTabPaddingCss?.bottom,
    '--ghub-active-tab-button-padding-left': activeTabPaddingCss?.left,
    ...activeTabBorderVariables
  };
  return (0,lodash__WEBPACK_IMPORTED_MODULE_0__.omitBy)(styles, value => value === false || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(value) || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isUndefined)(value) || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(value) === '' || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(value) === 'undefined undefined undefined');
}

/***/ }),

/***/ "./src/blocks/tab-buttons-container/index.js":
/*!***************************************************!*\
  !*** ./src/blocks/tab-buttons-container/index.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./editor.scss */ "./src/blocks/tab-buttons-container/editor.scss");
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./style.scss */ "./src/blocks/tab-buttons-container/style.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./src/blocks/tab-buttons-container/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save */ "./src/blocks/tab-buttons-container/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./block.json */ "./src/blocks/tab-buttons-container/block.json");





/**
 * Internal dependencies
 */



(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__.registerBlockType)(_block_json__WEBPACK_IMPORTED_MODULE_6__, {
  /**
   * @see ./edit.js
   */
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__["default"],
  /**
   * @see ./save.js
   */
  save: _save__WEBPACK_IMPORTED_MODULE_5__["default"],
  icon: (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("svg", {
    width: "300",
    height: "300",
    viewBox: "0 0 300 300",
    fill: "none",
    xmlns: "http://www.w3.org/2000/svg"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("path", {
    d: "M274.668 186.692C274.672 186.666 274.672 186.64 274.668 186.614L252.9 114.133C251.95 110.907 249.977 108.077 247.279 106.069C244.581 104.061 241.303 102.984 237.939 103H228.125C226.053 103 224.066 103.824 222.601 105.289C221.136 106.754 220.313 108.741 220.313 110.813C220.313 112.885 221.136 114.872 222.601 116.337C224.066 117.802 226.053 118.626 228.125 118.626H237.939L256.689 181.126H226.172L206.025 114.133C205.075 110.907 203.102 108.077 200.404 106.069C197.706 104.061 194.428 102.984 191.064 103H181.25C179.178 103 177.191 103.824 175.726 105.289C174.261 106.754 173.438 108.741 173.438 110.813C173.438 112.885 174.261 114.872 175.726 116.337C177.191 117.802 179.178 118.626 181.25 118.626H191.064L209.814 181.126H179.297L159.15 114.133C158.2 110.907 156.227 108.077 153.529 106.069C150.831 104.061 147.553 102.984 144.189 103H62.1094C58.7377 102.973 55.4489 104.045 52.7407 106.054C50.0325 108.063 48.0523 110.899 47.0996 114.133L25.3613 186.594V186.721C25.1361 187.439 25.0144 188.186 25 188.938C25 191.01 25.8231 192.997 27.2882 194.462C28.7534 195.927 30.7405 196.751 32.8125 196.751H267.188C268.405 196.75 269.606 196.465 270.694 195.918C271.782 195.371 272.728 194.577 273.454 193.6C274.181 192.623 274.669 191.489 274.88 190.29C275.091 189.09 275.018 187.858 274.668 186.692ZM62.1094 118.626H144.238L162.988 181.126H43.3105L62.1094 118.626Z",
    fill: "currentColor"
  }))
});

/***/ }),

/***/ "./src/blocks/tab-buttons-container/inspector.js":
/*!*******************************************************!*\
  !*** ./src/blocks/tab-buttons-container/inspector.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../../components */ "./src/components/index.js");

/**
 * WordPress Dependencies
 */





/**
 * Custom Dependencies
 */

function Inspector(props) {
  const triggerOptions = [{
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Click', 'gutenberghub-tabs'),
    value: 'click'
  }, {
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Hover', 'gutenberghub-tabs'),
    value: 'hover'
  }];
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('General', 'gutenberghub-tabs')
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.CustomToggleGroupControl, {
    isBlock: true,
    attributeKey: "trigger",
    options: triggerOptions,
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tabs Trigger', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Tip, null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Trigger will works only on frontend', 'gutenberghub-tabs')))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, {
    group: "color"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSetting, {
    attrKey: 'tabsTextColor',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Button Text Color', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSettingWithGradient, {
    attrBackgroundKey: 'tabsBackgroundColor',
    attrGradientKey: 'tabsGradientBackground',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Button Background', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSetting, {
    attrKey: 'activeTabTextColor',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Active Button Text Color', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSettingWithGradient, {
    attrBackgroundKey: 'activeTabBackgroundColor',
    attrGradientKey: 'activeTabGradientBackground',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Active Button Background', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSetting, {
    attrKey: 'hoverTabTextColor',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Hover Button Text Color', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.ColorSettingWithGradient, {
    attrBackgroundKey: 'hoverTabBackgroundColor',
    attrGradientKey: 'hoverTabGradientBackground',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Hover Button Background', 'gutenberghub-tabs')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, {
    group: "dimensions"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.DimensionControl, {
    showDefaultPadding: true,
    paddingAttributeKey: "tabsPadding",
    paddingLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab Buttons Padding', 'gutenberghub-tabs'),
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tabs Padding', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.DimensionControl, {
    showDefaultPadding: true,
    paddingLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Active Tab Button Padding', 'gutenberghub-tabs'),
    paddingAttributeKey: "activeTabPadding"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__.InspectorControls, {
    group: "border"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    showDefaultBorderRadius: true,
    attrBorderKey: "tabsBorder",
    attrBorderRadiusKey: "tabsBorderRadius",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab Buttons Border', 'gutenberghub-tabs'),
    borderRadiusLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Tab Buttons Border Radius', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_5__.BorderControl, {
    showDefaultBorder: true,
    isShowBorderRadius: false,
    attrBorderKey: "activeTabBorder",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Active Tab Button Border', 'gutenberghub-tabs')
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Inspector);

/***/ }),

/***/ "./src/blocks/tab-buttons-container/save.js":
/*!**************************************************!*\
  !*** ./src/blocks/tab-buttons-container/save.js ***!
  \**************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _get_styles__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./get-styles */ "./src/blocks/tab-buttons-container/get-styles.js");

/**
 * wordpress dependencies
 */


function Save(props) {
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save({
    className: 'gutenberghub-tab-buttons-container',
    style: (0,_get_styles__WEBPACK_IMPORTED_MODULE_2__.getStyles)(props.attributes),
    'data-trigger': props.attributes.trigger
  });
  if (props.attributes.shouldFallback) {
    return null;
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks.Content, null));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Save);

/***/ }),

/***/ "./src/components/border-control/index.js":
/*!************************************************!*\
  !*** ./src/components/border-control/index.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _utils_styling_helpers__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../utils/styling-helpers */ "./src/utils/styling-helpers.js");

/**
 * WordPress Dependencies
 */






function BorderControl({
  borderLabel,
  attrBorderKey,
  borderRadiusLabel,
  attrBorderRadiusKey,
  isShowBorder = true,
  isShowBorderRadius = true,
  showDefaultBorder = false,
  showDefaultBorderRadius = false
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => select('core/block-editor').getSelectedBlock().attributes);
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useDispatch)('core/block-editor');
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  const {
    defaultColors
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => {
    return {
      defaultColors: select('core/block-editor')?.getSettings()?.__experimentalFeatures?.color?.palette?.default
    };
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, isShowBorder && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultBorder,
    resetAllFilter: () => setAttributes({
      [attrBorderKey]: {}
    }),
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrBorderKey]),
    label: borderLabel,
    onDeselect: () => {
      setAttributes({
        [attrBorderKey]: {}
      });
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalBorderBoxControl, {
    enableAlpha: true,
    size: '__unstable-large',
    colors: defaultColors,
    label: borderLabel,
    onChange: newBorder => {
      setAttributes({
        [attrBorderKey]: newBorder
      });
    },
    value: attributes[attrBorderKey]
  })), isShowBorderRadius && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultBorderRadius,
    resetAllFilter: () => setAttributes({
      [attrBorderRadiusKey]: {}
    }),
    label: borderRadiusLabel,
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[attrBorderRadiusKey]),
    onDeselect: () => {
      setAttributes({
        [attrBorderRadiusKey]: {}
      });
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.BaseControl.VisualLabel, {
    as: "legend"
  }, borderRadiusLabel), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "ghub-custom-border-radius-control"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalBorderRadiusControl, {
    values: attributes[attrBorderRadiusKey],
    onChange: newBorderRadius => {
      const splitted = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_6__.splitBorderRadius)(newBorderRadius);
      setAttributes({
        [attrBorderRadiusKey]: splitted
      });
    }
  }))));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (BorderControl);

/***/ }),

/***/ "./src/components/color-settings/color-settings-with-gradient.js":
/*!***********************************************************************!*\
  !*** ./src/components/color-settings/color-settings-with-gradient.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */





/**
 *
 * @param {object} props - Color settings with gradients props
 * @param {string} props.label - Component Label
 * @param {string} props.attrBackgroundKey - Attribute key for background color
 * @param {string} props.attrGradientKey - Attribute key for gradient background color
 *
 */
function ColorSettingWithGradient(props) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)('core/block-editor');
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select('core/block-editor').getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => updateBlockAttributes(clientId, newAttributes);
  const colorGradientSettings = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalUseMultipleOriginColorsAndGradients)();
  const {
    defaultColors,
    defaultGradients
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return {
      defaultColors: select('core/block-editor')?.getSettings()?.__experimentalFeatures?.color?.palette?.default,
      defaultGradients: select('core/block-editor')?.getSettings()?.__experimentalFeatures?.color?.gradients?.default
    };
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalColorGradientSettingsDropdown, {
    ...colorGradientSettings,
    enableAlpha: true,
    panelId: clientId,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Color Settings', 'gutenberghub-tabs'),
    popoverProps: {
      placement: 'left start'
    },
    settings: [{
      colorValue: attributes[props.attrBackgroundKey],
      gradientValue: attributes[props.attrGradientKey],
      colors: defaultColors,
      gradients: defaultGradients,
      label: props.label,
      onColorChange: newValue => setAttributes({
        [props.attrBackgroundKey]: newValue
      }),
      onGradientChange: newValue => setAttributes({
        [props.attrGradientKey]: newValue
      })
    }]
  });
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ColorSettingWithGradient);

/***/ }),

/***/ "./src/components/color-settings/color-settings.js":
/*!*********************************************************!*\
  !*** ./src/components/color-settings/color-settings.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */





/**
 *
 * @param {object} props - Color settings with gradients props
 * @param {string} props.label - Component Label
 * @param {string} props.attrKey - Attribute key for color
 *
 */
function ColorSetting(props) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)('core/block-editor');
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select('core/block-editor').getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => updateBlockAttributes(clientId, newAttributes);
  const colorGradientSettings = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalUseMultipleOriginColorsAndGradients)();
  const {
    defaultColors
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return {
      defaultColors: select('core/block-editor')?.getSettings()?.__experimentalFeatures?.color?.palette?.default
    };
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalColorGradientSettingsDropdown, {
    ...colorGradientSettings,
    enableAlpha: true,
    panelId: clientId,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Color Settings', 'gutenberghub-tabs'),
    popoverProps: {
      placement: 'left start'
    },
    settings: [{
      colorValue: attributes[props.attrKey],
      colors: defaultColors,
      label: props.label,
      onColorChange: newValue => setAttributes({
        [props.attrKey]: newValue
      })
    }]
  });
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (ColorSetting);

/***/ }),

/***/ "./src/components/color-settings/index.js":
/*!************************************************!*\
  !*** ./src/components/color-settings/index.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   ColorSetting: () => (/* reexport safe */ _color_settings__WEBPACK_IMPORTED_MODULE_0__["default"]),
/* harmony export */   ColorSettingWithGradient: () => (/* reexport safe */ _color_settings_with_gradient__WEBPACK_IMPORTED_MODULE_1__["default"])
/* harmony export */ });
/* harmony import */ var _color_settings__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./color-settings */ "./src/components/color-settings/color-settings.js");
/* harmony import */ var _color_settings_with_gradient__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./color-settings-with-gradient */ "./src/components/color-settings/color-settings-with-gradient.js");



/***/ }),

/***/ "./src/components/dimension-control/index.js":
/*!***************************************************!*\
  !*** ./src/components/dimension-control/index.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);

/**
 * WordPress Dependencies
 */





function DimensionControl({
  paddingLabel,
  paddingAttributeKey,
  showDefaultPadding = false
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.useBlockEditContext)();
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useSelect)(select => select('core/block-editor').getSelectedBlock().attributes);
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_4__.useDispatch)('core/block-editor');
  const setAttributes = newAttributes => {
    updateBlockAttributes(clientId, newAttributes);
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalToolsPanelItem, {
    panelId: clientId,
    isShownByDefault: showDefaultPadding,
    resetAllFilter: () => {
      setAttributes({
        [paddingAttributeKey]: {}
      });
    },
    className: 'tools-panel-item-spacing',
    label: paddingLabel,
    onDeselect: () => setAttributes({
      [paddingAttributeKey]: {}
    }),
    hasValue: () => !(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(attributes[paddingAttributeKey])
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.__experimentalSpacingSizesControl, {
    allowReset: true,
    label: paddingLabel,
    values: attributes[paddingAttributeKey],
    sides: ['top', 'right', 'bottom', 'left'],
    onChange: newValue => {
      setAttributes({
        [paddingAttributeKey]: newValue
      });
    }
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (DimensionControl);

/***/ }),

/***/ "./src/components/index.js":
/*!*********************************!*\
  !*** ./src/components/index.js ***!
  \*********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   BorderControl: () => (/* reexport safe */ _border_control__WEBPACK_IMPORTED_MODULE_1__["default"]),
/* harmony export */   ColorSetting: () => (/* reexport safe */ _color_settings__WEBPACK_IMPORTED_MODULE_0__.ColorSetting),
/* harmony export */   ColorSettingWithGradient: () => (/* reexport safe */ _color_settings__WEBPACK_IMPORTED_MODULE_0__.ColorSettingWithGradient),
/* harmony export */   CustomToggleGroupControl: () => (/* reexport safe */ _toggle_group_control__WEBPACK_IMPORTED_MODULE_3__["default"]),
/* harmony export */   DimensionControl: () => (/* reexport safe */ _dimension_control__WEBPACK_IMPORTED_MODULE_2__["default"])
/* harmony export */ });
/* harmony import */ var _color_settings__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./color-settings */ "./src/components/color-settings/index.js");
/* harmony import */ var _border_control__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./border-control */ "./src/components/border-control/index.js");
/* harmony import */ var _dimension_control__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./dimension-control */ "./src/components/dimension-control/index.js");
/* harmony import */ var _toggle_group_control__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./toggle-group-control */ "./src/components/toggle-group-control/index.js");





/***/ }),

/***/ "./src/components/toggle-group-control/index.js":
/*!******************************************************!*\
  !*** ./src/components/toggle-group-control/index.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);

/**
 * WordPress Dependencies
 */



/**
 *
 * @param {string} value - Group control selected value
 * @param {string} label - Group control label
 * @param {Array} options - Group control available options
 * @param {boolean} [isBlock=false] - Toggle group control prop
 * @param {boolean} [isAdaptiveWidth=false] - Toggle group control prop
 */
function CustomToggleGroupControl({
  label,
  options,
  attributeKey,
  isBlock = false,
  isAdaptiveWidth = false
}) {
  const {
    clientId
  } = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockEditContext)();
  const {
    updateBlockAttributes
  } = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useDispatch)('core/block-editor');
  const attributes = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_1__.useSelect)(select => {
    return select('core/block-editor').getBlockAttributes(clientId);
  });
  const setAttributes = newAttributes => updateBlockAttributes(clientId, newAttributes);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControl, {
    label: label,
    isBlock: isBlock,
    isAdaptiveWidth: isAdaptiveWidth,
    __nextHasNoMarginBottom: true,
    value: attributes[attributeKey],
    onChange: newValue => {
      setAttributes({
        [attributeKey]: newValue
      });
    }
  }, options.map(({
    value,
    icon = null,
    label
  }) => {
    return icon ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControlOptionIcon, {
      key: value,
      value: value,
      icon: icon,
      label: label
    }) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalToggleGroupControlOption, {
      key: value,
      value: value,
      label: label
    });
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (CustomToggleGroupControl);

/***/ }),

/***/ "./src/utils/get-block-type-ids.js":
/*!*****************************************!*\
  !*** ./src/utils/get-block-type-ids.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getBlockTypeIds: () => (/* binding */ getBlockTypeIds)
/* harmony export */ });
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);



/**
 * Provides the client ids of a specific block type appended in the given root block.
 *
 * @param {string} clientId - Client id of the block.
 * @param {string} blockType - Block type name.
 */
function getBlockTypeIds(clientId, blockType) {
  const block = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_0__.select)('core/block-editor').getBlock(clientId);
  let clientIds = [];
  for (let index = 0; index < block?.innerBlocks.length; index++) {
    const currentBlock = block?.innerBlocks[index];
    if (currentBlock.name === blockType) {
      clientIds.push(currentBlock.clientId);
    } else if (!(0,lodash__WEBPACK_IMPORTED_MODULE_1__.isEmpty)(currentBlock?.innerBlocks)) {
      // Finding recursively.
      clientIds.push(...getBlockTypeIds(currentBlock.clientId, blockType));
    }
  }
  return clientIds;
}

/***/ }),

/***/ "./src/utils/get-parent-block.js":
/*!***************************************!*\
  !*** ./src/utils/get-parent-block.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getParentBlock: () => (/* binding */ getParentBlock)
/* harmony export */ });
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_0__);


/**
 *
 * @param {string} clientId - Block Client id
 * @param {string} slug - Parent block slug to find
 * @returns
 */
function getParentBlock(clientId, nameToFind) {
  const block = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_0__.select)('core/block-editor').getBlock(clientId);
  if (!block) return null; // No block selected or reached top-level block

  // Check if the current block has a specific attribute (e.g., custom attribute) with the desired name
  if (block.name === nameToFind) {
    return block;
  }

  // Check if the current block is not required block
  if (block) {
    const parentBlockClientId = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_0__.select)('core/block-editor').getBlockRootClientId(block.clientId);
    return parentBlockClientId ? getParentBlock(parentBlockClientId, nameToFind) : null; // Recursively find the parent
  }

  // If there's no, this is the top-level block
  return null;
}

/***/ }),

/***/ "./src/utils/styling-helpers.js":
/*!**************************************!*\
  !*** ./src/utils/styling-helpers.js ***!
  \**************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getBorderCSS: () => (/* binding */ getBorderCSS),
/* harmony export */   getBorderVariablesCss: () => (/* binding */ getBorderVariablesCss),
/* harmony export */   getDimensionCSS: () => (/* binding */ getDimensionCSS),
/* harmony export */   getSingleSideBorderValue: () => (/* binding */ getSingleSideBorderValue),
/* harmony export */   getSpacingCss: () => (/* binding */ getSpacingCss),
/* harmony export */   getSpacingPresetCssVar: () => (/* binding */ getSpacingPresetCssVar),
/* harmony export */   hasMixedValues: () => (/* binding */ hasMixedValues),
/* harmony export */   isValueSpacingPreset: () => (/* binding */ isValueSpacingPreset),
/* harmony export */   splitBorderRadius: () => (/* binding */ splitBorderRadius)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/**
 * WordPress dependencies
 */


/**
 * Function that helps you to generate top right bottom left css.
 *
 * @param {object} object object has top right bottom left css
 *
 * @return {{ css:object }} A css object
 */
const getDimensionCSS = object => {
  let css = {};
  for (const [key, value] of Object.entries(object)) {
    css[key] = value;
  }
  return css;
};

/**
 * Function that's help you to generate splitted or non splitted border CSS.
 * @param {object} object border attributes
 *
 * @return {{ css:object }} A css object
 */
const getBorderCSS = object => {
  let css = {};
  if (!(0,_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHasSplitBorders)(object)) {
    css['top'] = object;
    css['right'] = object;
    css['bottom'] = object;
    css['left'] = object;
    return css;
  }
  return object;
};
function getSingleSideBorderValue(border, side) {
  var _border$side$width, _border$side$style, _border$side$color;
  return `${(_border$side$width = border[side]?.width) !== null && _border$side$width !== void 0 ? _border$side$width : ''} ${border[side]?.width && (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(border[side]?.style) ? 'solid' : (_border$side$style = border[side]?.style) !== null && _border$side$style !== void 0 ? _border$side$style : ''} ${(_border$side$color = border[side]?.color) !== null && _border$side$color !== void 0 ? _border$side$color : ''}`;
}
function getBorderVariablesCss(border, slug) {
  const borderInFourDimension = getBorderCSS(border);
  const borderSides = ['top', 'right', 'bottom', 'left'];
  let borders = {};
  for (let i = 0; i < borderSides.length; i++) {
    const side = borderSides[i];
    const sideProperty = [`--ghub-${slug}-border-${side}`];
    const sideValue = getSingleSideBorderValue(borderInFourDimension, side);
    borders[sideProperty] = sideValue;
  }
  return borders;
}
/**
 *  Check values are mixed.
 * @param {any} values - value string or object
 * @returns true | false
 */
function hasMixedValues(values = {}) {
  return typeof values === 'string';
}
function splitBorderRadius(value) {
  const isValueMixed = hasMixedValues(value);
  const splittedBorderRadius = {
    topLeft: value,
    topRight: value,
    bottomLeft: value,
    bottomRight: value
  };
  return isValueMixed ? splittedBorderRadius : value;
}

/**
 * Checks is given value is a spacing preset.
 *
 * @param {string} value Value to check
 *
 * @return {boolean} Return true if value is string in format var:preset|spacing|.
 */
function isValueSpacingPreset(value) {
  if (!value?.includes) {
    return false;
  }
  return value === '0' || value.includes('var:preset|spacing|');
}

/**
 * Converts a spacing preset into a custom value.
 *
 * @param {string} value Value to convert.
 *
 * @return {string | undefined} CSS var string for given spacing preset value.
 */
function getSpacingPresetCssVar(value) {
  if (!value) {
    return;
  }
  const slug = value.match(/var:preset\|spacing\|(.+)/);
  if (!slug) {
    return value;
  }
  return `var(--wp--preset--spacing--${slug[1]})`;
}
function getSpacingCss(object) {
  let css = {};
  for (const [key, value] of Object.entries(object)) {
    if (isValueSpacingPreset(value)) {
      css[key] = getSpacingPresetCssVar(value);
    } else {
      css[key] = value;
    }
  }
  return css;
}

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ ((module, exports) => {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
	Copyright (c) 2018 Jed Watson.
	Licensed under the MIT License (MIT), see
	http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;
	var nativeCodeString = '[native code]';

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString !== Object.prototype.toString && !arg.toString.toString().includes('[native code]')) {
					classes.push(arg.toString());
					continue;
				}

				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./src/blocks/tab-buttons-container/editor.scss":
/*!******************************************************!*\
  !*** ./src/blocks/tab-buttons-container/editor.scss ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/blocks/tab-buttons-container/style.scss":
/*!*****************************************************!*\
  !*** ./src/blocks/tab-buttons-container/style.scss ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ ((module) => {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ ((module) => {

"use strict";
module.exports = window["lodash"];

/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blockEditor"];

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "@wordpress/primitives":
/*!************************************!*\
  !*** external ["wp","primitives"] ***!
  \************************************/
/***/ ((module) => {

"use strict";
module.exports = window["wp"]["primitives"];

/***/ }),

/***/ "./src/blocks/tab-buttons-container/block.json":
/*!*****************************************************!*\
  !*** ./src/blocks/tab-buttons-container/block.json ***!
  \*****************************************************/
/***/ ((module) => {

"use strict";
module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"ghub/tab-buttons-container","version":"1.0.0","title":"Tab Buttons","category":"ghub-products","description":"Empowering you to add and style separate tabs buttons, providing flexibility and creativity in content organization.","keywords":["tab buttons","buttons"],"attributes":{"tabsBorder":{"type":"object","default":{}},"tabsBorderRadius":{"type":"object","default":{}},"tabsTextColor":{"type":"string","default":null},"tabsBackgroundColor":{"type":"string","default":null},"tabsGradientBackground":{"type":"string","default":null},"tabsPadding":{"type":"object","default":{"top":"10px","right":"20px","bottom":"10px","left":"20px"}},"activeTabBorder":{"type":"object","default":{}},"activeTabTextColor":{"type":"string","default":null},"activeTabBackgroundColor":{"type":"string","default":null},"activeTabGradientBackground":{"type":"string","default":null},"activeTabPadding":{"type":"object","default":{}},"trigger":{"type":"string","default":"click"},"shouldFallback":{"type":"boolean","default":false},"hoverTabTextColor":{"type":"string","default":null},"hoverTabBackgroundColor":{"type":"string","default":null},"hoverTabGradientBackground":{"type":"string","default":null}},"supports":{"__experimentalLayout":{"allowJustification":true,"allowOrientation":true,"allowInheriting":false,"allowSizingOnChildren":false,"allowSwitching":false,"allowVerticalAlignment":true,"allowEditing":true,"default":{"type":"flex"}},"layout":{"allowJustification":true,"allowOrientation":true,"allowInheriting":false,"allowSizingOnChildren":false,"allowSwitching":false,"allowVerticalAlignment":true,"allowEditing":true,"default":{"type":"flex"}},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}},"html":false,"color":{"text":false,"background":true,"gradients":true,"link":false},"spacing":{"padding":true,"margin":true,"blockGap":true,"__experimentalDefaultControls":{"blockGap":true}},"typography":{"fontSize":true,"lineHeight":true},"align":true},"ancestor":["ghub/tabs-container"],"textdomain":"gutenberghub-tabs","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

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
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
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
/******/ 			"blocks/tab-buttons-container/index": 0,
/******/ 			"blocks/tab-buttons-container/style-index": 0
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
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
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
/******/ 		var chunkLoadingGlobal = self["webpackChunkgutenberghub_tabs"] = self["webpackChunkgutenberghub_tabs"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["blocks/tab-buttons-container/style-index"], () => (__webpack_require__("./src/blocks/tab-buttons-container/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map