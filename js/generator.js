
this.html = this.html || {};

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



/*
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
*/
