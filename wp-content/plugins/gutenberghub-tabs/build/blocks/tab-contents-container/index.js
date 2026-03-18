/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/blocks/tab-contents-container/edit.js":
/*!***************************************************!*\
  !*** ./src/blocks/tab-contents-container/edit.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _inspector__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./inspector */ "./src/blocks/tab-contents-container/inspector.js");
/* harmony import */ var _get_styles__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./get-styles */ "./src/blocks/tab-contents-container/get-styles.js");
/* harmony import */ var _utils_get_parent_block__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../../utils/get-parent-block */ "./src/utils/get-parent-block.js");
/* harmony import */ var _utils_get_block_type_ids__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../../utils/get-block-type-ids */ "./src/utils/get-block-type-ids.js");

/**
 * wordpress dependencies
 */






/**
 * internal imports
 */




function Edit(props) {
  const blockProps = (0,_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.useBlockProps)({
    className: 'gutenberghub-tab-contents-container',
    style: (0,_get_styles__WEBPACK_IMPORTED_MODULE_6__.getStyles)(props.attributes)
  });
  const tabBlock = (0,_utils_get_parent_block__WEBPACK_IMPORTED_MODULE_7__.getParentBlock)(props.clientId, 'ghub/tabs-container');
  const blockTypeIds = (0,_utils_get_block_type_ids__WEBPACK_IMPORTED_MODULE_8__.getBlockTypeIds)(tabBlock?.clientId, 'ghub/tab-contents-container');
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
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Placeholder, {
      label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Oops, Something went wrong.', 'ghub-tab'),
      instructions: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('You cannot take tab contents twice.', 'ghub-tab')
    }));
  }
  const template = [['ghub/tab-content', {}, [['core/paragraph']]]];
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_2__.InnerBlocks, {
    template: template,
    renderAppender: false,
    allowedBlocks: ['ghub/tab-content']
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_inspector__WEBPACK_IMPORTED_MODULE_5__["default"], {
    ...props
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Edit);

/***/ }),

/***/ "./src/blocks/tab-contents-container/get-styles.js":
/*!*********************************************************!*\
  !*** ./src/blocks/tab-contents-container/get-styles.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   getStyles: () => (/* binding */ getStyles)
/* harmony export */ });
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../utils/styling-helpers */ "./src/utils/styling-helpers.js");


function getStyles(attributes) {
  const {
    contentsBorder,
    contentsBorderRadius,
    contentsTextColor,
    contentsBackgroundColor,
    contentsGradientBackground,
    contentsPadding
  } = attributes;
  const contentsPaddingCss = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getSpacingCss)(contentsPadding);
  const contentBorderVariables = (0,_utils_styling_helpers__WEBPACK_IMPORTED_MODULE_1__.getBorderVariablesCss)(contentsBorder, 'content');
  let styles = {
    '--ghub-content-top-left-radius': contentsBorderRadius?.topLeft,
    '--ghub-content-top-right-radius': contentsBorderRadius?.topRight,
    '--ghub-content-bottom-left-radius': contentsBorderRadius?.bottomLeft,
    '--ghub-content-bottom-right-radius': contentsBorderRadius?.bottomRight,
    '--ghub-content-bg-color': !(0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(contentsBackgroundColor) ? contentsBackgroundColor : contentsGradientBackground,
    '--ghub-content-text-color': contentsTextColor,
    '--ghub-content-padding-top': contentsPaddingCss?.top,
    '--ghub-content-padding-right': contentsPaddingCss?.right,
    '--ghub-content-padding-bottom': contentsPaddingCss?.bottom,
    '--ghub-content-padding-left': contentsPaddingCss?.left,
    ...contentBorderVariables
  };
  return (0,lodash__WEBPACK_IMPORTED_MODULE_0__.omitBy)(styles, value => value === false || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isEmpty)(value) || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.isUndefined)(value) || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(value) === '' || (0,lodash__WEBPACK_IMPORTED_MODULE_0__.trim)(value) === 'undefined undefined undefined');
}

/***/ }),

/***/ "./src/blocks/tab-contents-container/index.js":
/*!****************************************************!*\
  !*** ./src/blocks/tab-contents-container/index.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _style_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./style.scss */ "./src/blocks/tab-contents-container/style.scss");
/* harmony import */ var _editor_scss__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./editor.scss */ "./src/blocks/tab-contents-container/editor.scss");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./src/blocks/tab-contents-container/edit.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./save */ "./src/blocks/tab-contents-container/save.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./block.json */ "./src/blocks/tab-contents-container/block.json");





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
    d: "M211.17 128.447C211.17 130.563 210.33 132.592 208.833 134.088C207.337 135.585 205.308 136.425 203.192 136.425H96.809C94.693 136.425 92.6636 135.585 91.1673 134.088C89.671 132.592 88.8303 130.563 88.8303 128.447C88.8303 126.33 89.671 124.301 91.1673 122.805C92.6636 121.308 94.693 120.468 96.809 120.468H203.192C205.308 120.468 207.337 121.308 208.833 122.805C210.33 124.301 211.17 126.33 211.17 128.447ZM203.192 163.021H96.809C94.693 163.021 92.6636 163.862 91.1673 165.358C89.671 166.854 88.8303 168.884 88.8303 171C88.8303 173.116 89.671 175.145 91.1673 176.641C92.6636 178.138 94.693 178.978 96.809 178.978H203.192C205.308 178.978 207.337 178.138 208.833 176.641C210.33 175.145 211.17 173.116 211.17 171C211.17 168.884 210.33 166.854 208.833 165.358C207.337 163.862 205.308 163.021 203.192 163.021ZM275 64.617V224.191C275 231.95 275 253.446 275 253.446H245.745H25L25.0002 224.311L25.0007 224.191V64.617V46H43.6177H256.383H275V64.617ZM259.043 64.617L259.042 61.9574H256.383H43.6177H40.958L40.9581 64.617V224.191V237.489H245.745C249.272 237.489 259.043 237.489 259.043 237.489C259.043 237.489 259.043 227.718 259.043 224.191V64.617Z",
    fill: "currentColor"
  }))
});

/***/ }),

/***/ "./src/blocks/tab-contents-container/inspector.js":
/*!********************************************************!*\
  !*** ./src/blocks/tab-contents-container/inspector.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../../components */ "./src/components/index.js");

/**
 * WordPress Dependencies
 */




/**
 * Custom Dependencies
 */

function Inspector(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "color"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_4__.ColorSetting, {
    attrKey: 'contentsTextColor',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Text Color', 'gutenberghub-tabs')
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_4__.ColorSettingWithGradient, {
    attrBackgroundKey: 'contentsBackgroundColor',
    attrGradientKey: 'contentsGradientBackground',
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Background', 'gutenberghub-tabs')
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "dimensions"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_4__.DimensionControl, {
    paddingLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Padding', 'gutenberghub-tabs'),
    label: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Padding', 'gutenberghub-tabs'),
    paddingAttributeKey: "contentsPadding"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_3__.InspectorControls, {
    group: "border"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components__WEBPACK_IMPORTED_MODULE_4__.BorderControl, {
    attrBorderKey: "contentsBorder",
    attrBorderRadiusKey: "contentsBorderRadius",
    borderLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Border', 'gutenberghub-tabs'),
    borderRadiusLabel: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.__)('Contents Border Radius', 'gutenberghub-tabs')
  })));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Inspector);

/***/ }),

/***/ "./src/blocks/tab-contents-container/save.js":
/*!***************************************************!*\
  !*** ./src/blocks/tab-contents-container/save.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _get_styles__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./get-styles */ "./src/blocks/tab-contents-container/get-styles.js");

/**
 * wordpress dependencies
 */


function Save(props) {
  const blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.useBlockProps.save({
    className: 'gutenberghub-tab-contents-container',
    style: (0,_get_styles__WEBPACK_IMPORTED_MODULE_2__.getStyles)(props.attributes)
  });
  if (props.attributes.shouldFallback) {
    return null;
  }
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    ...blockProps
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__.InnerBlocks.Content, {
    ...blockProps
  }));
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (Save);

/***/ }),

/***/ "./src/components/border-control/index.js":
/*!************************************************!*\
  !*** ./src/components/border-control/index.js ***!
  \************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

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

/***/ "./src/blocks/tab-contents-container/editor.scss":
/*!*******************************************************!*\
  !*** ./src/blocks/tab-contents-container/editor.scss ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/blocks/tab-contents-container/style.scss":
/*!******************************************************!*\
  !*** ./src/blocks/tab-contents-container/style.scss ***!
  \******************************************************/
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

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["lodash"];

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

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ ((module) => {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ ((module) => {

module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./src/blocks/tab-contents-container/block.json":
/*!******************************************************!*\
  !*** ./src/blocks/tab-contents-container/block.json ***!
  \******************************************************/
/***/ ((module) => {

module.exports = JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"ghub/tab-contents-container","version":"1.0.0","title":"Tab Contents","category":"ghub-products","description":"Add versatile content blocks inside tabs for flexible and organized information display.","keywords":["tabs contents","contents"],"attributes":{"contentsBorder":{"type":"object","default":{}},"contentsBorderRadius":{"type":"object","default":{}},"contentsTextColor":{"type":"string","default":null},"contentsBackgroundColor":{"type":"string","default":null},"contentsGradientBackground":{"type":"string","default":null},"shouldFallback":{"type":"boolean","default":false},"contentsPadding":{"type":"object","default":{"top":"10px","right":"20px","bottom":"10px","left":"20px"}}},"supports":{"html":false,"color":{"text":false,"background":false,"gradients":false,"link":false},"__experimentalBorder":{"color":true,"radius":true,"style":true,"width":true,"__experimentalDefaultControls":{"color":true,"radius":true,"style":true,"width":true}},"spacing":{"padding":true,"margin":true},"typography":{"fontSize":true,"lineHeight":true},"align":true},"ancestor":["ghub/tabs-container"],"textdomain":"gutenberghub-tabs","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');

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
/******/ 			"blocks/tab-contents-container/index": 0,
/******/ 			"blocks/tab-contents-container/style-index": 0
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
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["blocks/tab-contents-container/style-index"], () => (__webpack_require__("./src/blocks/tab-contents-container/index.js")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map