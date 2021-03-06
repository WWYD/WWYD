/* =====================================================
			         generator.message
	----------------------------------------------------
	Permet de générer des messages. Ces messages peuvent
	êtres modaux, supprimable et bien sur appeller un
	callback à leur création où à leur suppression.
	----------------------------------------------------
	Propriétés :
	    type         : error | info | success| warning - style
		title        : titre du pop-up
	    message      : message du pop-up
	    dismissible  : true | false - Pop-up fermable
	    disable      : jquery élément où disable tout les 
	                   élements de formulaire
	    creation_cbk : fonction appellée après la création 
	                   de l'élément dans le DOM   
	    deletion_cbk : fonction appellée après la destruction
	                   de l'élément dans le DOM     
	Methodes :
		init()       : initialise l'objet
		dismiss(e)   : lance la fermeture & la destruction
	                   de l'élément dans le DOM     
   ===================================================== */

this.generator = this.generator || {};

generator.Message = function(args) {
	var args = args || {};

	this.type = args.type || "error"; // error - info - success - warning
	if(this.type != 'error' && this.type != "info" 
	&& this.type != 'success' && this.type != 'warning')
		this.type = "error";
	this.title = args.title || "Erreur";
	this.message = args.message || "Une erreur est survenue";
	this.dismissible = args.dismissible || false;
	this.modal = args.modal || false;
	this.disable = args.disable || false;
	this.creation_callback = args.creation_clbk || false;
	this.deletion_callback = args.deletion_clbk || false;
}

generator.Message.prototype.init = function() {

	var me = this;

	// Pop-up
	me.container = $('<div class="msg-pop-up" style="display: none;" />');
	me.container.addClass(me.type);

	var h_title = $('<h2 />');
	var p_message = $('<p />');

	h_title.text(me.title);
	p_message.text(me.message);

	me.container.append(h_title);
	me.container.append(p_message);

	// Si pop-up dismissible
	if(me.dismissible) {
		var exit = $('<div class="close" />');
		exit.on("click", function(e) {
			me.dismiss(e);
		});
		me.container.prepend(exit);

		setTimeout(function() {
			$(document).bind('keyup', function(e) {
			    me.dismiss(e);
			});
		}, 500);
	}

	// Modal
	if(me.modal) {
		me.modal_window = $('<div class="modal-pop-up" />');
		$("body").append(me.modal_window);

		if(me.disable && me.disable.disable)
			me.disable.disable(); 
	}

	$(window).resize(function() {
		me.resize();
	});
	
	me.resize();

	// Affichage
	if(me.modal)	
		me.modal_window.append(me.container);
	else
		$("body").append(me.container);

	me.container.animate({ top: "toggle",
			               opacity: "toggle"}, 
			               function() {
			               	   if(me.creation_callback) me.creation_callback();
			               });
}

generator.Message.prototype.dismiss = function(e) {

	var me = this;

	$(document).unbind('keyup');

	me.container.animate({ top: "toggle",
	                       opacity: "toggle"}, 
	                       function() {

					        if(me.modal) 
						    	me.modal_window.remove();


							if(me.disable && me.disable.enable)
								me.disable.enable(); 

		                    this.remove(); // Suppression fenêtre

		                    if(me.deletion_callback) 
		                       	me.deletion_callback();
	                       });
}

generator.Message.prototype.resize = function() {

	var me = this;

	if(me.container.height() + 30 >= me.modal_window.height()) {
		me.container.css("top", 0);
	} else {
		me.container.css("top", ((me.modal_window.height() - me.container.height() - 30) / 2));
	}
}

generator.Message.prototype.genAjaxError = function(jqXHR, dismiss_clbk, disable) {
	var error = new generator.Message({ type : 'error',
		                                title : 'Erreur '+jqXHR.status, 
                                        message : 'Le traitement à échoué avec l\'erreur suivante : '+jqXHR.statusText , 
                               		    modal : true, dismissible : true,
                               		    deletion_clbk : dismiss_clbk || false,
                               		    disable : disable || false
                                      });
	error.init();

}

generator.Message.prototype.genError = function(msg, dismiss_clbk, disable) {
	var error = new generator.Message({ type : 'error',
		                                title : (msg && msg.error && msg.error.title) ? msg.error.title : 'Erreur', 
                                        message :  (msg && msg.error && msg.error.msg) ? msg.error.msg : 'Une erreur est survenue pendant le traitement',  
                               		    modal : true, dismissible : true,
                               		    deletion_clbk : dismiss_clbk || false,
                               		    disable : disable || false
                                      });
	error.init();

}