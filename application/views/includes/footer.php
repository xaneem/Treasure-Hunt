	<script src="<?=base_url();?>assets/js/bootstrap.min.js"></script>

	<?php 
	//backstrech is used on the background image.
	//required only on the home page when not logged in.
	if(uri_string()=='' && $this->session->userdata('is_logged_in')!=TRUE) {?>
	<script src="<?=base_url();?>assets/js/jquery.backstretch.min.js"></script>
	<script>
		$("#home-bg").backstretch('<?=base_url();?>assets/img/background.jpg');
	</script>
	<?php } ?>

	<?php 
	//whos.amung.us tracking code.
	//no tracking for pages in /nimda and /login
	if(! (preg_match('/nimda.*/', uri_string()) || preg_match('/login.*/', uri_string()) )) { ?>
		<div style="display:none">
			<script id="_wauiyg">var _wau = _wau || []; _wau.push(["classic", "nmbxmgw90rmo", "iyg"]);
			(function() {var s=document.createElement("script"); s.async=true;
			s.src="http://widgets.amung.us/classic.js";
			document.getElementsByTagName("head")[0].appendChild(s);
			})();</script>
		</div>
	<?php } ?>

</body>
</html>