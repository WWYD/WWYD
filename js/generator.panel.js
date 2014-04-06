
this.generator = this.generator || {};

generator.Panel = function(args) {
	var args = args || {};

	this.cls = "panel-page";
	this.clsContent = "panel-content";
	this.renderTo = args.render_to || null;

	this._panels = args.panels || false;

	this.creation_callback = args.creation_clbk || false;
}

generator.Panel.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Panel.prototype.init = function() {

	var me = this;

	me.container = $('<section />');
	me.container.addClass(me.clsContent);

	// Ajout des éléments
	if(me._panels) {
		me.panels = [];
		$(me._panels).each(function (index, element) {

			// Element de l'onglet
			me.panels[index] = { content : $('<div />'),
		                         elements : element.elements || {}};

		    me.panels[index].content.addClass(me.cls);

		    // Cacher les autres et afficher le premier
		    if(index != 0) {
				me.panels[index].content.css("display", "none");
		    } else {
				me.active = me.panels[index];
				me.activeIndex = 0;
			}

			// Si on a une fonction valueNext
			if(element.valueNext && typeof element.valueNext == 'function')
				me.panels[index].valueNext = element.valueNext;

			// Si on a une fonction valuePrevious
			if(element.valuePrevious && typeof element.valuePrevious == 'function')
				me.panels[index].valuePrevious = element.valuePrevious;

			// Contenu panel
			if(element.elements) {
				$(element.elements).each(function (index2, element2) {
					element2.setRenderTo(me.panels[index].content);
					element2.init();
				});
			}

			// Ajout
			me.container.append(me.panels[index].content);

		});
	} else {
		console.log("Empty panel group !");
	}

	// Affichage
	if(me.renderTo)
		me.renderTo.append(me.container);

	// Callback
	if(me.creation_callback)
		me.creation_callback(me.container);
}

generator.Panel.prototype.showNext = function() {

	var me = this;

	if(me.activeIndex + 1 < me.panels.length) {
		// Si on définit une fonction pour récupérer sa valeur
		if(me.panels[me.activeIndex].valueNext) {
			// Pour chaque élément du panneau suivant
			$(me.panels[me.activeIndex+1].elements).each(function(index, element) {
				// Si on peut le remplir, one le fait avec notre valeur
				if(element.fill)
					element.fill(me.panels[me.activeIndex].valueNext());
			});
		}

		me.panels[me.activeIndex].content.slideUp(700); // On cache l'ancien

		me.panels[++me.activeIndex].content.css("border-top", "gray solid 1px");
		me.panels[me.activeIndex].content.slideDown(700, function() {
			me.panels[me.activeIndex].content.css("border-top", "0");
		}); // On affiche le nouveau
		me.setFocus();
	} else
		console.log("No next panel");
}

generator.Panel.prototype.showPrevious = function() {

	var me = this;

	if(me.activeIndex > 0) {
		// Si on définit une fonction pour récupérer sa valeur
		if(me.panels[me.activeIndex].valuePrevious) {
			// Pour chaque élément du panneau precedant
			$(me.panels[me.activeIndex-1].elements).each(function(index, element) {
				// Si on peut le remplir, one le fait avec notre valeur
				if(element.fill)
					element.fill(me.panels[me.activeIndex].valuePrevious());
			});
		}

		me.panels[me.activeIndex].content.slideUp(700); // On cache l'ancien
		me.panels[me.activeIndex].content.css("border-top", "gray solid 1px");

		me.panels[--me.activeIndex].content.slideDown(700); // On affiche le nouveau
		me.setFocus();
	} else
		console.log("No previous panel");
}

generator.Panel.prototype.setFocus = function() {

	var me = this;

	if(me.panels[me.activeIndex].elements[0] && me.panels[me.activeIndex].elements[0].setFocus)
		me.panels[me.activeIndex].elements[0].setFocus();
}