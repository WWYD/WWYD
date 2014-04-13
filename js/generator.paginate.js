
this.generator = this.generator || {};

generator.Paginate = function(args) {
	var args = args || {};

	this.cls = "content-paginate";
	this.renderTo = args.render_to || null;
	this.source = args.source || "source.php";
	this.page_size = args.page_size || 5;
	this.model = args.model || function(data) { console.log(data); } ;
	this.creation_callback = args.creation_clbk || false;
	this.data = args.data || false;
}

generator.Paginate.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Paginate.prototype.init = function() {

	var me = this;

	me.container = $('<div />');
	me.container.addClass(me.cls);

	me.paginate = $('<div />');
	me.paginate.addClass('paginate');

	me.page = 0;

	// Affichage
	if(me.renderTo) {
		me.renderTo.append(me.container);
		me.renderTo.append(me.paginate);
	}

	if(me.creation_callback)
		me.creation_callback(me.container);

	// Lancement
	if(me.data)
		me.initPaginate(me.data);
}

generator.Paginate.prototype.makePagination = function(size) {
	
	var me = this;

	var i = 1;

	for(; i <= size; i++) {
		var pageButton = $('<button type="button" />');
		pageButton.html(i);

		if(i == 1) { // Premiere page par défaut
			pageButton.addClass('selected');
			me.activeButton = pageButton;
			me.showPage(0);
		}

		// Affichage de la page selectionnée
		pageButton.on('click', function(e) {
			// On change le logo activé
			me.activeButton.removeClass('selected');
			me.activeButton = $(e.target);
			me.activeButton.addClass('selected');

			me.showPage(me.activeButton.html()-1);
		});

		me.paginate.append(pageButton);
	}

}

generator.Paginate.prototype.initPaginate = function(data) {

	var me = this;

	// Sauvegarde des données
	me.data = data;

	// On va lancer le système de pagination, on lance donc la première requête
	// Pour récupérer le nombre de pages
	if(me.source) {
		$.ajax({ type     : 'POST',
	             url      :  me.source,
	             dataType : "json",
	             data     : { data : me.data, page_size : me.page_size } })
	           .done(function(data) {

	           	   if(data.success) {
	           	   		// Si on a renvoyé une taille et qu'on a plus d'un élément
	           	   		if(data.success.size) {
	           	   			me.makePagination(Math.ceil(data.success.size / me.page_size));
	           	   		} else {
		           	   	  me.empty();

		           	   	  // Message indiquant qu'aucun résultat n'a été renvoyé
	           	   		}

	           	   } else if(data.error) {
	           	   	  console.log(data);

	           	   	  me.empty();

	           	   	  // Message d'erreur
	           	   } else {
		           	   console.log("Erreur structure réponse");

	           	   	  me.empty();

		           	  // Message d'erreur
	           	   }
	           })
	           .fail(function(jqXHR) {
	           	   console.log("Erreur Ajax");

           	   	  me.empty();

	           	  // Message d'erreur
	           });
    }

}


generator.Paginate.prototype.showPage = function(page) {
	var me = this;

	// On souhaite récupérer une page en particulier
	if(me.data) {
		$.ajax({ type     : 'POST',
	             url      :  me.source,
	             dataType : "json",
	             data     : { data : me.data, page : page, page_size : me.page_size } })
	           .done(function(data) {

	           	   if(data.success) {
	           	   		if(data.success.length > 0) {

		           	   		var elements = [];
		           	   		var results = $('<div style="display: none;" />');

		           	   		// On lance la génération
		           	   		$(data.success).each(function(index, element) {
		           	   			// Création
		           	   			var piece = me.model(element);

			           	   		if(piece.init) {
			           	   			if(piece.setRenderTo) { 
			           	   				piece.setRenderTo(results);
			           	   				piece.init();
			           	   			}
			           	   			// Ajout à la liste
			           	   			elements.push(piece);
			           	   		} else {
			           	   			results.append($(piece));
			           	   		}
		           	   		});

		           	   		// On affiche
		           	   		if(me.results) {
			           	   		me.results.fadeOut(200, function() {
			           	   			// On décroche et on ajoute les nouveaux
			           	   			me.container.empty();
			           	   			me.container.append(results);
			           	   			// On affiche
			           	   			results.fadeIn(200);
			           	   		})
			           	   	} else {
			           	   		// On accroche
			           	   		me.container.append(results);
			           	   		// On affiche
			           	   		results.fadeIn(200);
			           	   	}

			           	   	me.results = results;

		           	   	} else {

		           	   		// Message vide

		           	   	}

	           	   } else if(data.error) {
	           	   	  console.log("Erreur PHP");

	           	   	  me.empty();

	           	   	  // Message d'erreur

	           	   
	           	   } else {
		           	   console.log("Erreur structure réponse");

	           	   	  me.empty();

		           	  // Message d'erreur

	           	   }
	           })
	           .fail(function(jqXHR) {
	           	   console.log(jqXHR);

           	   	  me.empty();

	           	  // Message d'erreur
	           });
    } else
    	console.log("Chargement de page sans données");
}	


generator.Paginate.prototype.empty = function(page) {

	var me = this;

	me.data = null; // On enlève les données

	me.results.fadeOut(500, function() {
		me.container.empty();
	});

	me.paginate.fadeOut(500, function() {
		me.paginate.empty();
	});

}