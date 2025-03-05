jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSlider();
    };
    function updateSlider() {
		
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.kwt.sections.kwtSlickCarousel();
            }, 2500);
        } else {
			window.kwt.sections.kwtSlickCarousel();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-product-categories.default',
        addHandler
    );
});
