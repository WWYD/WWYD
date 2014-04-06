/* =====================================================
			         generator.Checkbox
	----------------------------------------------------
	Permet d'afficher des checkbox
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

generator.Checkbox = function(args) {
	var args = args || {};

	this.cls = "generated-checkbox";
	this.checked = args.checked || false;
	this.default = args.default || this.checked;
	this.disabled = args.disabled || false;
	this.renderTo = args.render_to || null;
	this.css = args.css || null;
	this.onClick = args.onClick || null;
}

generator.Checkbox.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Checkbox.prototype.isEditable = function() {
	return !this.disabled;
}

generator.Checkbox.prototype.init = function() {
	
	var me = this;

	if(me.renderTo) {
		me.element = $('<input type="checkbox" />');
		me.element.addClass(me.cls);
		
		me.setValue(me.checked);

		if(me.onClick)
			me.element.on('click', function(e) {
				me.onClick(e);
			});

		if(me.disabled)
			me.element.attr('disabled', 'disabled');

		if(me.css)
			me.element.css(me.css);

		me.renderTo.append(me.element);
	}
}

generator.Checkbox.prototype.setValue = function(data) {
	if(data && data != 0 && data != '0')
		this.element.attr('checked', 'checked');
	else
		this.element.attr('checked', false);
}

generator.Checkbox.prototype.getValue = function() {
	if (this.element.attr('checked') == 'checked')
		return 1;
	else
		return 0;
}

