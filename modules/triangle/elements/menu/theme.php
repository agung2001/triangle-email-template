<?php
    if($_POST && $_POST['form']=='select'){
        update_option('triangle_theme', $_POST['theme']);
    }

    $activeTheme = $this->get_active_theme();
?>

<div class="wrap">
    <div class="box">
        <!-- Theme Selection -->
        <h2>
            <i class="fa fa-fill-drip"></i>
            Select Theme
        </h2><hr>
        <form method="POST" style="padding:0px;">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label>Theme</label>
                        </th>
                        <td>
                            <select name="theme" class="fullwidth">
                                <?php $path = $this->get_module('triangle','themes'); ?>
                                <?php foreach(array_filter(glob("$path/*"), 'is_dir') as $dir): ?>
                                    <?php 
                                        $theme = explode('/',$dir); 
                                        $theme = $theme[count($theme)-1];
                                    ?>
                                    <option value="<?= $theme ?>" <?php if($theme==$activeTheme) echo 'selected'; ?>>
                                        <?= ucwords($theme) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">&nbsp;</th>
                        <td>
                            <input type="hidden" name="form" value="select">
                            <input name="save" class="button-primary" value="Save changes" type="submit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Theme Configuration -->
        <?php
            $theme = $this->get_module('triangle',"themes/$theme/theme.php");
            if(file_exists($theme)):
        ?>
            <h2>
                <i class="fa fa-fill-drip"></i>
                Configuration
            </h2><hr>
            <?php require $theme; ?>
        <?php endif; ?>
    </div>
</div>