
	<?php 
        if(strpos($atts['src'],'http') === false)
            $atts['src'] = home_url().'/'.$atts['src'];
    ?>
    <div style="<?= $atts['style'] ?>">
		<img src="<?= $atts['src'] ?>" style="max-width:600px; width:100%;" alt="Not Found">
	</div>