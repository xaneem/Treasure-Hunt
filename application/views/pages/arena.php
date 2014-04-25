<div class="space"></div>
<div class="container well" id="arena">

	<?php 
	//Used for Chapter 2.
	//When level is less than 21, show a Bootstrap alert, and ask user
	//if he/she wants to jump to Chapter 2.

	if(0 && $level->level<21){ 
	//Remove the 0 && to activate the level jump feature, to jump to a new chapter
	?>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="alert alert-block alert-success fade in">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h3>The race is back on. <strong>Chapter 2</strong> has started!</h3>
				<p>
					Its not mandatory to finish Chapter 1 before you start Chapter 2. Just click Jump to Chapter 2 to get yourself to <strong>Level 21</strong> and get a head start.
				</p>
				<br>
				<a class="btn btn-success" href="/profile/nextchapter">Jump to Chapter 2 <i class="glyphicon glyphicon-chevron-right"></i></a> <button class="btn btn-default" data-dismiss="alert" aria-hidden="true"><i class="glyphicon-ban-circle glyphicon"></i> Let me finish Chapter 1</button>
			</div>
		</div>
	</div>
	<?php } 
	
	?>

	<div class="row">
		<div class="col-md-8 col-md-offset-2 text-center" id="level">
			<h3><?=$level->content?></h3>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4">
			<?php echo form_open('answer',array('role'=>'form')); ?>
			<div class="input-group input-group-lg">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
				<?php echo form_input(array('name'=>'answer','id'=>'answer','class'=>'form-control','placeholder'=>$level->placeholder)); ?>
				<span class="input-group-btn">
				<button class="btn btn-danger" type="submit"><i class="glyphicon glyphicon-chevron-right"></i></button>
				</span>
			</div>
			<?php echo form_close(); ?>
			<?php echo'<!--'.$level->html_comment.'-->'; ?>
		</div>
	</div>
	<?php 
	//if level difficulty is 3 (hard), the user is prompted about goodies
	//for the first person who solves it.

	if($level->difficulty ==3){ ?>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<h3><span class="label label-warning"><i class="glyphicon glyphicon-star"></i> The first player to answer receives goodies :)</span></h3>
		</div>
	</div>
	<?php } ?>
</div>
