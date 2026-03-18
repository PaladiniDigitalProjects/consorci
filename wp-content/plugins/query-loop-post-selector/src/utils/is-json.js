/**
 * Checks if the provided value is a valid JSON string
 * @param {unknown} target - The value to check
 * @returns {boolean} True if the value is valid JSON, false otherwise
 */
function isJSON(target) {
	// Return false if target is not a string or is empty/null/undefined
	if (typeof target !== 'string' || !target) {
		return false;
	}

	try {
		// Attempt to parse the string as JSON
		JSON.parse(target);
		return true;
	} catch (error) {
		return false;
	}
}

export default isJSON;
