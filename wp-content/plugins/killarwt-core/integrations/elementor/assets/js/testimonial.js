jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.kwt.initialization.aos();
				window.kwt.sections.kwtSlickCarousel();
            }, 10);
        } else {
			 window.kwt.initialization.aos();
			 window.kwt.sections.kwtSlickCarousel();
        }
    };
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-testimonial.default',
        addHandler
    );
});