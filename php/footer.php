		<footer>
			<br/>
			<hr/>
			<span class="copyright">&copy; WhatWouldYouDo? All rights reserved</span>
		</footer>
		</section>

		<SCRIPT TYPE="text/javascript">
		$(document).ready(function () {
			// Pop-up connexion / inscription
			$(".connection").on("click", function(e) {
				$("#ttbox_global").remove();
				box = new html.TTBox($("body"), 
					{ item : new html.Form(null, [{ label : "Login", item : new html.TextInput("Votre nom d'utilisateur"), name : "login"},
		                                         { label : "Mot de passe", item : new html.PasswordInput("Votre mot de passe"), name : "password"}],
			                                     "connexion.php", "Connexion", 
			                                     function(data) { 

			                              			var success = new generator.Message({ type : 'success', title : 'Connexion', 
			                              				                                  message : 'Vous êtes maintenant connecté', 
			                              				                                  modal : true, disable : $("#ttbox_global") });

			                                     	success.init();

													window.setTimeout( function() { window.location.reload(); }, 2000 );
			                                     }, 
			                                     function() {

			                                    	var error = new generator.Message({ type : 'error', title : 'Connexion', 
			                              				                                message : 'Mot de passe et/ou login incorrect', 
			                              				                                modal : true, dismissible : true, 
			                              				                                disable : $("#ttbox_global") });
													error.init();

			                                     }, 
			                                     function() {  console.log("error ajax"); })
				    });

		        box.init();
				box.show();

				return false;
			});

			// Pop-up déconnexion
			$(".deconnection").on("click", function(e) {
				var error = new generator.Message({ type : 'success', title : 'Déconnexion', 
      				                                message : 'Merci de votre visite, à bientôt !', 
      				                                modal : true, dismissible : false,
      				                            	creation_callback : function() {
      				                            		window.setTimeout( function() { 
      				                            			window.location.href = 'deconnexion.php'; 
      				                            		}, 2000 );
      				                            	}});
				error.init();

				return false;
			});
		});
		</SCRIPT>
		
	</body>
</html>