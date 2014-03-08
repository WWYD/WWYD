
this.html = this.html || {};
/*
// Message
html.Message = function(div, type, title, message, dismissible, modal, dismiss_call_back) {
	this.renderTo = div;
	this.type = type || "error";
	this.title = title || "Erreur";
	this.message = message || "Une erreur est survenue";
	this.dismissible = dismissible || false;
	this.modal = modal || false;
}

html.Message.prototype.init = function() {

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

	$("body").append(me.container);
	me.container.animate({
			    top: "toggle",
			    opacity: "toggle"});

	if(me.dismissible) {
		var exit = $('<div class="close" />');
		exit.on("click", function(e) {
			me.container.animate({ top: "toggle",
			                       opacity: "toggle"}, 
			                       function() {
			                       	  this.remove();
			                       });
			if(me.modal) 
				me.modal_window.remove();
		});
		me.container.prepend(exit);
	}

	// Modal
	if(me.modal) {
		me.modal_window = $('<div class="modal-pop-up" />');
		$("body").append(me.modal_window);
	}
}
*/

// Lightbox perso
/*
html.TTBox = function(args) {
	args = args || {};

	this.height = args.height || false;
	this.width = args.width || false;
	this.elements = args.elements || [];
	this.dismissible = args.dismissible || true;
	this.dismiss_on_close = args.dismiss_on_close || true;
	this.creation_callback = args.creation_cbk || false;
	this.deletion_callback = args.deletion_cbk || false;
}

html.TTBox.prototype.init = function() {

	var me = this;

	me.container = $('<div class="ttbox-global" style="display: none;" />');
	me.window = $('<div class="ttbox-frame" style="display: none;" />');

	me.container.append(me.window);

	// Ajout des éléments
	$(me.elements).each(function (index, element) {
		element.item.setRenderTo(me.window);
		element.item.init();
	});

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

		me.window.prepend(exit);
	}

	$(window).resize(function() {
		me.resize();
	});

	// Affichage
	me.resize();
	$("body").append(me.container);
}

html.TTBox.prototype.show = function() {

	var me = this;

	me.container.fadeIn(200, function() {
		me.window.animate({ top: "toggle",
			               opacity: "toggle"});
	});
}

html.TTBox.prototype.hide = function() {

	var me = this;

	me.container.fadeOut(200);
}

html.TTBox.prototype.dismiss = function() {

	var me = this;

	me.window.animate({ top: "toggle",
		                opacity: "toggle"}, function() {
							me.container.fadeOut(200, function() {
								me.container.remove();
							});
		               });
}

html.TTBox.prototype.resize = function() {

	var me = this;

	if(me.height)
		me.window.css("height", me.height);

	if(me.width) {
		me.window.css("width", me.width);
		me.window.css("margin-left", - (me.width / 2)); // center
	}
}*/

// Menu navigation
html.Menu = function(div, values) {
	this.cls = "myMenu";
	this.renderTo = div;
	this.items = values;
}

html.Menu.prototype.init = function() {
	var me = this;
	me.container = $('<ul class="myMenu"/>');
	me.renderTo.append(me.container);

	$(this.items).each(function(index, item) {
		var li = $("<li/>");
		li.text(item.label);
		me.container.append(li);

		if(item.click)
			$(li).on("click", function(e) {
				item.click(e);
			});
	});
};


// Input type text
html.TextInput = function(placeholder, min_size, max_size, error_check_callback, valid_check_callback, check_callback) {
	this.cls = "myTextInput";
	this.type = "text";
	this.placeholder = placeholder || "";
	this.min_size = min_size || 0;
	this.max_size = max_size || 255;
	this.error_check_callback = error_check_callback;
	this.valid_check_callback = error_check_callback;
	this.check_callback = check_callback;
}

html.TextInput.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

html.TextInput.prototype.check = function(e) {
	var me = this;

	if(me.element) {
		if(me.element.val().length <= this.max_size && me.element.val().length >= this.min_size) {
			if(!me.check_callback || me.check_callback(e, me.element)) {	
				if(me.valid_check_callback)
					me.valid_check_callback(e, me.element);
				return true;
			}
		}
	}

	if(me.error_check_callback)
		me.error_check_callback(e, me.element);

	return false;
}

html.TextInput.prototype.init = function() {
	var me = this;

	if(me.renderTo) {
		me.element = $('<input />');

		me.element.attr("placeholder", this.placeholder);
		me.element.attr("maxlength", this.max_size);
		me.element.attr("type", this.type);

		me.element.addClass(me.cls);
		me.element.addClass("form-connection");

		me.renderTo.append(me.element);
	} else {
		console.log("Pas de renderTo défini");
	}
}

html.TextInput.prototype.keyListener = function(f) {
	this.element.on('keypress', function(e) {
		f(e);
	});
}

html.TextInput.prototype.getValue = function() {
	var me = this;

	if(me.element) {
		return me.element.val();
	} else {
		console.log("Pas d'element initialisé'");
		return false;
	}
}

// Input type téléphone
html.PhoneNumberInput = function(placeholder,error_check_callback, valid_check_callback, check_callback) {
	this.cls = "myPhoneNumberInput";
	this.type = "text";
	this.placeholder = placeholder || "";
	this.error_check_callback = error_check_callback;
	this.valid_check_callback = valid_check_callback;
	this.check_callback = check_callback;
	this.regex = /(\+\d+(\s|-))?0\d(\s|-)?(\d{2}(\s|-)?){4}/;
}

// Héritage de phoneNumber
html.PhoneNumberInput.prototype.setRenderTo = html.TextInput.prototype.setRenderTo;
html.PhoneNumberInput.prototype.init = html.TextInput.prototype.init;
html.PhoneNumberInput.prototype.keyListener = html.TextInput.prototype.keyListener;
html.PhoneNumberInput.prototype.getValue = html.TextInput.prototype.getValue;

html.PhoneNumberInput.prototype.check = function(e) {
	var me = this;

	if(me.element) {
		if(me.element.val().match(me.regex)) {
			if(!me.check_callback || me.check_callback(e, me.element)) {	
				if(me.valid_check_callback)
					me.valid_check_callback(e, me.element);
				return true;
			}
		}
	}
	if(me.error_check_callback)
		me.error_check_callback(e, me.element);

	return false;
}

// Imput type password
html.PasswordInput = function(placeholder, min_size, max_size, error_check_callback, valid_check_callback, check_callback) {
	this.cls = "myPasswordInput";
	this.type = "password";
	this.placeholder = placeholder || "";
	this.min_size = min_size || 0;
	this.max_size = max_size || 255;
	this.error_check_callback = error_check_callback;
	this.valid_check_callback = error_check_callback;
	this.check_callback = check_callback;
}

// Héritage de password
html.PasswordInput.prototype = html.TextInput.prototype;

/*
[[{ item  : new html.Title("Inscription"), width : 4, center : true }],
 [{ label : "Nom", item : new html.TextInput(), name : "nom" }, { label : "Prénom", item : new html.TextInput(), name : "prenom" }]
 [{ label : "Ville", item : new html.TextInput(), name : "ville" }]
 ]
*/

/*
// Formulaire
html.Form = function(args) {
	var args = args || {};

	this.cls = "generated-form";
	this.renderTo = args.render_to || null;
	this.elements = args.elements || [];
	this.submit_value = args.submit_value || "Valider";
	this.target = args.target || "target.php";
	this.success_clbk = args.success_clbk;
	this.error_clbk = args.error_clbk;
	this.error_ajax_clbk = args.error_ajax_clbk;
	this.design = args.design || "flow"; // flow ou table (voir + loin pour table)
	this.fields = [];
}

html.Form.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

html.Form.prototype.check = function(e) {

	var me = this;
	var result = true;

	$(me.fileds).each(function(index, element) {
		if(element.check)
			if(element.check(e)) 
				result = result ? true : false;
			else
				result = false;
	});

	return result;
}

html.Form.prototype.send = function(e) {
	var me = this;

	if(me.check()) {
		var to_send = [];
		$(me.fields).each(function(index, element) {
			to_send[index] = { name : element.name, value : element.getValue() };
		});

		$.ajax({ type     : 'POST',
	             url      :  me.target,
	             dataType : "json",
	             data     : { data : to_send }})
	           .done(function(data) {
	           	   console.log(data);
	           	   if(data.success) {
	           	      if(me.success_clbk)
	                       me.success_clbk(data);
	           	   } else {
	           	   	  console.log("Erreur PHP");
	           	      if(me.error_clbk)
	                       me.error_clbk(data);
	           	   }
	           })
	           .fail(function() {
	           	   console.log("Erreur Ajax");
	           	   if(me.error_ajax_clbk)
	           	   	   me.error_ajax_clbk();
	           });
    }
}

html.Form.prototype.init = function() {
	var me = this;
	var keyListener = function(e) {
		var code = e.keyCode || e.which;

		 //Enter keycode
		if(code == 13) {
		   me.send(e);
		}

	};

	// Structure
	me.container = $('<div class="myForm" />');
	me.renderTo.append(me.container);

	// Elements
	if(me.design == "flow") {

		var i = 0;

		$(me.elements).each(function(index, element) {

			var p = $("<p/>");
			var label = $("<p/>");

			label.text(element.label);
			p.append(label);

			element.item.setRenderTo(p);
			element.item.init();

			if(element.item.keyListener)
				element.item.keyListener(keyListener);

			me.container.append(p);

			me.fields[i++] = element.item;
		});


		// Submit
		me.submit = $('<input type="submit" class="btn" />');
		me.submit.val(this.submit_value);
		me.submit.on("click", function(e) {
			me.send(e);
		});
		me.container.append(me.submit);
	} else if (me.design == "table") {

		var p = $("<p/>");
		var label = $("<p/>");
		var table = $("<table/>");

		table.addClass("form-table")

		var i = 0;

		$(me.elements).each(function(index, line_elements) {

			var line = $("<tr />");

			// On attend ici des lignes
			$(line_elements).each(function(index, element) {

				if(element.label) {

					var label = $('<td />');

					label.text(element.label);
					line.append(label);
				}

				var data = $('<td />');

				if(element.width)
					data.attr("colspan", element.width);

				element.item.setRenderTo(data);
				element.item.init();

				if(element.item.keyListener)
					element.item.keyListener(keyListener);

				line.append(data);

				me.fields[i++] = element.item;
			});

			table.append(line);
		});

		me.container.append(table);

		// Submit
		me.submit = $('<input type="submit" class="btn" style="display: inline-block;" />');
		me.submit.val(this.submit_value);
		me.submit.on("click", function(e) {
			me.send(e);
		});
		var centered  = $('<p style="text-align: center; margin: 0;" />');
		centered.append(me.submit);
		me.container.append(centered);

	}
}*/


/* Tests :

var myMenu = new html.Menu($("#menu"), [{ label : "Label 1" }, 
	                                    { label : "Label 2", click : function(e){
	                                    	box = new html.TTBox($("body"));
	                                    	box.init();

	                                    	box.show();

	                                    }}, 
	                                    { label : "Label 3", click : function(e){
	                                    	//alert("Bonjour");
var myForm = new html.Form($("#content"), [{ label : "Premier label", item : new html.TextInput("Premier input", 0, 10), name : "label1"},
	                                       { label : "Second label (password)", item : new html.PasswordInput("Second input", 0, 5), name : "label2"},
	                                       { label : "Troisieme label (téléphone)", item : new html.PhoneNumberInput("Téléphone", 
	                                       	          function(e, elem){ elem.css("background-color","red"); })}], "test.php",
	                                       function(data) { 
$("#content").fadeOut(200, function() {
$(this).empty();
var myMenu = new html.Message($("#content"), "success", "Valeur calculée : "+data.success.result, "Résultat");
myMenu.init();
}).fadeIn(200);
	                                       	/*alert(data.success.result); } , function(data) { alert(data.error.msg); } );

myForm.init();
	                                    }}]);
myMenu.init();

*/

