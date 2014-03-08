
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
html.TTBox = function(div, elements, dismissible) {
	this.renderTo = div;
	this.elements = elements;
	this.dismissible = dismissible || true;
	console.log(elements);
}

html.TTBox.prototype.init = function() {
	var me = this;

	me.container = $('<div id="ttbox_global" />');
	me.info = $('<div id="ttbox_frame" />');

	me.container.append(me.info);

	$(me.elements).each(function (index, element) {
		element.item.setRenderTo(me.info);
		element.item.init();
	});


	me.renderTo.append(me.container);

	if(me.dismissible) {
		me.container.on("click", function(e) {
			if($(e.target)[0] == me.container[0]) {
				me.hide();
			}
		});
	}
}

html.TTBox.prototype.show = function() {
	var me = this;
	me.container.fadeIn(200);
}

html.TTBox.prototype.hide = function() {
	var me = this;
	me.container.fadeOut(200);
}

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
		me.renderTo.append(me.element);

		me.element.attr("placeholder", this.placeholder);
		me.element.attr("maxlength", this.max_size);
		me.element.attr("type", this.type);

		me.element.addClass(me.cls);
		me.element.addClass("form-connection");
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


// Formulaire
html.Form = function(div, elements, target, submit_value, success_callback, error_callback, error_ajax_callback) {
	this.cls = "myForm";
	this.renderTo = div || null;
	this.elements = elements;
	this.submit_value = submit_value || "Valider";
	this.target = target;
	this.success_callback = success_callback;
	this.error_callback = error_callback;
	this.error_ajax_callback = error_ajax_callback;
}

html.Form.prototype.setRenderTo = function(renderTo) {
	this.renderTo = renderTo;
}

html.Form.prototype.check = function(e) {
	var me = this;
	var result = true;

	$(me.elements).each(function(index, element) {
		if(element.item.check)
			if(element.item.check(e)) 
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
		$(me.elements).each(function(index, element) {
			to_send[index] = { name : element.name, value : element.item.getValue() };
		});

		$.ajax({ type     : 'POST',
	             url      :  me.target,
	             dataType : "json",
	             data     : { data : to_send }})
	           .done(function(data) {
	           	   console.log(data);
	           	   if(data.success) {
	           	      if(me.success_callback)
	                       me.success_callback(data);
	           	   } else {
	           	   	  console.log("Erreur PHP");
	           	      if(me.error_callback)
	                       me.error_callback(data);
	           	   }
	           })
	           .fail(function() {
	           	console.log(me.target);
	           	   console.log("Erreur Ajax");
	           	   if(me.error_ajax_callback)
	           	   	   me.error_ajax_callback();
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
	});

	// Submit
	me.submit = $('<input type="submit" class="btn" />');
	me.submit.val(this.submit_value);
	me.container.append(me.submit);
	me.submit.on("click", function(e) {
		me.send(e);
	});

}


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

