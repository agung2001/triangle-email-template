<?php

    ob_start();
        require $this->get_module('triangle',"themes/$theme/header.php");
        require $this->get_module('triangle',"themes/$theme/content.php");
        require $this->get_module('triangle',"themes/$theme/footer.php");
    echo do_shortcode(ob_get_clean());

?>