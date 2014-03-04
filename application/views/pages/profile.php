<div class="space"></div>
<div class="container">
	<div class="jumbotron">
		<h1>Rank <span class="text-muted"><?=$user['rank']?></span></h1>
		<h2>You're on Level <?=$user['level']?>.</h2>
		<br><br>
		<table class="table">
			<tbody>
				<tr>
					<td>Username</td>
					<td class="text-info"><?=$user['fb_name']?></td>
				</tr>
				<tr>
					<td>College</td>
					<td class="text-info"><?=htmlspecialchars($user['college'])?></td>
				</tr>
				<tr>
					<td>E-mail</td>
					<td class="text-info"><?=htmlspecialchars($user['email'])?></td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td class="text-info"><?=htmlspecialchars($user['mobile'])?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>