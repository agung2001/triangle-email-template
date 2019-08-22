<?php 
	
	require $this->get_element($atts['template'].'/header.php');
	
		require $this->get_element($atts['template'].'/content.php');

	require $this->get_element($atts['template'].'/footer.php');

?>