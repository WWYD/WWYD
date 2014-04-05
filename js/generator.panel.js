
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
		                         element : element      };

		    me.panels[index].content.addClass(me.cls);

		    // Cacher les autres et afficher le premier
		    if(index != 0) {
				me.panels[index].content.css("display", "none");
		    } else {
				me.active = me.panels[index];
				me.activeIndex = 0;
			}

			// Contenu panel
			console.log(element);
			if(element) {
				$(element).each(function (index2, element2) {
				console.log(element2);
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
		me.panels[me.activeIndex].content.slideUp(700); // On cache l'ancien

		me.panels[++me.activeIndex].content.css("border-top", "gray solid 1px");
		me.panels[me.activeIndex].content.slideDown(700, function() {
			me.panels[me.activeIndex].content.css("border-top", "0");
		}); // On affiche le nouveau
	} else
		console.log("No next panel");
}

generator.Panel.prototype.showPrevious = function() {

	var me = this;

	if(me.activeIndex > 0) {
		me.panels[me.activeIndex].content.slideUp(700); // On cache l'ancien
		me.panels[me.activeIndex].content.css("border-top", "gray solid 1px");

		me.panels[--me.activeIndex].content.slideDown(700); // On affiche le nouveau
	} else
		console.log("No previous panel");
}
