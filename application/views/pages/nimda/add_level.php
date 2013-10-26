<div class="space"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h3>Add/Change details of level.</h3>
			
			<?php echo validation_errors('<p class="label label-danger">', '</p>'); ?>

			<?php
			if(isset($upload_error)){
				echo '<div style="color:#BF0000">'.$upload_error.'</div>';
			}
			?>
			<br><br>
			<?php echo form_open_multipart('nimda/levels/add_level',array('role'=>'form'));?>
				<div class="form-group">
				  <label>Level Number. If existing level is entered, it will be overwritten.</label>
				  <input type="text" class="form-control" name="level" value="<?php echo set_value('level'); ?>">
				</div>
				<div class="form-group">
				  <label>Title (Shown on top of window)</label>
				  <input type="text" class="form-control" name="title" value="<?php echo set_value('title'); ?>">
				</div>
				<div class="form-group">
				  <label>Difficulty</label>
				  <select class="form-control" name="difficulty">
				  	<option value="1">Normal</option>
				  	<option value="3">Hard (wins goodies)</option>
				  </select>
				</div>
				<div class="form-group">
				  <label>Level Content (may contain HTML tags if required)</label>
				  <textarea class="form-control" rows="4" name="content_text"></textarea>
				</div>
				<div class="form-group">
				  <label>Level Image (Optional, upload as jpg. Maximum 1000x1000)</label>
				  <input type="file" name="content_image">
				</div>
				<div class="form-group">
				  <label>Background Color (Optional, use hex format eg. #aa22ff, not yet implemented) </label>
				  <input type="text" class="form-control" name="title" placeholder="#aa22ff" disabled="disabled">
				</div>
				<div class="form-group">
				  <label>Placeholder answer (Optional, shows up in answer text box)</label>
				  <input type="text" class="form-control" name="placeholder" placeholder="Placeholder" value="<?php echo set_value('placeholder'); ?>">
				</div>
				<div class="form-group">
				  <label>Cookie Clue (Optional, not yet implemented)</label>
				  <input type="text" class="form-control" name="cookie" disabled="disabled">
				</div>
				<div class="form-group">
				  <label>Javascript Clue (Optional, not yet implemented)</label>
				  <input type="text" class="form-control" name="javascript" disabled="disabled">
				</div>
				<div class="form-group">
				  <label>HTML Comment (Optional, shows in source code)</label>
				  <input type="text" class="form-control" name="html_comment" value="<?php echo set_value('html_comment'); ?>">
				</div>
				<div class="form-group">
				  <label>Level Finish Image (Optional, upload as jpg. Maximum 1000x1000)</label>
				  <input type="file" name="finish_image">
				</div>
				<div class="form-group">
				  <label>Answer (lowercase, no special characters)</label>
				  <input type="text" class="form-control" name="answer" value="<?php echo set_value('answer'); ?>">
				</div>

				<h4><span class="label label-info">Levels will not be activated instantly. You can preview, and activate levels in Manage Levels panel.</span></h4>
			    <button type="submit" class="btn btn-lg btn-success">Add Level <i class="glyphicon glyphicon-chevron-right"></i></button>

				<?php echo form_hidden('add_level','true'); ?>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>