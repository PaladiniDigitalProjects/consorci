// packages/theme/src/postcss-plugins/add-fallback-to-var.ts
function addFallbackToVar(cssValue, tokenFallbacks) {
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
//# sourceMappingURL=add-fallback-to-var.mjs.map
