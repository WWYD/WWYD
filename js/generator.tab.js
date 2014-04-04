
this.generator = this.generator || {};

generator.Tab = function(args) {
	var args = args || {};

	this.cls = "panel-menu";
	this.clsContent = "panel-content";
	this.renderTo = args.render_to || null;

	this._tabs = args.tabs || false;

	this.creation_callback = args.creation_clbk || false;
}

generator.Tab.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Tab.prototype.init = function() {

	var me = this;

	me.container = $('<section />');
	me.tabGroup = $('<ul />');
	me.tabGroup.addClass(me.cls);

	me.tabContent = $('<div />');
	me.tabContent.addClass(me.clsContent);

	me.container.append(me.tabGroup);
	me.container.append(me.tabContent);

	me.in_change = true;

	// Ajout des éléments
	if(me._tabs) {
		me.tabs = [];
		$(me._tabs).each(function (index, element) {
			// Element de l'onglet
			me.tabs[index] = { title   : $('<li />'),
		                       content : $('<div />'),
		                       element : element      };

		    // Cacher les autres et marquer le premier comme actif
		    if(index != 0)
				me.tabs[index].content.css("display", "none");
			else {
				me.tabs[index].title.addClass('active');
				me.active = me.tabs[index];
			}

			// Titre onglet
			if(element['title'])
				me.tabs[index].title.html(element['title']);
			else
				me.tabs[index].title.html("Tab n°"+index);

			me.tabGroup.append(me.tabs[index].title);

			// Contenu onglet
			if(element['elements']) {
				$(element['elements']).each(function (index2, element) {
					element.setRenderTo(me.tabs[index].content);
					element.init();
				});
			}

			me.tabContent.append(me.tabs[index].content);

			me.tabs[index].title.on("click", function(e) {
				if( !$(e.target).hasClass('active') && !me.in_change ) {
					me.in_change = true; // On bloque les changements d'onglet
					me.active.title.removeClass('active');
					me.tabs[index].title.addClass('active');

					me.active.content.fadeToggle(200, "swing", function() {
						me.active = me.tabs[index];
						me.active.content.fadeToggle(200, "swing", function() {
							if(me.tabs[index].element.elements && me.tabs[index].element.elements.setFocus)
								me.tabs[index].element.elements.setFocus();
							me.in_change = false; // On permet de nouveau de changer d'onglet
						});
					});
				}
			});

		});
	} else {
		console.log("Empty tab group !");
	}

	// Affichage
	if(me.renderTo)
		me.renderTo.append(me.container);

	// Callback
	if(me.creation_callback)
		me.creation_callback(me.container);

	me.in_change = false;
}
