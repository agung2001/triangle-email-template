<link rel="stylesheet" href="<?= $this->get_res('css/bootstrap.min.css'); ?>">

<div class="row page-loading" style="margin-top:50px;">
	<img class="wp-image-84 alignnone size-full" style="display: block; margin-left: auto; margin-right: auto;" src="<?= wp_upload_dir()['baseurl'] ?>/2017/07/loading.gif" alt="" width="228" height="228">
	<h1 style="text-align: center;">Please wait, we're sending email to the customer!</h1>
</div>
<div class="page-loading-complete" style="margin-top:50px;">
	<h1 style="text-align: center;">Email sent!</h1>
</div>

<script>
	jQuery(function($){
		$('.page-loading-complete').hide();

		var delayMillis = 5000; 
		setTimeout(function() {
		  $('.page-loading').hide();
		  $('.page-loading-complete').show();
		}, delayMillis);
	});
</script>