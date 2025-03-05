jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateGallery();
    };
    function updateGallery() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
                window.kwt.sections.masonryGrid();
            }, 10);
        } else {
			 setTimeout(function () {
                window.kwt.sections.masonryGrid();
            }, 400);
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-gallery.default',
        addHandler
    );
});