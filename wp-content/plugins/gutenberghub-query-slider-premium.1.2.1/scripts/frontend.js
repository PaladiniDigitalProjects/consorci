window.addEventListener("load", () => {
	const sliderWrappers = document.querySelectorAll(".ghub-slider-container");
	sliderWrappers.forEach((wrapper, index) => {
		const slidesPerView = parseInt(wrapper.dataset.slidesperview);
		const autoplay = wrapper.dataset.autoplay === "true";
		const autoplayDelay = parseInt(wrapper.dataset.autoplaydelay);
		const slidesGap = parseInt(wrapper.dataset.slidesgap);
		const slidesSpeed = parseInt(wrapper.dataset.speed);
		const sliderDirection = wrapper.dataset.sliderdirection;
		const slidesLoop = wrapper.dataset.loop === "true";
		const sliderAutoHeight = wrapper.dataset.autoheight === "true";

		let config = {
			direction: sliderDirection,
			speed: slidesSpeed,
			grabCursor: true,
			spaceBetween: slidesGap,
			loop: slidesLoop,
			autoHeight: sliderAutoHeight,
			navigation: {
				nextEl: ".ghub-slider-next",
				prevEl: ".ghub-slider-prev",
				lockClass: "swiper",
				disabledClass: "swiper-disabled",
			},
			pagination: {
				clickable: true,
				type: "bullets",
				el: wrapper.querySelector(".ghub-slider-pagination"),
				dynamicBullets: true,
			},
			autoplay: {
				delay: autoplayDelay,
				pauseOnMouseEnter: true,
				disableOnInteraction: false,
			},
			breakpoints: {
				768: {
					slidesPerView: slidesPerView,
				},
			},
		};
		if (!autoplay) {
			delete config.autoplay;
		}
		function initializedSwiper() {
			const swiper = new Swiper(wrapper, config);
			let currentPage = 1;
			function addNewSlides() {
				const pagekey = wrapper.dataset.pagekey;
				const totalPages = Number(wrapper.dataset.totalpages);
				const maxPages = Number(wrapper.dataset.maxpages);
				const nextPageKey = pagekey + "=" + (currentPage + 1);

				if (maxPages !== -1 && currentPage >= maxPages) {
					return;
				}
				if (swiper.isEnd && currentPage < totalPages) {
					fetch(nextPageKey)
						.then((response) => response.text())
						.then((response) => {
							const parser = new DOMParser();
							const responseDocument = parser.parseFromString(
								response,
								"text/html"
							);
							const newSlidesWrapper =
								responseDocument.querySelectorAll(`.swiper-wrapper`)[index];
							const newSlides =
								newSlidesWrapper.querySelectorAll(".swiper-slide");

							newSlides.forEach((slide) => {
								swiper.appendSlide(slide);
							});
							currentPage++;
						})
						.catch((error) => {
							console.error(error);
						});
				}
			}
			swiper.on("slideChange", () => {
				addNewSlides();
			});
			addNewSlides();
		}
		let observer = new IntersectionObserver(
			(entries, observer) => {
				entries.forEach((entry) => {
					if (entry.isIntersecting) {
						initializedSwiper();
						observer.disconnect();
					}
				});
			},
			{ threshold: 0, rootMargin: "0px" }
		);
		observer.observe(wrapper);
	});
});
