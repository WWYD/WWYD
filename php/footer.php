		<footer>
			<br/>
			<hr/>
			<span class="copyright">&copy; WhatWouldYouDo? All rights reserved</span>
		</footer>
		</section>

		<SCRIPT TYPE="text/javascript">
		$(document).ready(function () {

			// Test en affichant de l'html du DOM dans une TTBox
			/*
			$('.inscription').on("click", function(e) {
				box_ = new generator.TTBox( { html : $('.daily') } );
				box_.init();
				box_.show();
			})*/
			/*$('.inscription').on("click", function(e) {
				box_ = new generator.TTBox( { elements : new generator.Form( { elements : 
						[[{ item  : new generator.Title({ text: "Formulaire d'inscription" }), width : 4 }],
						 [{ label : "Nom", item : new html.TextInput(), name : "nom" }, { label : "Prénom", item : new html.TextInput(), name : "prenom" }],
						 [{ label : "Ville", item : new html.TextInput(), name : "ville" }]
						 ], design : "table" } ) 
					} );
				box_.init();
				box_.show();
			});*/


			// Pop-up connexion / inscription
			$(".inscription").on("click", function(e) {
				box = new generator.TTBox( { width: 320, elements : 
					new generator.Form( { elements :
						[[{ item  : new generator.Title({ text: "Formulaire d'inscription" }), width : 4 }],
						 [{ label : 'Login', item : new html.TextInput("Nom du compte"), name : 'login' }],
						 [{ label : 'Adresse mail', item : new html.TextInput("Adresse mail"), name : 'mail'}],
						 [],
						 [{ label : 'Mot de passe', item : new html.PasswordInput('Mot de passe'), name : 'password'}],
						 [{ label : 'Vérification', item : new html.PasswordInput('Vérification mot de passe') }],
						 [],
						 [{ label : 'Prénom', item : new html.TextInput('Prénom (Facultatif)'), name : 'firstname'}],
						 [{ label : 'Nom', item : new html.TextInput('Nom (Facultatif)'), name : 'name'}]
						], design : "table" } )
				});

				box.init();
				box.show();
			});


			$(".connection").on("click", function(e) {
				box = new generator.TTBox( { width: 180, elements : 
					new generator.Form( { elements : [{ label : "Login", item : new html.TextInput("Votre nom d'utilisateur"), name : "login"},
                                                       { label : "Mot de passe", item : new html.PasswordInput("Votre mot de passe"), name : "password"}],
	                                      target : "connexion.php", submit_value : "Connexion", success_clbk :
	                         			  function(data) { 

	                              			var success = new generator.Message({ type : 'success', title : data.success.title, 
	                              				                                  message : data.success.msg, 
	                              				                                  modal : true, disable : box.window,
	                              				                                  creation_clbk : function() {
																				  	  window.setTimeout( function() { 
																				  	  	window.location.reload(); 
																				  	  }, 1000 );
	                              				                                  }});
	                                     	success.init();

		                                  }, error_clbk :
		                                  function(data) {

		                                    	var error = new generator.Message({ type : 'error', title : data.error.title, 
		                              				                                message : data.error.msg, 
		                              				                                modal : true, dismissible : true, 
		                              				                                disable : box.window });
												error.init();

		                                  }, error_ajax_clbk :
		                                     function() {  console.log("error ajax"); } 
		                          } )
					} );
		        box.init();
				box.show();

				return false;
			});

			// Pop-up déconnexion
			$(".deconnection").on("click", function(e) {
				var error = new generator.Message({ type : 'success', title : 'Déconnexion', 
      				                                message : 'Merci de votre visite, à bientôt !', 
      				                                modal : true, dismissible : false,
      				                            	creation_clbk : function() {
      				                            		window.setTimeout( function() { 
      				                            			window.location.href = 'deconnexion.php'; 
      				                            		}, 1000 );
      				                            	}});
				error.init();

				return false;
			});
		});
		</SCRIPT>
		
	</body>
</html>