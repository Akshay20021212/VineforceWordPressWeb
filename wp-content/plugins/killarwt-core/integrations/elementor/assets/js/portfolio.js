jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updatePortfolio();
    };
    function updatePortfolio() {
		
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
				window.kwt.initialization.aos();
                window.kwt.sections.kwtSlickCarousel();
                window.kwt.sections.masonryGrid();
            }, 2500);
        } else {
			setTimeout(function () {
				window.kwt.initialization.aos();
                window.kwt.sections.kwtSlickCarousel();
                window.kwt.sections.masonryGrid();
            }, 200);
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-portfolio.default',
        addHandler
    );
});
