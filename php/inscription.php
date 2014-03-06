<?php 
	include("header.php");
?>
		<div style="width: 100%;  height: 150px;background-color: #DEDEDE;">
			<div class="content" style="padding: 30px; margin-right: 390px;">
				<p style="font-size: 22pt; padding-left: 100px;"><i>Créez maintenant votre compte !</i></p>
			</div>
		</div>

		<section>
			<section style="width: 66.6%; float: left;">
				<div class="content">
					<div class="content-group">
					
					<div class="content-elem">
						<div class="content-bordered respond-zone" style="margin-top: 34px;">
							<br/>
							
							<table style="border-collapse : separate">
								<form action="form.php" method="POST">
									<tr><td>Nom de compte* : </td><td style="padding: 3px"><input type="text" name="login" id="login" class="form-connection" size="40"/></td><td><span id="login_check"></span></td></tr>
									<tr><td>Mail* : </td><td style="padding: 3px"><input type="text" name="mail" id="mail" class="form-connection" size="40"/></td><td><span id="mail_check"></span></td></tr>
									<tr><td colspan="2"><br/></td></tr>
									<tr><td>Mot de passe* : </td><td style="padding: 3px"><input type="password" name="pass" id="pass" class="form-connection" size="40"/></td></tr>
									<tr><td>Retapez le mot de passe* :	</td><td style="padding: 3px"><input type="password" name="pass_check" id="pass_check" class="form-connection" size="40"/></td><td><span id="password_check"></span></td></tr>
									<tr><td colspan="2"><br/></td></tr>
									<tr><td>Prénom : </td><td style="padding: 3px"><input type="text" name="firstname" class="form-connection" size="40"></td></tr>
									<tr><td>Nom : </td><td style="padding: 3px"><input type="text" name="lastname" class="form-connection" size="40"></td></tr>
									<tr><td colspan="2"><span style="float: right; font-size: 9pt"><i>Les champs marqués d'un * sont obligatoires</i></span></td></tr>
									<tr><td colspan="2"><br/></td></tr>
									<tr><td><p style="height: 20px; padding-right: 0px;"><button type="submit" class="btn" style="float: right">Valider l'inscription <span class="respond"></span></button></p></td></tr>
								</form>
							</table>
							
							<script type="text/javascript">

								$(document).ready(function() {

									/* Test du login */
									var login_test = function() {
										var login = $("#login").val();
										var div = $("#login_check");
										var r = false;
										$.ajaxSetup({async: false});
										div.css("color", "red").css("font-weight", "700");
										if(login && login != "") {
											if(login.length >= 3) {
												$.ajax({ type: "POST",
														 url: "test_login.php",
														 data: { login: login }})
													  .done(function(data) {
														if(data == 0) {
															div.css("color", "green");
															div.html("Login non utilisé <span class='ok'></span>").fadeIn(200);
															r = true;
														} else{
															div.html("Login utilisé <span class='false'></span>").fadeIn(200);
														}
													  })
													  .fail(function() {
														div.html("Erreur lors du test du login <span class='false'></span>");
													  });
											} else
												div.html("Login trop court <span class='false'></span>").fadeIn(200);
										} else
											div.html("").fadeOut(200);

										$.ajaxSetup({async: true});
										return r;
									}

									/* Test du mail */
									var mail_test = function() {
										var mail = $("#mail").val();
										var div = $("#mail_check");
										div.css("color", "red").css("font-weight", "700");
										if(mail && mail != "") {
											var re = /\S+@\S+\.\S+/;
											if(re.test(mail)) {
												div.css("color", "green");
												div.html("Mail correct <span class='ok'></span>").fadeIn(200);
												return true;
											} else
												div.html("Mail incorrect <span class='false'></span>").fadeIn(200);
										} else
											div.html("").fadeOut(200);

										return false;
									}

									/* Test du password */
									var password_test = function() {
										var pass1 = $("#pass").val();
										var	pass2 = $("#pass_check").val();
										var div = $("#password_check");
										div.css("color", "red").css("font-weight", "700");
										if(pass1 && pass1 != "" && pass2 && pass2 != "") {
											if(pass1 == pass2) {
												div.css("color", "green");
												div.html("Mots de passe identiques <span class='ok'></span>").fadeIn(200);
												return true;
											} else
												div.html("Mots de passe différents <span class='false'></span>").fadeIn(200);
										} else
											div.html("").fadeOut(200);
										
										return false;
									}

									$("#login").keyup(login_test);
									$("#mail").keyup(mail_test);
									$("#pass").keyup(password_test);
									$("#pass_check").keyup(password_test);

									/* Test général */
									$("#send").click(function() {
										if(login_test() && mail_test() && password_test()){
											$("#send_check").html("");
											return true;
										} else
											$("#send_check").html("Impossible de continuer, des champs sont vides/incorrects");
										return false;
									});

								});

							</script>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<section style="width: 30.3%; float: left; margin-top: 30px;">
			<div class="categories">
				<h3>Catégories</h3>
				<table class="table table-striped table-hover">
					<tr><td>Général</td></tr>
					<tr><td>Humour</td></tr>
					<tr><td>Politique</td></tr>
					<tr><td>Cinéma</td></tr>
					<tr><td>Littérature</td></tr>
					<tr><td>Jeu vidéo</td></tr>
					<tr><td>Alimentaire</td></tr>
					<tr><td>Sport</td></tr>
					<tr><td>Sexe</td></tr>
					
				</table>
			</div>
		</section>
<?php
	include("footer.php");
?>

