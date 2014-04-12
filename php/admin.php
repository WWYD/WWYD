<?php
	if(!(is_co() && $_SESSION['user']['admin']))
		header("Location: ?/");
?>

		<div style="width: 100%;  background-color: #DEDEDE;">
			<div class="content" style="padding: 30px; margin: auto;">
				<p style="font-size: 22pt; padding-left: 20px;">Administration</p>

			</div>
		</div>
		
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
					var tab1_p1_login = new generator.AutoCompleteInput({ placeholder : "Login", target : "php/script/search_user.php" });             // -- login avec autocompletion

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

					var tab1_p2_admin = new generator.Checkbox({ disabled : true });                             // -- Admin ?
					var tab1_p2_premium = new generator.Checkbox({ disabled : true });                           // -- Premium ?

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
									target : "php/script/admin_change_user.php", 
									source : "php/script/admin_search_user.php",
									/*success_clbk : function() { alert("success"); },
									error_clbk : function() { alert("error"); }, 
									fail_clbk : generator.Message.prototype.genAjaxError,*/
									success_load_clbk : tab1_p2_success_load_clbk,
									error_load_clbk   : tab1_p2_error_load_clbk,
									fail_load_clbk    : tab1_p2_fail_load_clbk,
									submits : [{ target : 'php/script/admin_change_user.php', 
									             value  : generator.icon('tick')+' Modifier les informations de l\'utilisateur' 
									           },
									           { target : 'php/script/admin_delete_user.php', 
									             value  : generator.icon('cross')+' Supprimer l\'utilisateur' 
									           }
									          ]
								});                                                                              // -- Formulaire de modification


				                                                                       
					var tab1_p2 = { elements : [ tab1_p2_form ],
									valuePrevious : function() { return ''; }
								  };                                                                             // -- Contenu du second panneau

					var tab1_p = new generator.Panel({ panels : [ tab1_p1, tab1_p2 ] });                         // -- Panneaux du premier onglet

					var tab1 = { title    : '<span class="icon user"></span> Utilisateurs', elements : tab1_p };       
					                                                                                             // -- Contenu du premier onglet

				// Second onglet
					// Panneau 1 de recherche
					var tab2_p1_button_new = new generator.Button({ text  : generator.icon('plus')+" Ajouter nouvelle catégorie",
																	css : { "margin-botton" : "10px" },
																    onClick : function() {
																    	tab2_p2_box.show();
																    }
																   });

					var tab2_p1_func = function(data) {
						var button = new generator.Button({ text  : generator.icon('pencil')+" Modifier",
										   	                      small : true,
															      css   : { 'float' : 'right', 'margin-top' : '-40px' },
															      onClick : function() {
															      	tab2_p.showNext(data.id);
															      }
														  });

						return new generator.Div({
							title : data.name,
							elements  : [
										   new generator.Paragraph({ text : data.description }),
										   button
							            ]
						});
					};

					var tab2_p1_search = new generator.Paginate( {
				   			    				source    : "php/script/admin_show_cat.php",
				   			    				page_size : 5,
				   			    				model     : tab2_p1_func,
				   			    				data      : {}
				   			    			});

					var tab2_p1 = { elements : [ tab2_p1_button_new, tab2_p1_search ] };   

					// Panneau d'édition
					var tab2_p2_title = new generator.Title({ text: "Modification catégorie 'error'" });         // -- titre

					var tab2_p2_name = new generator.TextInput({ min_size : 3, check_onkey : true, show_validation : true, });
					                                                                                             // -- nom catégorie

					var tab2_p2_back = new generator.Button({ text : generator.icon('arrow-left')+' Revenir à la recherche', 
															  css  : { width : "250" },
						                                      onClick : function() { 
						                                      	tab2_p.showPrevious(); 
						                                      } 
						                                     });                                                 // -- Bouton de retour

					var tab2_p2_error_load_clbk = function(data) {
						 tab2_p2_form.disable();
						 generator.Message.prototype.genError(data, function() {
						 	tab2_p.showPrevious(); 
						 });
					};                                                                                          // -- Erreur de chargement, aucun utilisateur correspondant

					var tab2_p2_fail_load_clbk = function(data) {
						 tab2_p2_form.disable();
						 generator.Message.prototype.genAjaxError(data, function() {
						 	tab2_p.showPrevious(); 
						 });                                                                                    // -- Erreur Ajax
					};

					var tab2_p2_success_load_clbk = function(data) {
						 tab2_p2_form.enable();
					};    

					var tab2_p2_form = new generator.Form(
						        { 	elements :
										[[{ item  : tab2_p2_title, name : 'title', width : 4 }],
										 [{ label : 'ID', item : new generator.TextInput({ min_size : 0, disabled : true }), name : 'id' }],
										 [{ label : 'Nom catégorie', item : tab2_p2_name, name : 'name' }],
										 [{ label : 'Description catégorie', item : new generator.TextInput({ min_size : 0 }), name : 'desc' }],
										 [],
										 [{ item : tab2_p2_back,  name : 'back_button',  width : 2 }],
										 []
										],
									design : "table",  
									target : "php/script/admin_change_cat.php", 
									source : "php/script/admin_info_cat.php",
									success_load_clbk : tab2_p2_success_load_clbk,
									error_load_clbk   : tab2_p2_error_load_clbk,
									fail_load_clbk    : tab2_p2_fail_load_clbk,
									success_clbk : function(data) { 
                  			   			var success = new generator.Message({ type : 'success', title : data.success.title, 
      				                        message : data.success.msg, 
      				                        modal : true,
      				                        dismissible : true
      				                    });
                         	    		success.init();
                         	    		tab2_p2_form.empty();
                         	    		tab2_p.showPrevious();
                         	    		// Ici, relancer la pagination
							        },
									submits : [{ target : 'php/script/admin_change_cat.php', 
									             value  : generator.icon('tick')+' Modifier la catégorie' 
									           },
									           { target : 'php/script/admin_del_cat.php', 
									             value  : generator.icon('cross')+' Supprimer la catégorie' 
									           }
									          ]
								});   

					// Formulaire d'ajout TTbox
					var tab2_p2_form_new = new generator.Form(
						        { 	elements :
										[[{ item  : new generator.Title({ text: "Ajout d'une catégorie" }), name : 'title', width : 4 }],
										 [{ label : 'Nom catégorie', item : new generator.TextInput({ min_size : 3, check_onkey : true, show_validation : true, }), name : 'name' }],
										 [{ label : 'Description catégorie', item : new generator.TextInput({ min_size : 0 }), name : 'desc' }],
										 []
										],
									design : "table",
									target : 'php/script/admin_add_cat.php',
									success_clbk : function(data) { 
                  			   			var success = new generator.Message({ type : 'success', title : data.success.title, 
      				                        message : data.success.msg, 
      				                        modal : true,
      				                        dismissible : true
      				                    });
                         	    		success.init();
                         	    		tab2_p2_form_new.empty();
                         	    		tab2_p2_box.hide();
			                        },
									submits : [{ target : 'php/script/admin_add_cat.php', 
									             value  : generator.icon('tick')+' Ajouter la catégorie' 
									           }]
								});

					tab2_p2_box = new generator.TTBox( { elements : [tab2_p2_form_new], dismiss_on_close : false });
			        tab2_p2_box.init();

					var tab2_p2 = { elements : [ tab2_p2_form ] };   

					var tab2_p = new generator.Panel({ panels : [ tab2_p1, tab2_p2 ] });                                                             // -- Panneaux du second onglet

					var tab2 = { title    : generator.icon('list')+' Catégories',
				   			     elements : [ tab2_p ] };

				// Troisième onglet
				   	var tab3 = { title : generator.icon('edit')+' Sujets & messages' };

				// Construction des onglets
					var tab = new generator.Tab({ render_to : $('#admin-panel'), tabs : [ tab1, tab2, tab3 ] });
					tab.init();

			});

		-->
		</script>