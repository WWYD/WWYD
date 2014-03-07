		<footer>
			<br/>
			<hr/>
			<span class="copyright">&copy; WhatWouldYouDo? All rights reserved</span>
		</footer>
		</section>
		
		<SCRIPT TYPE="text/javascript">
		$(document).ready(function () {
			// Pop-up connexion / inscription
			$("#connection").on("click", function(e) {
				box = new html.TTBox($("body"), 
					{ item : new html.Form(null, [{ label : "Login", item : new html.TextInput("Votre nom d'utilisateur"), name : "login"},
		                                         { label : "Mot de passe", item : new html.PasswordInput("Votre mot de passe"), name : "password"}],
			                                     "connexion.php", "Connexion", 
			                                     function(data) { 
			                                     	$("#ttbox_frame div").slideUp();
			                                     	var success = new html.Message($("#ttbox_frame"), "ok", "Connexion","Vous êtes maintenant connecté");
													success.init();

													window.setTimeout( function() { window.location.reload(); }, 2000 );
			                                       }, 
			                                     function() { console.log('Erreur connexion'); 

			                                     	$("#ttbox_frame div").slideUp();
			                                    	var success = new html.Message($("#ttbox_frame"), "error", "Connexion","Mot de passe et/ou login incorrect");
													success.init();

			                                     }, 
			                                     function() { 
			                                     	$("#ttbox_frame div").slideUp();
			                                     	var success = new html.Message($("#ttbox_frame"), "error", "Connexion","Impossible de joindre le site, veuillez réessayer plus tard");
													success.init();
												})
				    });

		        box.init();
				box.show();
			});

			return false;
		});
		</SCRIPT>
		
	</body>
</html>