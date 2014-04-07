
this.generator = this.generator || {};

generator.Div = function(args) {
	var args = args || {};

	this.cls = "content-bordered";
	this.renderTo = args.render_to || null;
	this.height = args.height || false;
	this.width = args.width || false;
	this.elements = args.elements || false;
	this.title = args.title || false;
	this.html = args.html || false;
	this.creation_callback = args.creation_clbk || false;
}

generator.Div.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Div.prototype.init = function() {

	var me = this;

	me.container = $('<div />');
	me.container.addClass(me.cls);

	me.intern = $('<p />');

	if(me.height)
		me.container.css("height", me.height);

	if(me.width)
		me.container.css("width", me.width);
	
	if(me.title) {
		var title_container = $('<div class="content-bordered-title" />');
		var title = $('<h4 class="panel-title" />');

		title_container.append(title);
		title.html(me.title);

		me.container.append(title_container);
	}

	// Ajout des éléments
	if(me.elements) {
		$(me.elements).each(function (index, element) {
			element.setRenderTo(me.intern);
			element.init();
		});
	} else if(me.html) {
		var div = $
		me.intern.append(me.html);
	}

	me.container.append(me.intern);

	// Affichage
	if(me.renderTo)
		me.renderTo.append(me.container);

	if(me.creation_callback)
		me.creation_callback(me.container);
}
