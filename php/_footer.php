	
		<!-- Footer de la page -->
		<section>
			<footer>
				<br/><hr/>
				<span class="copyright">&copy; WhatWouldYouDo? All rights reserved</span>
			</footer>
		</section>

		<!-- Invite de connexion/inscription/deconnexion -->
		<script TYPE="text/javascript">
			$(document).ready(function () {

				var error_clbk = function(data) {
						var error = new generator.Message({ type : 'error', title : data.error.title, 
	          				                                message : data.error.msg, 
	          				                                modal : true, dismissible : true, 
	          				                                disable : box.window });
						error.init();
				};

				var fail_clbk = function(data) {
						var error = new generator.Message({ type : 'error', title : "Erreur", 
	          				                                message : "Erreur lors du traitement du formulaire", 
	          				                                modal : true, dismissible : true, 
	          				                                disable : box.window });
						error.init();
				};


				// Pop-up inscription
				$(".registration").on("click", function(e) {

					var login = new generator.TextInput({ placeholder : "Nom du compte", min_size : 3, check_onkey : true, show_validation : true });
					var mail = new generator.EmailInput({ placeholder : "Adresse mail", check_onkey : true, show_validation : true });

					var pass = new generator.PasswordInput({ placeholder : 'Mot de passe', min_size : 3, check_onkey : true, show_validation : true, check_clbk : function() { return (pass_check.getValue() == pass.getValue()); }});
					var pass_check = new generator.PasswordInput({ placeholder : 'Vérification mot de passe', min_size : 3, check_onkey : true, check_clbk : function() { pass.check(); }});

					var firstname = new generator.TextInput({ placeholder : 'Prénom (Facultatif)'});
					var lastname = new generator.TextInput({ placeholder : 'Nom (Facultatif)'});


					box = new generator.TTBox( { width: 340, elements : 
						new generator.Form( { elements :
							[[{ item  : new generator.Title({ text: "Formulaire d'inscription" }), width : 4 }],
							 [{ label : 'Login', item : login, name : 'login' }],
							 [{ label : 'Adresse mail', item : mail, name : 'mail'}],
							 [],
							 [{ label : 'Mot de passe', item : pass, name : 'password' }],
							 [{ label : 'Vérification', item : pass_check }],
							 [],
							 [{ label : 'Prénom', item : firstname, name : 'firstname'}],
							 [{ label : 'Nom', item : lastname, name : 'lastname'}]
							], 
							design : "table", 
							submit_value : "Enregistrer le compte",
							target : "php/script/user_registration.php", 
							success_clbk : function(data) {
									var error = new generator.Message({ type : 'success', title : data.success.title, 
				          				                                message : data.success.msg, 
				          				                                modal : true, dismissible : true, 
				          				                                disable : box.window });
									box.hide();
									error.init();
							} } )
					});

					box.init();
					box.show();
				});

				// Pop-up connexion
				$(".connection, .connection-show").on("click", function(e) {
					box = new generator.TTBox( { width: 210, elements : 
						new generator.Form( { elements : 
							[{ label : "Login", item : new generator.TextInput({ placeholder : "Votre nom d'utilisateur"}), name : "login"},
	                         { label : "Mot de passe", item : new generator.PasswordInput({ placeholder : "Votre mot de passe"}), name : "password"}],
	                           target : "php/script/user_connection.php", submit_value : "Connexion", success_clbk :
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

	                           } } )
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
	      				                            			window.location.href = 'php/script/user_deconnection.php'; 
	      				                            		}, 1000 );
	      				                            	}});
					error.init();

					return false;
				});
			});
		</script>
		
	</body>
</html>