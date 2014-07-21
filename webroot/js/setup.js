/**
 * Set up the major namespaces.
 * The following function uses _.extend internally but also creates each
 * piece of the namespace if it doesn't already exist.
 */
(function(){
	function extendGlobal(namespace, obj){
		var ctx = window;
		_(namespace.split('.')).each(function(name){
			ctx[name] = ctx[name] || {};
			ctx = ctx[name];
		});
		if (obj) { _.extend(ctx, obj); }
		return ctx;
	}

	extendGlobal('NIO.utils', {
		extendGlobal: extendGlobal
	});

})();

NIO.utils.extendGlobal('NIO.staticData', {});
NIO.utils.extendGlobal('NIO.constants', {});
NIO.utils.extendGlobal('NIO.settings', {});
NIO.utils.extendGlobal('NIO.routers', {});
NIO.utils.extendGlobal('NIO.models', {});
NIO.utils.extendGlobal('NIO.views', {
	'modules': {},
	'pages': {}
});

//Backbone.View.prototype.close = function () {
//    console.log('Unbinding events for ' + this.cid);
//
//    if (this.onBeforeClose) {
//        this.onBeforeClose();
//    }
//
//    this.remove();
//    this.unbind();
//
//    if (this.onClose) {
//        this.onClose();
//    }
//};
