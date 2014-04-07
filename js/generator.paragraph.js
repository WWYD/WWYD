/* =====================================================
			         generator.Paragraph
	----------------------------------------------------
	Permet d'afficher des paragraphes
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

generator.Paragraph = function(args) {
	var args = args || {};

	this.cls = "generated-paragraph";
	this.text = args.text || "";
	this.default = args.default || this.text;
	this.renderTo = args.render_to || null;
	this.css = args.css || null;
}

generator.Paragraph.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Paragraph.prototype.isEditable = function() {
	return false;
}

generator.Paragraph.prototype.init = function() {
	
	var me = this;

	if(me.renderTo) {
		me.element = $('<p />');
		me.element.addClass(me.cls);
		me.element.html(me.text);

		if(me.css)
			me.element.css(me.css);

		me.renderTo.append(me.element);
	} else
		console.log("No render");
}

generator.Paragraph.prototype.setValue = function(data) {
	this.text = data;
	this.element.html(this.text);
}

generator.Paragraph.prototype.getValue = function() {
	return this.text;
}

