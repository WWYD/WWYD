/* =====================================================
			         generator.Button
	----------------------------------------------------
	Permet d'afficher un titre de type h3
	----------------------------------------------------
	Propriétés :
	    text         : texte du titre
		render_to    : élément où afficher le titre (append)   
	Methodes :
		init()       : initialise l'objet   
		setValue()   : change la valeur du titre
		getValue()   : valeur du titre
   ===================================================== */

this.generator = this.generator || {};

generator.Button = function(args) {
	var args = args || {};

	this.cls = "generated-button";
	this.text = args.text || "";
	this.default = args.default || this.text;
	this.disabled = args.disabled || false;
	this.renderTo = args.render_to || null;
	this.css = args.css || null;
	this.onClick = args.onClick || null;
	this.onHover = args.onHover || null;
}

generator.Button.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Button.prototype.isEditable = function() {
	return !this.disabled;
}

generator.Button.prototype.init = function() {
	
	var me = this;

	if(me.renderTo) {
		me.element = $('<button />');
		me.element.addClass(me.cls);
		me.element.html(me.text);
		if(me.onClick)
			me.element.on('click', function(e) {
				me.onClick(e);
			});
		if(me.onHover)
			me.element.on('hover', function(e) {
				me.onHover(e);
			});

		if(me.css)
			me.element.css(me.css);

		me.renderTo.append(me.element);
	}
}

generator.Button.prototype.setValue = function(data) {
	this.text = data;
	this.element.html(this.text);
}

generator.Button.prototype.getValue = function() {
	return this.text;
}

