<div class="space"></div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<p>Shows log for the selected user.</p>

			<a href="<?=base_url()?>nimda/users" class="btn btn-info"><i class="glyphicon glyphicon-chevron-left"></i> Back to users</a>

			<br>

			<?php if($user_log){ 
				//Fix for error when user does not have any answers yet.
				?>
			<h3>Username: <span class="text-muted"><?=$user_log[0]['fb_name'];?></span></h3>
			<?php }?>

			<br><br>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Level</th>
						<th>Answer</th>
						<th>Timestamp</th>
						<th>IP</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=0;
					if($user_log){
						foreach($user_log as $row){
							$i++;
							echo "<tr>";
								echo "<td>$i</td>";
								echo "<td>".$row['level']."</td>";
								echo "<td>".htmlspecialchars($row['answer'])."</td>";
								echo "<td>".$row['timestamp']."</td>";
								echo "<td>".$row['ip']."</td>";
							echo "</tr>";
						}
					}
					else{
						echo "<tr>";
							echo '<td colspan="5">The user didn\'t try any answers yet.</td>';
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>