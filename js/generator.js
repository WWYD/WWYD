
this.generator = this.generator || {};

this.generator.icon = function(name) {
	return '<span class="icon '+name+'"></span>';
}

this.generator.BBCode = function(text) {

	// Balises simples
	balises = { b : "b", i : "i", u : 'u', quote : 'div class="quote" ' };

	for(balise in balises) {
		r = new RegExp("\\[" + balise + "\\](.*)\\[\\/" + balise + "\\]");
		text = text.replace(r,  "<"+balises[balise]+">$1</"+balises[balise]+">");
	}

	// Quotes avec nom
	text = text.replace(/\[quote=(.*)\](.*)\[\/quote\]/, '<div class="quote"><span class="quoted"><b>$1</b> à dit :</span>$2</div>');

	return text;
}

this.generator.htmlEntities = function(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

this.generator.scriptPHP = function(args) {

	this.connection = args.connection || false;  // Si on doit être connecté
	this.banned = args.banned || false;          // Si on doit ne pas être ban

	this.fields = args.fields || [];             // Liste des champs à vérifier

	this.SQL = args.SQL || "";                   // Requête SQL

	this.SQL_type = args.SQL_type || "select";        // Type de requête
	this.success = args.success || "";           // En cas de succès, message à envoyer

	// Début de la page
	this.PHP = "<?php\n";
	if(this.connection)
		this.PHP += "\tsession_start();\n";

	// Première série de vérification
	this.PHP += "\tif(";
	if(this.connection) {
		this.PHP += "isset($_SESSION['user']) AND ";
		if(this.banned) {
			this.PHP += "$_SESSION['user']['banned'] AND ";
		}
	}
	this.PHP += "isset($_POST['data'])) {\n";

		// Décodage du JSON vers des objets
		this.PHP += "\t\t$data = json_decode($_POST['data']);\n";
		this.PHP += "\t\tif(isset($data->data)) {\n";
			this.PHP += "\t\t\t$data = $data->data;\n";

			// Vérification des champs
			this.PHP += "\t\t\tif(";
			for(var i = 0; i < this.fields.length; i++) {
				if(i > 0)
					this.PHP += ' AND ';
				this.PHP += 'isset($data->'+this.fields[i]+')';
			}
			this.PHP += ") {\n";
			
				// Try & catch
				this.PHP += "\t\t\t\ttry {\n";

				// Cas d'un select
				if(this.SQL_type == 'select') {
					// Requête
					this.PHP += "\t\t\t\t\t$query = $bdd -> prepare('"+this.SQL+"');\n";
					// Champs
					this.PHP += "\t\t\t\t\t$query->execute(Array(";
					for(var i = 0; i < this.fields.length; i++) {
						if(i > 0)
							this.PHP += ', ';
						this.PHP += '$data->'+this.fields[i];
					}
					this.PHP += "));\n"
					// Récupération
					this.PHP += "\t\t\t\t\twhile($data = $query->fetch()) { }\n"
				}

				// Fin try & catch
				this.PHP += "\t\t\t\t} catch ( Exception $e ) {\n";
				this.PHP += "\t\t\t\t\t$r = array('error' => array('title' => 'Erreur', 'msg' => 'Erreur BDD'));\n";
				this.PHP += "\t\t\t\t}\n";

			// Fin de vérification des champs
			this.PHP += "\t\t\t} else\n\t\t\t\t$r = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues incomplètes'));\n";
		
		// Fin de vérification des champs
		this.PHP += "\t\t} else\n\t\t\t$r = array('error' => array('title' => 'Erreur', 'msg' => 'Données reçues ma formées'));\n";

	// Fin de vérification des champs
	this.PHP += "\t} else\n\t\t$r = array('error' => array('title' => 'Erreur', 'msg' => 'Aucune données reçues'));\n";

	this.PHP += "\techo json_encode($r);\n";
	this.PHP += "?>\n\n";

	return generator.htmlEntities(this.PHP);
}

/*
// Menu navigation
html.Menu = function(args) {
	this.cls = "generated-menu";
	this.renderTo = args.render_to;
	this.elements = args.elements || {};
}

html.Menu.prototype.init = function() {
	var me = this;
	me.container = $('<ul />');
	me.container.addClass(me.cls);

	$(this.elements).each(function(index, item) {
		var li = $("<li/>");
		li.text(item.label);

		if(item.click)
			$(li).on("click", function(e) {
				item.click(e);
			});
		
		me.container.append(li);
	});

	me.renderTo.append(me.container);
};

*/

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
