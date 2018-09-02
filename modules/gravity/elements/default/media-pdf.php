
	<?php 
        if(strpos($atts['src'],'http') === false)
            $atts['src'] = home_url().'/'.$atts['src'];

        if(strpos($atts['url'],'http') === false){
            $atts['url'] = home_url().'/'.$atts['url'];
        }
    ?>
    <div style="<?= $atts['style'] ?>">
        <a href="<?= $atts['url'] ?>">
    		<img src="<?= $atts['src'] ?>" style="<?= $atts['style'] ?>" alt="Not Found">
    	</a>
    </div>