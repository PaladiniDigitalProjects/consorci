class GutenberghubTabs {
	constructor( container ) {
		this.tabContainer = container;
		this.init();
	}
	init() {
		this.storeNecessaryVariables();
		this.setActiveTab( 0 );
		this.collapsibleContainer.forEach( ( _, index ) => {
			if ( index === 0 ) {
				this.setActiveCollapsible( index );
			} else {
				this.removeActiveCollapsible( index );
			}
		} );
		this.attachEventHandler();
	}
	attachEventHandler() {
		this.tabButtons.forEach( ( tabButton, index ) => {
			if ( this.trigger === 'click' ) {
				tabButton.addEventListener( 'click', () => {
					this.tabButtons.forEach( ( _, tabIndex ) => {
						this.removeActiveTab( tabIndex );
						this.removeActiveCollapsible( tabIndex );
					} );
					this.setActiveTab( index );
					this.setActiveCollapsible( index );
				} );
			} else if ( this.trigger === 'hover' ) {
				tabButton.addEventListener( 'mouseover', () => {
					this.tabButtons.forEach( ( _, tabIndex ) => {
						this.removeActiveTab( tabIndex );
						this.removeActiveCollapsible( tabIndex );
					} );
					this.setActiveTab( index );
					this.setActiveCollapsible( index );
				} );
			}
		} );
	}
	removeActiveTab( activeIndex ) {
		this.tabButtons[ activeIndex ].classList.remove(
			'gutenberghub-active-tab'
		);
		this.tabContents[ activeIndex ].classList.remove(
			'gutenberghub-active-tab'
		);
	}
	setActiveTab( activeIndex ) {
		this.tabButtons[ activeIndex ].classList.add(
			'gutenberghub-active-tab'
		);
		this.tabContents[ activeIndex ].classList.add(
			'gutenberghub-active-tab'
		);
	}
	removeActiveCollapsible( index ) {
		if ( this.collapsibleHeights[ index ] ) {
			this.collapsibleContainer.forEach( ( _, containerIndex ) => {
				if ( this.collapsibleContainer[ index ][ containerIndex ] ) {
					this.collapsibleContainer[ index ][
						containerIndex
					].style.height = '0px';
				}
			} );
		}
		if ( this.collapsiblePadding[ index ] ) {
			this.collapsibleContainer.forEach( ( _, containerIndex ) => {
				if ( this.collapsibleContainer[ index ][ containerIndex ] ) {
					this.collapsibleContainer[ index ][
						containerIndex
					].style.padding = '0px';
				}
			} );
		}
	}
	setActiveCollapsible( index ) {
		if ( this.collapsibleHeights[ index ] ) {
			this.collapsibleContainer.forEach( ( _, containerIndex ) => {
				if ( this.collapsibleContainer[ index ][ containerIndex ] ) {
					this.collapsibleContainer[ index ][
						containerIndex
					].style.height =
						this.collapsibleHeights[ index ][ containerIndex ] +
						'px';
				}
			} );
		}
		if ( this.collapsiblePadding[ index ] ) {
			this.collapsibleContainer.forEach( ( _, containerIndex ) => {
				if ( this.collapsibleContainer[ index ][ containerIndex ] ) {
					this.collapsibleContainer[ index ][
						containerIndex
					].style.padding =
						this.collapsiblePadding[ index ][ containerIndex ];
				}
			} );
		}
	}
	storeNecessaryVariables() {
		const buttonsContainer = this.tabContainer.querySelector(
			'.gutenberghub-tab-buttons-container'
		);
		const contentsContainer = this.tabContainer.querySelector(
			'.gutenberghub-tab-contents-container'
		);

		this.tabButtons = buttonsContainer.querySelectorAll(
			'.gutenberghub-tab-button'
		);

		this.tabContents = contentsContainer.querySelectorAll(
			':scope > .gutenberghub-tab-content'
		);

		this.trigger = buttonsContainer.dataset.trigger;
		this.collapsibleContainer = [];
		const collapsibleInnerContainer = [];
		this.tabButtons.forEach( ( button ) => {
			this.collapsibleContainer.push(
				button.querySelectorAll( '.gutenberghub-tab-collapsible' )
			);
			collapsibleInnerContainer.push(
				button.querySelectorAll(
					'.gutenberghub-tab-collapsible .gutenberghub-tab-collapsible-inner-container'
				)
			);
		} );
		this.collapsibleContainer.forEach( ( containers ) => {
			if ( containers ) {
				containers.forEach( ( c ) => {
					c.classList.remove(
						'gutenberghub-tab-collapsible-initialized'
					);
				} );
			}
		} );
		this.collapsibleHeights = collapsibleInnerContainer.map(
			( containers ) => {
				if ( ! containers ) {
					return null;
				}
				return Array.from( containers ).map( ( contentElem ) => {
					if ( ! contentElem ) {
						return null;
					}
					let computedStyle = getComputedStyle( contentElem );
					let elementHeight = contentElem.scrollHeight;

					elementHeight -=
						parseFloat( computedStyle.paddingTop ) +
						parseFloat( computedStyle.paddingBottom );

					return elementHeight;
				} );
			}
		);

		this.collapsiblePadding = collapsibleInnerContainer.map(
			( containers ) => {
				if ( ! containers ) {
					return null;
				}
				return Array.from( containers ).map( ( contentElem ) => {
					if ( ! contentElem ) {
						return null;
					}
					return getComputedStyle( contentElem ).getPropertyValue(
						'padding'
					);
				} );
			}
		);
	}
}
window.addEventListener( 'DOMContentLoaded', () => {
	const tabsContainers = document.querySelectorAll(
		'.gutenberghub-tabs-container'
	);
	tabsContainers.forEach( ( container ) => {
		new GutenberghubTabs( container );
	} );
} );
