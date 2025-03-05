jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSldier();
    };
    function updateSldier() {
		
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.kwt.initialization.aos();
                window.kwt.sections.kwtSlickCarousel();
                window.kwt.sections.masonryGrid();
            }, 2500);
        } else {
			window.kwt.initialization.aos();
			window.kwt.sections.kwtSlickCarousel();
			window.kwt.sections.masonryGrid();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-blog.default',
        addHandler
    );
});
