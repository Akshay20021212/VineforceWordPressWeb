jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        updateSldier();
    };
    function updateSldier() {
        if (typeof window.Flickity !== 'undefined') {
            setTimeout(function () {
				window.kwt.initialization.aos();
            }, 10);
        } else {
			window.kwt.initialization.aos();
        }
    }
    elementorFrontend.hooks.addAction(
        'frontend/element_ready/killar-reviews-tabs.default',
        addHandler
    );
});