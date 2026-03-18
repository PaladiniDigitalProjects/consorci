window.addEventListener("load", () => {
	const linkContainer = document.querySelectorAll(".has-ghub-link");
	function handleClick(container) {
		const isTextSelected = window.getSelection().toString();
		const url = container.getAttribute("data-ghub-url");

		if (!isTextSelected) {
			const target = container.classList.contains("ghub-link-new-tab")
				? "_blank"
				: "_self";

			const features = [];
			if (container.classList.contains("ghub-link-no-opener")) {
				features.push("noopener");
			}
			if (container.classList.contains("ghub-link-no-referrer")) {
				features.push("noreferrer");
			}

			window.open(url, target, features.join(","));
		}
	}

	if (linkContainer && linkContainer.length > 0) {
		linkContainer.forEach((container) => {
			const nestedLinks = container?.querySelectorAll("a");
			if (nestedLinks && nestedLinks.length > 0) {
				nestedLinks.forEach((nestedLink) => {
					nestedLink.addEventListener("click", (e) => e.stopPropagation());
				});
			}
			container.addEventListener("click", () => handleClick(container));
		});
	}
});
