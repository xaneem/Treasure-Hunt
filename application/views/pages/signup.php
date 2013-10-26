<div class="space"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3>Please fill in your details.</h3>
			<p>We'll be using this to contact you if you win prizes!</p>
			<br>
			<?php echo form_open('signup',array('class'=>'form-horizontal','role'=>'form')); ?>
			<div class="form-group">
				<label for="college" class="col-lg-2 control-label">College</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="college" name="college" placeholder="Your college">
				</div>
			</div>
			<div class="form-group">
				<label for="mobile" class="col-lg-2 control-label">Mobile</label>
				<div class="col-lg-10">
					<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Your mobile number">
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-lg-2 control-label">E-mail</label>
				<div class="col-lg-10">
					<input type="email" class="form-control" id="email" name="email" placeholder="Your personal e-mail address.">
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-10">
					<button type="submit" id="signup_submit" class="btn btn-lg btn-info">Start <i class="glyphicon glyphicon-chevron-right"></i></button>
				</div>
			</div>
			<?php echo form_hidden('signup','true'); ?>
			<?php echo form_close(); ?>
			<div class="alert alert-danger fade in" style="display:none;" id="error_signup">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<strong>Please fill the fields completely.</strong> College, Mobile and E-mail should be valid.
			</div>

			
		</div>
	</div>
</div>
<script>
$(document).ready(function() {

	$('#signup_submit').click(function(e){
		if($('#college').val().length <3 || $('#mobile').val().length < 9 || $('#email').val().length < 4){
			
			$('#error_signup').show();
			e.preventDefault();
				return false;
		}
	});
});
</script>