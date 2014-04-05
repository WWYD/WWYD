<?php
	include("header.php");
?>

		<div style="width: 100%;  background-color: #DEDEDE;">
			<div class="content" style="padding: 30px; margin: auto;">
				<p style="font-size: 22pt; padding-left: 20px;">Administration</p>

			</div>
		</div>
		
		<section >
		<section>
			<section id="admin-panel" style="width: 100%; float: left;">
				<!--<ul class="panel-menu">
					<li class="selected">Gestion utilisateurs</li>
					<li>Gestion catégories</li>
					<li>Gestion sujets &amp; messages</li>
				</ul>
				<div class="panel-content">
					<table style="border-collapse : separate">
						<form action="form.php" method="POST">
							<tr><td>Nom de compte* : </td><td style="padding: 3px"><input type="text" name="login" id="login" class="form-connection" size="40"/></td><td><span id="login_check"></span></td></tr>
							<tr><td>Mail* : </td><td style="padding: 3px"><input type="text" name="mail" id="mail" class="form-connection" size="40"/></td><td><span id="mail_check"></span></td></tr>
							<tr><td colspan="2"><br/></td></tr>
							<tr><td>Mot de passe* : </td><td style="padding: 3px"><input type="password" name="password" id="password" class="form-connection" size="40"/></td></tr>
							<tr><td>Retapez le mot de passe* :	</td><td style="padding: 3px"><input type="password" name="pass_check" id="pass_check" class="form-connection" size="30"><div class="form-connection-info form-connection-not"></div></td><td><span id="password_check"></span></td></tr>
							<tr><td colspan="2"><br/></td></tr>
							<tr><td>Prénom : </td><td style="padding: 3px"><input type="text" name="first_name" class="form-connection" size="30"><div class="form-connection-info form-connection-error"></div></td></tr>
							<tr><td>Nom : </td><td style="padding: 3px"><input type="text" name="last_name" class="form-connection" size="30"><div class="form-connection-info form-connection-valid"></div></td></tr>
							<tr><td colspan="2"><span style="float: right; font-size: 9pt"><i>Les champs marqués d'un * sont obligatoires</i></span></td></tr>
							<tr><td colspan="2"><br/></td></tr>
							<tr><td><p style="height: 20px; padding-right: 0px;"><button type="submit" class="btn" style="float: right">Valider l'inscription <span class="respond"></span></button></p></td></tr>
						</form>
					</table>
				</div> -->
				( Test horrible pour le changement de panel de l'onglet 1 ) : <br/>
				<a href="#" onclick="panel1.showPrevious()">previous    </a>
				<a href="#" onclick="panel1.showNext()">next</a> <br/>
			</section>
		</section>

		<script type="text/javascript">
		<!-- 
			$(document).ready(function () {

				// Test de fonctionnement des tabs -- temporaire avant le vrai code

				// Valeurs des tabs
				var login = new generator.AutoCompleteInput({ placeholder : "Login" });
				var mail = new generator.EmailInput({ placeholder : "Adresse mail", check_onkey : true, show_validation : true });

				var pass = new generator.PasswordInput({ placeholder : 'Mot de passe', min_size : 3, check_onkey : true, show_validation : true, check_clbk : function() { return (pass_check.getValue() == pass.getValue()); }});
				var pass_check = new generator.PasswordInput({ placeholder : 'Vérification mot de passe', min_size : 3, check_onkey : true, check_clbk : function() { pass.check(); }});

				var firstname = new generator.TextInput({ placeholder : 'Prénom (Facultatif)'});
				var lastname = new generator.TextInput({ placeholder : 'Nom (Facultatif)'});

				var login2 = new generator.TextInput({ placeholder : "Nom du compte", min_size : 3, check_onkey : true, show_validation : true });
				var mail2 = new generator.EmailInput({ placeholder : "Adresse mail", check_onkey : true, show_validation : true });

				var pass2 = new generator.PasswordInput({ placeholder : 'Mot de passe', min_size : 3, check_onkey : true, show_validation : true, check_clbk : function() { return (pass_check.getValue() == pass.getValue()); }});
				var pass_check2 = new generator.PasswordInput({ placeholder : 'Vérification mot de passe', min_size : 3, check_onkey : true, check_clbk : function() { pass.check(); }});

				var firstname2 = new generator.TextInput({ placeholder : 'Prénom (Facultatif)'});
				var lastname2 = new generator.TextInput({ placeholder : 'Nom (Facultatif)'});

				 panel1 = new generator.Panel(
					 { panels : 
					 	[
					 	    [
						new generator.Form( { elements :
							[[{ item  : new generator.Title({ text: "Recherche utilisateurs" }), width : 4 }],
							 [{ label : 'Login', item : login, name : 'login' }],
							 [{ label : 'Adresse mail', item : mail, name : 'mail'}],
							 [],
							 [{ label : 'Mot de passe', item : pass, name : 'password' }],
							 [{ label : 'Vérification', item : pass_check }],
							 [],
							 [{ label : 'Prénom', item : firstname, name : 'firstname'}],
							 [{ label : 'Nom', item : lastname, name : 'lastname'}]
							],
							design : "table", target : "form - new.php", success_clbk : function() { alert("success"); },
							error_clbk : function() { alert("error"); }, fail_clbk : function() { alert("fail"); }
						})
						],

						[
						new generator.Form( { elements :
							[[{ item  : new generator.Title({ text: "Recherche utilisateurs - panel 2" }), width : 4 }],
							 [{ label : 'Login', item : login2, name : 'login' }],
							 [{ label : 'Adresse mail', item : mail, name : 'mail'}],
							 [],
							 [{ label : 'Mot de passe', item : pass, name : 'password' }],
							 [{ label : 'Vérification', item : pass_check }],
							 [],
							 [{ label : 'Prénom', item : firstname, name : 'firstname'}],
							 [{ label : 'Nom', item : lastname, name : 'lastname'}]
							],
							design : "table", target : "form - new.php", success_clbk : function() { alert("success"); },
							error_clbk : function() { alert("error"); }, fail_clbk : function() { alert("fail"); }
						})
						],
						]
					 }
					);

				// Creation des tabs
				var tabs = new generator.Tab({ render_to : $('#admin-panel'),
											   tabs :   [
											   			 {
											   			 	title    : "Utilisateurs",
											   				elements : panel1
											   			 },

											   			 {
											   			 	title    : "Catégories",
											   			    elements :
											   							new generator.Form(
																			{ elements :
																				[[{ item  : new generator.Title({ text: "Formulaire d'inscription 2" }), width : 4 }],
																				 [{ label : 'Login 2', item : login2, name : 'login' }],
																				 [{ label : 'Adresse mail 2', item : mail2, name : 'mail'}],
																				 [],
																				 [{ label : 'Mot de passe 2', item : pass2, name : 'password' }],
																				 [{ label : 'Vérification 2', item : pass_check2 }],
																				 [],
																				 [{ label : 'Prénom 2', item : firstname2, name : 'firstname'}],
																				 [{ label : 'Nom 2', item : lastname2, name : 'lastname'}]
																				],
																				design : "table", target : "form - new.php", success_clbk : function() { alert("success"); },
																				error_clbk : function() { alert("error"); }, fail_clbk : function() { alert("fail"); }
																			}
											   							)
											   			 }
											   			]
												});
				tabs.init();
			});
		-->
		</script>

<?php
	include("footer.php");
?>