/* =====================================================
			         generator.ttbox
	----------------------------------------------------
	Permet de générer des fenêtre en pop-up permettant
	de contenir des éléments.
	----------------------------------------------------
	Propriétés :
	    height           : hauteur de la fenêtre (150px de base)
		width            : largeur de la fenêtre
	    elements         : elements à afficher dans la fenêtre,
	                       les un après les autres
	    dismissible      : true | false - Fenêtre fermable
	    dismiss_on_close : true | false - Détruit la fenêtre
	                       quand on la quitte si true
	    creation_cbk     : fonction appellée après la création 
	                       de l'élément dans le DOM   
	    deletion_cbk     : fonction appellée après la destruction
	                       de l'élément dans le DOM     
	Methodes :
		init()           : initialise l'objet
		show()           : affiche l'élément sur la page
		hide()           : cache l'élément sur la page
		resize()         : recalcul la taille de l'élément
		                   en utilisant les champs width et height
		dismiss(e)       : lance la fermeture & la destruction
	                      de l'élément dans le DOM     
   ===================================================== */

this.generator = this.generator || {};

generator.TTBox = function(args) {
	var args = args || {};

	this.height = args.height || false;
	this.width = args.width || false;
	this.elements = args.elements || false;
	this.html = args.html || false;
	this.dismissible = args.dismissible || true;
	this.dismiss_on_close = args.dismiss_on_close || true;
	this.creation_callback = args.creation_clbk || false;
	this.deletion_callback = args.deletion_clbk || false;
}

generator.TTBox.prototype.init = function() {

	var me = this;

	me.container = $('<div class="ttbox-global" style="display: none;" />');
	me.window = $('<div class="ttbox-frame" style="display: none;" />');

	me.container.append(me.window);

	// Dismisible 
	if(me.dismissible) {
		me.container.on("click", function(e) { 
			if($(e.target)[0] == me.container[0]) {
				if(me.dismiss_on_close)
					me.dismiss();
				else
					me.hide();
			}
		});

		var exit = $('<div class="close" />');
		exit.on("click", function(e) {
			if(me.dismiss_on_close)
				me.dismiss();
			else
				me.hide();
		});

		me.window.append(exit);

		setTimeout(function() {
			$(document).bind('keyup', function(e) {
				if(e.keyCode == 27) {
					if(me.dismiss_on_close)
						me.dismiss();
					else
						me.hide();
				}
			});
		}, 500);
	}

	$(window).resize(function() {
		me.resize();
	});

	if(me.height)
		me.window.css("height", me.height);

	// Ajout des éléments
	if(me.elements) {
		$(me.elements).each(function (index, element) {
			element.setRenderTo(me.window);
			element.init();
		});
	} else if(me.html) {
		me.window.append(me.html);
	}

	// Affichage
	$("body").append(me.container);

	// callback final
	if(me.creation_callback)
		me.creation_callback(me.container, me.window);
}

generator.TTBox.prototype.show = function() {

	var me = this;

	me.container.css("display", "block");

	me.container.fadeIn(function() {
		me.resize();
		me.window.animate({    top: "toggle",
			               opacity: "toggle"});
	});
}

generator.TTBox.prototype.hide = function() {

	var me = this;

	me.window.animate({ top: "toggle",
		                opacity: "toggle"}, function() {
							me.container.fadeOut(200);
		               });
}

generator.TTBox.prototype.dismiss = function() {

	var me = this;

	me.window.animate({ top: "toggle",
		                opacity: "toggle"}, function() {
							me.container.fadeOut(200, function() {
								me.container.remove();

								if(me.deletion_clbk)
									me.deletion_clbk();
							});
		               });
}

generator.TTBox.prototype.resize = function() {

	var me = this;

	if(me.window.height() + 30 >= me.container.height()) {
		me.window.css("top", 0);
	} else {
		me.window.css("top", ((me.container.height() - me.window.height()) / 2) - 30 )
	}

	if(me.width) {
		me.window.css("width", me.width);
		me.window.css("margin-left", - (me.width / 2)); // center
	}
}