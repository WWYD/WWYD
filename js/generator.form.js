/* =====================================================
			         generator.Form
	----------------------------------------------------
	Permet de gérer et de générer des formulaires.
	----------------------------------------------------
	Propriétés :
		render_to    : élément où afficher le formulaire (append)
		elements     : tableau d'éléments composant le formulaire,
		               ces éléments peuvent doivent au moins
		               comporter un element item pour pouvoir
		               être utilisé. S'il comporte un champ name
		               et que item à une methode getValue, alors
		               leurs valeurs seront automatiquement utilisées 
		               pour être envoyée a target
		submit_value : valeur du bouton d'envoi
		target       : fichier à qui envoyer les données
		source       : fichier d'où lire les données. Si celui-ci
		               n'est pas définit, alors le formulaire sera
		               vide. Utilisé pour les formulaires de modification
		success_clbk : callback de retour positif de target
		error_clbk   : callback de retour négatif de target
		fail_clbk    : erreur lors de l'appel de target
		design       : flow | table - désigne le mode d'affichage
		               du formulaire. Si table est utilisé, alors
		               on peut donner une taille personnalisée à
		               un champ avec l'élement "width". Attention
		               utiliser des label avec les éléments ajoute
		               une nouvelle cellule
		send         : redéfinition de la fonction d'envois du formulaire
		submits      : permet d'utiliser plusieurs submits dans le
		               même formulaire

	Methodes :
		setRenderTo() : change le render_to 
		setFocus()    : met le focus sur un éléments du form 
		init()        : initialise l'objet 
		check()       : vérifie le validité des champs
		send()        : vérifie et envoit les données, avant
		                de traiter la réponse
		fill(data)    : si source est définit, rempli le formulaire
		                à l'aide de source en envoyant data
		disable()     : désactive les champs du formulaire
		enable()      : active les champs du formulaire
   ===================================================== */

this.generator = this.generator || {};

generator.Form = function(args) {
	var args = args || {};

	this.cls = "generated-form";
	this.renderTo = args.render_to || null;
	this.elements = args.elements || [];
	this.submit_value = args.submit_value || "Valider";
	this.target = args.target;
	if(typeof this.target == "undefined")
		this.target = "target.php";
	this.source = args.source || false;
	this._submits = args.submits || false;
	this.send = args.send || this.send;
	this.success_clbk = args.success_clbk;
	this.error_clbk = args.error_clbk;
	this.fail_clbk = args.fail_clbk;
	this.success_load_clbk = args.success_load_clbk;
	this.error_load_clbk = args.error_load_clbk;
	this.fail_load_clbk = args.fail_load_clbk;
	this.design = args.design || "flow"; // flow ou table (voir + loin pour table)
	this.fields = [];
	this.css = args.css || false;
}

generator.Form.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.Form.prototype.setFocus = function() {
	var me = this;

	if(typeof me.firstEditable != 'undefined')
		setTimeout( function() { 
			me.fields[me.firstEditable].element.focus(); 
		}, 500 );
}

generator.Form.prototype.check = function(e) {

	var me = this;
	var result = true;

	$(me.fields).each(function(index, element) {
		if(element.check)
			if(element.check(e, true)) 
				result = result ? true : false;
			else
				result = false;
	});

	return result;
}

generator.Form.prototype.send = function(e, target, me) {
	var me = me || this;

	if(me.check()) {
		var to_send = {};
		$(me.fields).each(function(index, element) {
			to_send[element.name] = element.getValue();
		});

		if(target || me.target) {

		$.ajax({ type     : 'POST',
	             url      :  target || me.target,
	             dataType : "json",
	             data     : { data : JSON.stringify({ data : to_send}) } })
	           .done(function(data) {
	           	   console.log(data);
	           	   if(data.success) {
	           	      if(me.success_clbk)
	                       me.success_clbk(data);
	           	   } else if(data.error) {
	           	   	  console.log("Erreur PHP");

	           	      if(me.error_clbk)
	                       me.error_clbk(data, me);
	                   else
	                   	   generator.Message.prototype.genError(data, false, me);
	           	   } else {
		           	   console.log("Erreur structure réponse");

		           	   if(me.error_clbk)
		           	   	   me.error_clbk(data, me);
		           	   	else
		           	   	  generator.Message.prototype.genError(data, false, me);
	           	   }
	           })
	           .fail(function(jqXHR) {
	           	   console.log("Erreur Ajax");

	           	   if(me.fail_clbk)
	           	   	   me.fail_clbk(jqXHR, me);
	           	   	else
	                   generator.Message.prototype.genAjaxError(jqXHR, false, me);

	           });
		} else {
   	      if(me.success_clbk)
               me.success_clbk(to_send);
		}
    }
}

generator.Form.prototype.init = function() {
	var me = this;
	var keyListener = function(e) {
		var code = e.keyCode || e.which;

		 //Enter keycode
		if(code == 13) {
		   me.send(e);
		   $("input").blur();
		}

	};

	// Structure
	me.container = $('<div />');
	me.container.addClass(me.cls);
	me.renderTo.append(me.container);

	if(me.css)
		me.container.css(me.css);

	// Elements
	if(me.design == "flow") {

		var i = 0;

		$(me.elements).each(function(index, element) {
			
			if(element.item) {
				var div = $("<div/>");
				var label = $("<p/>");

				label.text(element.label);
				div.append(label);

				element.item.setRenderTo(div);
				element.item.init();

				if(element.item.keyListener)
					element.item.keyListener(keyListener);

				me.container.append(div);

				// Si l'élément à une valeur, un nom, et est activé
				if(element.item.getValue && element.name && !element.disabled) {
					element.item.name = element.name;
					me.fields[i++] = element.item;

					if(typeof me.firstEditable == 'undefined' && 
						me.fields[i-1].isEditable && 
						me.fields[i-1].isEditable()) {
							me.firstEditable = i-1;
					}
				}
			}
		});

	} else if (me.design == "table") {

		var p = $("<p/>");
		var label = $("<p/>");
		var table = $("<table/>");

		table.addClass("form-table")

		var i = 0;

		$(me.elements).each(function(index, line_elements) {

			var line = $("<tr />");

					console.log(line_elements);
			// On attend ici des lignes
			$(line_elements).each(function(index, element) {
				if(element.label) {

					var label = $('<td />');

					label.text(element.label);
					line.append(label);
				}

				var data = $('<td />');

				if(element.space)
					data.css("width", element.space);

				if(element.width)
					data.attr("colspan", element.width);


				if(element.item) {
					element.item.setRenderTo(data);
					element.item.init();

					if(element.item.keyListener)
						element.item.keyListener(keyListener);

					if(element.item.getValue && element.name && !element.disabled) {
						element.item.name = element.name;
						me.fields[i++] = element.item;
					
						if(typeof me.firstEditable == 'undefined' && 
							me.fields[i-1].isEditable && 
							me.fields[i-1].isEditable()) {
								me.firstEditable = i-1;
						}
					}
				}
				
				line.append(data);	
			});

			table.append(line);
		});

		me.container.append(table);
	}

	me.setFocus();

	var centered  = $('<p style="text-align: center; margin: 0;" />');

	// Submit
	if(!me._submits) {
		// Un seul, implicite
		me.submit = $('<button class="generated-button" />');
		me.submit.html(this.submit_value);
		me.submit.on("click", function(e) {
			me.send(e);
		});
		centered.append(me.submit);
	} else {
		// Plusieurs submits
		me.submits = [];
		$(me._submits).each(function(index, element) {
			var sub = {  target   : element.target || false,
		                  value   : element.value  || "Submit",
		                  send    : element.send   || me.send,
		                  element : $('<button class="generated-button" />')
		              };

			sub.element.on('click', function(e) {
				sub.send(e, sub.target, me);
			});
			sub.element.html(sub.value);

			centered.append(sub.element);

			me.submits.push(sub);
		});
	}
	
	me.container.append(centered);
}


generator.Form.prototype.empty = function() {
	var me = this;

   // Pour chaque champ
   $(me.fields).each(function(index, element) {
   		// Si le champs à un nom
   		if(element.name && element.setValue)
   			element.setValue(element.default ? element.default : '');
   });
}

generator.Form.prototype.disable = function() {
	var me = this;
	
   // Pour chaque champ
   $(me.fields).each(function(index, element) {
   		// Si le champs à un element
   		if(element.element)
   			element.element.attr("disabled", "disabled");
   });

   // Un seul submit
   if(me.submit)
   		me.submit.attr("disabled", "disabled");
   	// Plusieurs
   	else {
   		$(me.submits).each(function(index, element) {
   			element.element.attr("disabled", "disabled");
   		});
   	}
}

generator.Form.prototype.enable = function() {
	var me = this;

   // Pour chaque champ
   $(me.fields).each(function(index, element) {
   		// Si le champs à un nom
   		if(element.element && ( !element.isEditable || element.isEditable() ))
   			element.element.attr("disabled", false);
   });

   // Un seul submit
   if(me.submit)
   		me.submit.attr("disabled", false);
   	// Plusieurs
   	else {
   		$(me.submits).each(function(index, element) {
   			element.element.attr("disabled", false);
   		});
   	}
}

generator.Form.prototype.fill = function(data) {
	var me = this;

	me.empty();

	if(me.source) {
		$.ajax({ type     : 'POST',
	             url      :  me.source,
	             dataType : "json",
	             data     : { data : data } })
	           .done(function(data) {

	           	   if(data.success) {
	           	      if(me.success_load_clbk)
	                       me.success_load_clbk(data);
	                   // Pour chaque champ
	                   $(me.fields).each(function(index, element) {
	                   		// Si le champs à un nom
	                   		if(element.name && element.setValue && data.success[element.name])
	                   			element.setValue(data.success[element.name]);
	                   });
	           	   } else if(data.error) {
	           	   	  console.log("Erreur PHP");

	           	   	  me.empty();

	           	      if(me.error_load_clbk)
	                       me.error_load_clbk(data, me);
	                   else
	                   	   generator.Message.prototype.genError(data, false, me);
	           	   
	           	   } else {
		           	   console.log("Erreur structure réponse");

	           	   	  me.empty();

		           	   if(me.error_load_clbk)
		           	   	   me.error_load_clbk(data, me);
	                   else
	                   	   generator.Message.prototype.genError(data, false, me);

	           	   }
	           })
	           .fail(function(jqXHR) {
	           	   console.log("Erreur Ajax");

	           	   if(me.fail_load_clbk)
	           	   	   me.fail_load_clbk(jqXHR, me);
	                else
	                   generator.Message.prototype.genAjaxError(jqXHR, false, me);
	           });
    }
}	