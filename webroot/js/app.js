NIO.routers.App = Backbone.Router.extend({
	
	routes: {
		'' : 'home'
	},
	
	initialize: function () {
        // _.bindAll(this);
        var self = this;
		this.isTransition = false; // will only be false on page load
        this.isDirty = false;
        this.constants = NIO.constants;
        this.settings = NIO.settings;
        this.utils = NIO.utils;

        $.mask.definitions['i']='[ 0-9\-\(\)\.]'; // international phone number mask

        $("body").on('change', 'input[type="text"],input[type="radio"],input[type="checkbox"],select,textarea', function () {
            self.isDirty = true;
        });
    },

    getViews: function() {
        var self = this;
        this.views = {
            Overlay: (function() {
                if (NIO.views.Overlay) {
                    return new NIO.views.Overlay({el: 'body'});
                }
                return false;
            })(),
            Header: (function() {
                if (NIO.views.Header) {
                    self.HeaderFinished = $.Deferred();
                    return new NIO.views.Header({el: 'body'});
                }
                return false;
            })(),
            Footer: (function() {
                if (NIO.views.Footer) {
                    return new NIO.views.Footer({el: 'body'});
                }
                return false;
            })(),
            Page: {}
        };
        if (this.views.Overlay) {
            this.showLoader = _.bind(this.views.Overlay.showLoader, this.views.Overlay);
            this.hideLoader = _.bind(this.views.Overlay.hideLoader, this.views.Overlay);
        }
    },

    // TODO: the element given to the page should probably be the same name as the view.
    getPageView: function() {
        if (App.viewData.pageName) {
            return new NIO.views[App.viewData.pageName]({el: '#page'});
        }
        return {};
    }
    
});

(function() {
	App = new NIO.routers.App();
    $('body').addClass(App.constants.environment);
    App.viewData = {};
    App.getViews();
    App.views.Page = App.getPageView();
    var pushState = false;
    if ($('html').hasClass('ie')) {
        pushState = false;
    }
    Backbone.history.start({pushState: pushState, root: '/'});
})();