class GhubQueryAccordionExtension {
	constructor(container) {
		this.container = container;
		this.trigger = container.getAttribute("data-trigger");
		this.activeFirstItem = container.getAttribute("data-active-first-item");

		this.init();
	}

	init() {
		const queryAccordionItem = this.container.querySelectorAll(
			".ghub-query-accordion-item-container"
		);

		if ("true" === this.activeFirstItem) {
			queryAccordionItem[0].classList.add("ghub-query-accordion-active-item");
		}

		queryAccordionItem.forEach((item, index) => {
			if ("onclick" === this.trigger) {
				item.addEventListener("click", () => {
					if (item.classList.contains("ghub-query-accordion-active-item")) {
						return;
					}
					queryAccordionItem.forEach((item, idx) => {
						item.classList.remove("ghub-query-accordion-active-item");
					});
					item.classList.add("ghub-query-accordion-active-item");
				});
			}
			if ("onhover" === this.trigger) {
				item.addEventListener("mouseenter", () => {
					item.classList.add("ghub-query-accordion-active-item");
				});
				item.addEventListener("mouseleave", () => {
					queryAccordionItem.forEach((item, idx) => {
						item.classList.remove("ghub-query-accordion-active-item");
					});
				});
			}
		});
	}
}

window.addEventListener("DOMContentLoaded", () => {
	const ghubQueryAccordionContainer = document.querySelectorAll(
		".ghub-query-accordion-container"
	);

	ghubQueryAccordionContainer.forEach((container) => {
		new GhubQueryAccordionExtension(container);
	});
});
