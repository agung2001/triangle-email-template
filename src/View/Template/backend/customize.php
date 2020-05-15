<?php

!defined( 'WPINC ' ) or die;

/**
 * Single Template for EmailTemplate CPT
 *
 * @package    Triangle
 * @subpackage Triangle/EmailTemplate
 */

/** Load Helper and Service */
$helper = new Triangle\Helper();
$service = new Triangle\Wordpress\Service();
$user = $this->Service->User->get_current_user();
if(!isset($user->ID) || !$user->ID) $service->Page->wp_redirect('/');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= ($post->post_title) ? $post->post_title : 'Template' ?></title>
</head>
<body>

<?php foreach($this->sections as $path => $options): ?>
    <?= $this->loadContent($path) ?>
<?php endforeach; ?>

</body>
</html>