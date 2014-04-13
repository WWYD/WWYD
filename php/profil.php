		<?php
			// On affiche la page d'un utilisateur
			if(isset($_GET['data'][0])) {
				$id = $_GET['data'][0];
			} 
			// Sinon notre page
			else if(is_co()) {
				$id = $_SESSION['user']['id'];
			}
			// Sinon 
			else {
				// Erreur redirection
				header("Location: ?/");
			}

			$bdd = BBD_connect();
		?>

		<!-- Phrase d'accroche du site -->
		<div id="indexTile">
			<section id="user-info">
				<p><b><i id="">Page utilisateur</i></b></p>
				<p>Consultation de compte utilisateur</p>
			</section>
		</div>
		
		<!-- Section du contenu -->
		<section id="user-content">
			<span id="error_load" class="error" style="margin-top: 15px; display: none;">
				<h2>Impossible de charger l'utilisateur</h2>
				Impossible de charger l'utilisateur selectionné : soit celui-ci n'existe pas, soit le site rencontre un problème.
			</span>
		</section>


		<script type="text/javascript">
		<!-- 
			$(document).ready(function () {

			// id user à afficher
			var id = <?php echo $id; ?>;

			$.ajax({ type     : 'POST',
		             url      : 'php/script/user_get_info.php',
		             dataType : "json",
		             data     : { data : JSON.stringify({ id : id })} })
		           .done(function(data) {

		           		console.log(data);

		           	   if(data.success) {
		           	   	// Login
		           	      var login = new generator.Title({ text : data.success.login, renderTo : $("#user-content")});
		           	      login.setRenderTo($("#user-content"));
		           	      login.init();

		           	    // Si bannis
		           	      if(data.success.banned == "1") {
		           	     	 var ban = $('<span class="badge">Bannis</span> ');
		           	     	 $("#user-content").append(ban);
		           	      }

		           	    // Si admin
		           	      if(data.success.admin == "1") {
		           	     	 var admin = $('<span style="background-color: darkred;" class="badge">Admin</span> ');
		           	     	 $("#user-content").append(admin);
		           	      }

		           	    // Si premium
		           	      if(data.success.premium == "1") {
		           	     	 var premium = $('<span style="background-color: darkred;" class="badge badge-premium">Premium</span> ');
		           	     	 $("#user-content").append(premium);
		           	      }
		           	     
		           	      $("#user-content").append("<br /><br />");

		           	      var info = new generator.Div({ title : "Informations compte", html : 
		           	      	'<b class="content-bordered-item">Nombre de points :</b> '+data.success.nb_point+'<b class="content-bordered-item">Rang :</b> '+data.success.rank+
		           	        '<b class="content-bordered-item">Nombe de messages :</b> '+data.success.nb_post
		           	      })

		           	      info.setRenderTo($("#user-content"));
		           	      info.init();

		           	      var info = new generator.Div({ title : "Informations utilisateur", html : 
		           	      	'<b class="content-bordered-item">Nom :</b> '+data.success.first_name+'<b class="content-bordered-item">Prénom :</b> '+data.success.last_name
		           	      })

		           	      info.setRenderTo($("#user-content"));
		           	      info.init();


		           	    // Informations
		           	   } else if(data.error) {
		           	   	  console.log("Erreur PHP");
		           		  $("#error_load").html("<h2>"+data.error.title+"</h2>"+data.error.msg).slideDown();
		           	   } else {
			           	  console.log("Erreur structure réponse");
		           		  $("#error_load").slideDown();
		           	   }
		           })
		           .fail(function(jqXHR) {
		           	   console.log("Erreur Ajax");

		           		console.log({ data : { id : id } });
		           		$("#error_load").slideDown();
		           });
		    });

		-->
		</script>
		
<?php

?>