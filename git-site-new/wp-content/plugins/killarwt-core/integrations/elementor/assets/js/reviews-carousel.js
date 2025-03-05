jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSldier();
    };
    function updateSldier() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
				window.kwt.initialization.aos();
                window.kwt.sections.kwtSlickCarousel();
            }, 10);
        } else {
			window.kwt.initialization.aos();
			window.kwt.sections.kwtSlickCarousel();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-reviews-carousel.default',
        addHandler
    );
});