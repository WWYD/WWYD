/* =====================================================
			         generator.TextInput
	----------------------------------------------------
	Permet de gérer et de générer des inputs textuels
	de différents types.
	----------------------------------------------------
	Propriétés :
		render_to        : élément où afficher le formulaire (append)
		placeholder      : texte écrit quand le champ est vide
		min_size         : taille minimum (0 par défaut)
		max_size         : taille maximum (255 par défaut)
		check_onkey      : vérifie la valeur à chaque changement
		error_check_clbk : callback d'erreur de vérification
	    valid_check_clbk : callback de succès de vérification
	    check_clbk       : fonction supplémentaire de vérification
	                       (Doit renvoyer true ou false)
	    show_validation  : affiche l'état de la vérification

	Methodes :
		setRenderTo() : change le render_to 
		init()        : initialise l'objet 
		check()       : vérifie le validité du champ
		keyListener() : affecte une fonction à l'événement
		                keypress
		getValue()    : retourne la valeur du champ
		setValue()    : fixe la valeur du champ
   ===================================================== */

this.generator = this.generator || {};

generator.TextInput = function(args) {
	this.cls = "form-connection";
	this.type = "text";
	this.renderTo = args.render_to || false;
	this.placeholder = args.placeholder || "";
	this.min_size = args.min_size || 0;
	this.max_size = args.max_size || 255;
	this.disabled = args.disabled || false;
	this.check_onkey = args.check_onkey || false;
	this.error_check_callback = args.error_check_clbk || false;
	this.valid_check_callback = args.valid_check_clbk || false;
	this.check_callback = args.check_clbk || false;
	this.show_validation = args.show_validation || false;
}

generator.TextInput.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

generator.TextInput.prototype.check = function(e) {
	var me = this;

	if(me.element) {
		if(me.element.val().length <= this.max_size && me.element.val().length >= this.min_size) {
			if(!me.check_callback || me.check_callback(e, me.element)) {	
				if(me.valid_check_callback)
					me.valid_check_callback(e, me.element);

				if(me.show_validation) {
					me.validator.removeClass('form-connection-error');
					me.validator.addClass('form-connection-valid');
				}
				return true;
			}
		}
	}

	if(me.error_check_callback)
		me.error_check_callback(e, me.element);

	if(me.show_validation) {
		me.validator.addClass('form-connection-error');
		me.validator.removeClass('form-connection-valid');
	}

	return false;
}

generator.TextInput.prototype.init = function() {
	var me = this;

	if(me.renderTo) {
		me.element = $('<input />');

		me.element.attr("placeholder", this.placeholder);
		me.element.attr("maxlength", this.max_size);
		me.element.attr("type", this.type);
		if(me.disabled)
			me.element.attr('disabled', 'disabled');

		me.element.addClass(me.cls);
		me.element.addClass("form-connection");

		if(me.check_onkey) {
			me.element.on("input", function(){
				me.check();
			})
		}

		me.renderTo.append(me.element);

		if(me.show_validation) {
			me.validator = $('<div class="form-connection-info" />');
			me.renderTo.append(me.validator);
			me.element.css('float', 'left');
			me.element.css('display', 'inline-block');
		} else {
			me.element.css('width', '208px');
		}
	} else {
		console.log("Pas de renderTo défini");
	}
}

generator.TextInput.prototype.keyListener = function(f) {
	this.element.on('keypress', function(e) {
		f(e);
	});
}

generator.TextInput.prototype.getValue = function() {
	var me = this;

	if(me.element) {
		return me.element.val();
	} else {
		console.log("Pas d'element initialisé'");
		return false;
	}
}

generator.TextInput.prototype.setValue = function(value) {
	var me = this;

	if(me.element)
		me.element.val(value);
	else
		console.log("Pas d'element initialisé'");

}


/* =====================================================
			         generator.EmailInput
	----------------------------------------------------
	Permet de gérer et de générer des inputs textuels
	vérifiant une adresse mail.
	----------------------------------------------------
	Propriétés :
	    Voir inputText   
	Methodes :
	    Voir inputText      
   ===================================================== */

generator.EmailInput = function(args) {
	this.cls = "form-connection";
	this.type = "text";
	this.placeholder = args.placeholder || "";
	this.disabled = args.disabled || false;
	this.check_onkey = args.check_onkey || false;
	this.error_check_callback = args.error_check_clbk || false;
	this.valid_check_callback = args.error_check_clbk || false;
	this.check_callback = args.check_callback || false;
	this.show_validation = args.show_validation || false;
}

generator.EmailInput.prototype.check = function() {
	var me = this;
	var re = /\S+@\S+\.\S+/;

	if(me.element) {
		if(me.element.val().length > 0) {
			if(!me.check_callback || me.check_callback(e, me.element)) {
				if(re.test(me.element.val())) {	
					if(me.valid_check_callback)
						me.valid_check_callback(e, me.element);

					if(me.show_validation) {
						me.validator.removeClass('form-connection-error');
						me.validator.addClass('form-connection-valid');
					}
					return true;
				}
			}
		}
	}

	if(me.error_check_callback)
		me.error_check_callback(e, me.element);

	if(me.show_validation) {
		me.validator.addClass('form-connection-error');
		me.validator.removeClass('form-connection-valid');
	}

	return false;
}

generator.EmailInput.prototype.setRenderTo = generator.TextInput.prototype.setRenderTo;
generator.EmailInput.prototype.init = generator.TextInput.prototype.init;
generator.EmailInput.prototype.keyListener = generator.TextInput.prototype.keyListener;
generator.EmailInput.prototype.getValue = generator.TextInput.prototype.getValue;
generator.EmailInput.prototype.setValue = generator.TextInput.prototype.setValue;


/* =====================================================
			         generator.PasswordInput
	----------------------------------------------------
	Permet de gérer et de générer des inputs textuels
	pour mot de passe.
	----------------------------------------------------
	Propriétés :
	    Voir inputText   
	Methodes :
	    Voir inputText      
   ===================================================== */

generator.PasswordInput = function(args) {
	this.cls = "form-connection";
	this.type = "password";
	this.placeholder = args.placeholder || "";
	this.check_onkey = args.check_onkey || false;
	this.error_check_callback = args.error_check_clbk || false;
	this.valid_check_callback = args.error_check_clbk || false;
	this.check_callback = args.check_clbk || false;
	this.show_validation = args.show_validation || false;
	this.min_size = args.min_size || 0;
	this.max_size = args.max_size || 255;
	this.disabled = args.disabled || false;
}

generator.PasswordInput.prototype = generator.TextInput.prototype;

/* =====================================================
			         generator.AutoCompleteInput
	----------------------------------------------------
	Permet de gérer et de générer des inputs textuels
	avec autocompletion.
	----------------------------------------------------
	Propriétés :
		render_to        : élément où afficher le formulaire (append)
		placeholder      : texte écrit quand le champ est vide
		min_size         : taille minimum de lancement de l'autocompletion
		max_size         : taille maximum (255 par défaut)

	Methodes :
		setRenderTo()      : change le render_to 
		init()             : initialise l'objet 
		check()            : vérifie l'autocompletion
		keyListener()      : affecte une fonction à l'événement
		                     keypress
		getValue()         : retourne la valeur du champ
		setValue()         : fixe la valeur du champ
		showAutocomplete() : lance la recherche et l'affiche
		hideAutocomplete() : cache et vide la recherche en cours
   ===================================================== */

generator.AutoCompleteInput = function(args) {
	this.cls = "form-connection";
	this.type = "text";
	this.placeholder = args.placeholder || "";
	this.check_onkey = true; // Utilisé pour lancer la recherche automatiquement
	this.error_check_callback = false;
	this.valid_check_callback = false;
	this.check_callback = false;
	this.show_validation = false;
	this.min_size = args.min_size || 1;
	this.max_size = args.max_size || 255;
	this.disabled = args.disabled || false;
	this.width = args.width || 208;

	this.target = args.target || "../js/test.php"; //"target.php";
}

generator.AutoCompleteInput.prototype.setRenderTo = generator.TextInput.prototype.setRenderTo;
generator.AutoCompleteInput.prototype.keyListener = generator.TextInput.prototype.keyListener;
generator.AutoCompleteInput.prototype.getValue = generator.TextInput.prototype.getValue;
generator.AutoCompleteInput.prototype.setValue = generator.TextInput.prototype.setValue;


generator.AutoCompleteInput.prototype.init = function() {
	var me = this;

	if(me.renderTo) {
		me.element = $('<input />');

		me.element.attr("placeholder", this.placeholder);
		me.element.attr("maxlength", this.max_size);
		me.element.attr("type", this.type);
		if(me.disabled)
			me.element.attr('disabled', 'disabled');

		me.element.addClass(me.cls);
		me.element.addClass("form-connection");

		me.element.on("input", function() {
			 me.showAutocomplete();
		});

		me.element.on("blur", function() {
			 me.hideAutocomplete();
		});

		me.element.on("focus", function() {
			 me.showAutocomplete();
		});

		// Movement de l'autocompletion
		me.resetAutocomplete();

		me.element.on('keydown', function(e){
	    	if (e.keyCode == 38) { 
	    		// Si on peut encore remonter
	    		if(me.result_index > 0) {
	    			me.results[me.result_index].removeClass('selected');

	    			me.result_index--;

	    			if(me.result_index > 0) {
	    				me.results[me.result_index].addClass('selected');
	    				me.setValue(me.results[me.result_index].text());
	    			} else
	    				me.setValue(me.results[0]);
	    			
	    		}
	    		return false;
	    	} else if(e.keyCode == 40) {
	    		// Si on peut encore descendre
	    		if(me.result_index + 1 < me.results.length) {
	    			if(me.result_index > 0)
	    				me.results[me.result_index].removeClass('selected');

	    			me.result_index++;

	    			me.setValue(me.results[me.result_index].text());
					me.results[me.result_index].addClass('selected');
	    		}
	    		return false;
	    	}
	    });
		
		me.autocomplete_zone = $('<div />');
		me.autocomplete_zone.addClass(me.cls);
		me.autocomplete_zone.addClass('form-autocomplete');
		me.autocomplete_zone.css('display', 'none');
		me.autocomplete_results = [];

		me.renderTo.append(me.element);
		me.renderTo.append(me.autocomplete_zone);

		me.element.css('width', me.width);
		me.autocomplete_zone.css('width', me.width - 2);
		
	} else {
		console.log("Pas de renderTo défini");
	}
}



generator.AutoCompleteInput.prototype.showAutocomplete = function() {
	var me = this;

	if(me.getValue().length > me.min_size)
		me.check();
	else
		me.hideAutocomplete();
}

generator.AutoCompleteInput.prototype.hideAutocomplete = function() {
	var me = this;

	this.autocomplete_zone.slideUp(function() {
		me.element.removeClass('form-show-autocomplete');
	}); // on cache
	this.resetAutocomplete(); // on vide
}

generator.AutoCompleteInput.prototype.resetAutocomplete = function() {
	this.results = [];
	this.result_index = 0;
}

generator.AutoCompleteInput.prototype.check = function() {
	var me = this;

	//me.autocomplete_zone.css('width', me.element.width());
	me.resetAutocomplete();
	me.results.push(me.getValue());

	$.ajax({ type : 'POST',
         url      :  me.target,
         dataType : "json",
         data     : { data : me.getValue() } })
       .done(function(data) {
       	   if(data.success) {
       	   	  if(data.success.length > 0) {
       	   	  	var list = $('<ul />');
       	   	  	$(data.success).each(function(index, element) {
       	   	  		var elem = $('<li />');

       	   	  		elem.text(element);
       	   	  		list.append(elem);

       	   	  		me.results.push(elem);

       	   	  		elem.on('click', function() {
						me.setValue(element);
						//me.hideAutocomplete();
						me.results = [];
						me.index = 0;
					});
       	   	  	});
       	   	  	me.autocomplete_zone.empty();
       	   	  	me.autocomplete_zone.append(list);

       	   	  	me.element.addClass('form-show-autocomplete');
       	   	  	me.autocomplete_zone.slideDown();
       	   	  } else {
       	   	  	me.hideAutocomplete();
       	   	  }

       	   } else if(data.error) {
       	   	  console.log("Erreur PHP");

       	   } else {
           	   console.log("Erreur structure réponse");

       	   }
       })
       .fail(function() {
       	   console.log("Erreur Ajax");
       	   me.autocomplete_zone.html("Erreur Ajax");
       });
}
