<div class="space"></div>
<div class="container">
	<div class="jumbotron" style="min-height: 400px;">
		<h2>We just had a look at your answer. Seems like you're </h2>
		
		<?php
			if($result == true){
				echo '<h1><span class="text-success">CORRECT</span></h1>';
				echo '<br><img src="/levels/'.$image.'"/><br><br>';
				echo '<br><p><a class="btn btn-lg btn-success" href="'.base_url().'">Next Level <i class="glyphicon glyphicon-chevron-right"></i></a></p>';
				
			}else{
				echo '<h1><span class="text-danger">WRONG</span></h1>';
				echo '<br><p><a class="btn btn-lg btn-danger" href="'.base_url().'">Try Again <i class="glyphicon glyphicon-chevron-left"></i></a></p>';
			}
		?>
	</div>
</div>