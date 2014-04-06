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
				<!-- Panneau admin Javascript -->
			</section>
		</section>

		<script type="text/javascript">
		<!-- 
			$(document).ready(function () {

				// Test de fonctionnement des tabs -- temporaire avant le vrai code

				// Premier onglet
					// Premier panneau - recherche d'utilisateur avec autocompletion
					var tab1_p1_title = new generator.Title({ text: "Modération utilisateurs" });               // -- titre
					var tab1_p1_login = new generator.AutoCompleteInput({ placeholder : "Login" });             // -- login avec autocompletion

					var tab1_p1_form = new generator.Form(
						        { 	elements :
										[[{ item  : tab1_p1_title, width : 4 }],
										 [{ label : 'Login à modérer', item : tab1_p1_login, name : 'login' }],
										 []
										],
									design : "table",  
									submit_value : generator.icon('magnifier')+' Afficher les informations de l\'utilisateur',
									send : function() { tab1_p.showNext(); }
								});                                                                              // -- Formulaire de recherche

					var tab1_p1 = { elements : [ tab1_p1_form ], 
									valueNext : function() { return tab1_p1_login.getValue(); }
								  };                                                                             // -- Contenu du premier tableau

					// Second paneau - modification d'utilisateur avec formulaire pré-rempli
					var tab1_p2_title = new generator.Title({ text: "Modération utilisateur 'error'" });         // -- titre

					var tab1_p2_id = new generator.TextInput({ min_size : 1, disabled : true });                 // -- id de l'user
					var tab1_p2_login = new generator.TextInput({ min_size : 3, disabled : true });              // -- login de l'user

					var tab1_p2_mail = new generator.EmailInput({ placeholder : "Adresse mail", 
					                                              check_onkey : true, 
					                                              show_validation : true });                     // -- mail de l'user

					var tab1_p2_firstname = new generator.TextInput({ placeholder : 'Prénom (Facultatif)'});     // -- Prénom utilisateur
					var tab1_p2_lastname = new generator.TextInput({ placeholder : 'Nom (Facultatif)'});         // -- Nom utilisateur

					var tab1_p2_points_clbk = function(e, element) {
												  return !isNaN(parseInt(element.val()));
											  };
					var tab1_p2_points = new generator.TextInput({ placeholder : 'Nombre de points', 
					                                              check_onkey : true, 
					                                              show_validation : true,
					                                              check_clbk : tab1_p2_points_clbk });           // -- Nombre de points de l'utilisateur

					var tab1_p2_admin = new generator.Checkbox({ disabled : true });              // -- Admin ?
					var tab1_p2_premium = new generator.Checkbox({ disabled : true });            // -- Premium ?

			                                                                    // -- Message d'erreur

					var tab1_p2_back = new generator.Button({ text : generator.icon('arrow-left')+' Revenir à la recherche', 
															  css  : { width : "250" },
						                                      onClick : function() { 
						                                      	tab1_p.showPrevious(); 
						                                      } 
						                                     });                                                 // -- Bouton de retour

					var tab1_p2_reset = new generator.Button({ text : generator.icon('reset')+' Réinitialiser les données', 
															   css  : { width : "250" },
						                                       onClick : function() { 
						                                      	tab1_p2_form.fill(tab1_p1_login.getValue());
						                                       } 
						                                     });                                                // -- Bouton de reset

					var tab1_p2_error_load_clbk = function(data) {
						 tab1_p2_form.disable();
						 generator.Message.prototype.genError(data, function() {
						 	tab1_p.showPrevious(); 
						 });
					};                                                                                          // -- Erreur de chargement, aucun utilisateur correspondant

					var tab1_p2_fail_load_clbk = function(data) {
						 tab1_p2_form.disable();
						 generator.Message.prototype.genAjaxError(data, function() {
						 	tab1_p.showPrevious(); 
						 });                                                                                    // -- Erreur Ajax
					};

					var tab1_p2_success_load_clbk = function(data) {
						 tab1_p2_form.enable();
					};                                                                                          // -- Success du chargement

					var tab1_p2_form = new generator.Form( 
								{ elements :
									[[{ item  : tab1_p2_title, name : 'title', width : 4 }],
									 [
									  { label : 'ID',     item : tab1_p2_id,     name : 'id'      }, { space : '30px' },
									  { label : 'Points', item : tab1_p2_points, name : 'nb_point'}
									 ],
									 [
									  { label : 'Administrateur', item : tab1_p2_admin,   name : 'admin'  }, { space : '30px' },
									  { label : 'Premium',        item : tab1_p2_premium, name : 'premium'}
									 ],
									 [],
									 [
									  { label : 'Login',        item : tab1_p2_login, name : 'login'}, { space : '30px' },
									  { label : 'Adresse mail', item : tab1_p2_mail,  name : 'mail' }
									 ],
									 [],
									 [{ label : 'Prénom', item : tab1_p2_firstname, name : 'first_name'}],
									 [{ label : 'Nom',    item : tab1_p2_lastname,  name : 'last_name' }],
									 [],
									 [{ item : tab1_p2_back,  name : 'back_button',  width : 2 }],
									 [{ item : tab1_p2_reset, name : 'reset_button', width : 2 }],
									 []
									],
									design : "table", 
									target : "admin_change_user.php", 
									source : "admin_search_user.php",
									/*success_clbk : function() { alert("success"); },
									error_clbk : function() { alert("error"); }, 
									fail_clbk : generator.Message.prototype.genAjaxError,*/
									success_load_clbk : tab1_p2_success_load_clbk,
									error_load_clbk   : tab1_p2_error_load_clbk,
									fail_load_clbk    : tab1_p2_fail_load_clbk,
									submits : [{ target : 'admin_change_user.php', 
									             value  : generator.icon('tick')+' Modifier les informations de l\'utilisateur' 
									           },
									           { target : 'admin_delete_user.php', 
									             value  : generator.icon('cross')+' Supprimer l\'utilisateur' 
									           }
									          ]
								});                                                                              // -- Formulaire de modification


				                                                                       
					var tab1_p2 = { elements : [ tab1_p2_form ],
									valuePrevious : function() { return ''; }
								  };                                                                             // -- Contenu du second panneau

					var tab1_p = new generator.Panel({ panels : [ tab1_p1, tab1_p2 ] });                         // -- Panneaux du premier onglet

					var tab1 = { title    : '<span class="icon user"></span> Utilisateurs', elements : tab1_p };                                 // -- Contenu du premier onglet

				// Second onglet
					// Placeholder en attendant de le faire !
					var login2 = new generator.TextInput({ placeholder : "Nom du compte", min_size : 3, check_onkey : true, show_validation : true });
					var mail2 = new generator.EmailInput({ placeholder : "Adresse mail", check_onkey : true, show_validation : true });

					var pass2 = new generator.PasswordInput({ placeholder : 'Mot de passe', min_size : 3, check_onkey : true, show_validation : true, check_clbk : function() { return (pass_check.getValue() == pass.getValue()); }});
					var pass_check2 = new generator.PasswordInput({ placeholder : 'Vérification mot de passe', min_size : 3, check_onkey : true, check_clbk : function() { pass.check(); }});

					var firstname2 = new generator.TextInput({ placeholder : 'Prénom (Facultatif)'});
					var lastname2 = new generator.TextInput({ placeholder : 'Nom (Facultatif)'});

					var tab2 = {
				   			 	title    : '<span class="icon list"></span> Catégories',
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
				   			   };

				   	var tab3 = { title : '<span class="icon edit"></span> Sujets & messages' };

				// Construction des onglets
				var tab = new generator.Tab({ render_to : $('#admin-panel'), tabs : [ tab1, tab2, tab3 ] });
				tab.init();

			});

		-->
		</script>

<?php
	include("footer.php");
?>