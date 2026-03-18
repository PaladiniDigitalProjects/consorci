// packages/theme/src/postcss-plugins/ds-token-fallbacks.mjs
import _tokenFallbacks from "../prebuilt/js/design-token-fallbacks.mjs";
var tokenFallbacks = _tokenFallbacks;
function addFallbackToVar(cssValue) {
  return cssValue.replace(
    /var\(\s*(--wpds-[\w-]+)\s*\)/g,
    (match, tokenName) => {
      const fallback = tokenFallbacks[tokenName];
      return fallback !== void 0 ? `var(${tokenName}, ${fallback})` : match;
    }
  );
}
export {
  addFallbackToVar
};
//# sourceMappingURL=ds-token-fallbacks.mjs.map
