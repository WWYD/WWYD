			<div class="categories">
				<h3>Catégories</h3>
				<table class="table table-striped table-hover">
					<tr>
						<td>
							<a href="?/search.html/0">Toutes</a>
						</td>
					</tr>

					<?php
						$query = $bdd->query("SELECT category.name, category.id, COUNT( topic.id ) AS nb
										      FROM category
											  LEFT JOIN topic ON category_id = category.id
											  GROUP BY category.id");
						
						while($data = $query->fetch()){ ?>

						<tr>
							<td>
								<a style="width: 100%; float: left;" href="?/search.html/<?php echo $data['id']; ?>">
									<?php echo $data['name']; ?>
									<span class="badge" style="float: right"><?php echo $data['nb']; ?></span>
								</a>
							</td>
						</tr>
		
					<?php } ?>			
				</table>
			</div>