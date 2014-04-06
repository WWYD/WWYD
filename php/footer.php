		<footer>
			<br/>
			<hr/>
			<span class="copyright">&copy; WhatWouldYouDo? All rights reserved</span>
		</footer>
		</section>

		<SCRIPT TYPE="text/javascript">
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
			$(".inscription").on("click", function(e) {

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
						target : "form - new.php", 
						success_clbk : function(data) {
								var error = new generator.Message({ type : 'success', title : data.success.title, 
			          				                                message : data.success.msg, 
			          				                                modal : true, dismissible : true, 
			          				                                disable : box.window });
								box.hide();
								error.init();
						}, /*error_clbk : error_clbk, fail_clbk : fail_clbk*/ } )
				});

				box.init();
				box.show();
			});

			// Pop-up connexion
			$(".connection").on("click", function(e) {
				box = new generator.TTBox( { width: 210, elements : 
					new generator.Form( { elements : 
						[{ label : "Login", item : new generator.TextInput({ placeholder : "Votre nom d'utilisateur"}), name : "login"},
                         { label : "Mot de passe", item : new generator.PasswordInput({ placeholder : "Votre mot de passe"}), name : "password"}],
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

                           }, error_clbk : error_clbk, fail_clbk : fail_clbk } )
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

			// Tests
			
/*
			var div_test = new generator.Div({ title : "Bonjour je suis un titre de test",
											   html  : $('<p><img src="https://www.google.fr/images/srpr/logo11w.png" ></p>'),
											   creation_clbk : function() { alert("Test terminé !"); }
											});
			div_test.setRenderTo($(".content"));
			div_test.init();*/

		});
		</SCRIPT>
		
	</body>
</html>