<?php
    if($_POST){
        update_option('triangle_stage', $_POST['triangle_stage']);
    }

    $stage = get_option('triangle_stage');
?>

<div class="wrap">
    <div class="box">
        <h2>
            <i class="fa fa-cog"></i>
            Setting
        </h2><hr>

        <form method="POST" style="padding:0px;">
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label>Stage</label>
                        </th>
                        <td>
                            <select name="triangle_stage" class="fullwidth">
                                <option value="dev" <?php if('dev'==$stage) echo 'selected'; ?>>Development</option>
                                <option value="live" <?php if('live'==$stage) echo 'selected'; ?>>Live</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">&nbsp;</th>
                        <td>
                            <input name="save" class="button-primary" value="Save changes" type="submit">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>