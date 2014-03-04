<div class="space"></div>
<div class="container">
	<div class="col-md-8 col-md-offset-2">

		<?php
		$list='';

		foreach($leaderboard as $row){
				$list.="<tr>";
				$list.="<td>".$row['rank']."</td>";
				$list.="<td>".$row['fb_name']."</td>";
				$list.="<td>".$row['level']."</td>";
				$list.="<td>".htmlspecialchars($row['college'])."</td>";
				$list.="</tr>";
		}

		?>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>Rank #</th>
					<th>Username</th>
					<th>Level</th>
					<th>College</th>
				</tr>
			</thead>
			<tbody>
				<?=$list?>
			</tbody>
		</table>
	</div>
</div>
