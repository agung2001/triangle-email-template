<form method="POST">
    <input type="hidden" name="field_menu_slug" value="<?= $menuSlug ?>">
    <div id="form-result" class="form-result-<?= $result ?>">Options saved successfully!</div>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <h3>SMTP</h3>
                </th>
            </tr>

            <!-- SMTP -->
            <tr>
                <th scope="row"><label for="field_option_smtp">Enable Option</label></th>
                <td>
                    <div class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_smtp" <?= ($options['triangle_smtp']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> Turn off/on </p>
                    </div>
                </td>
            </tr>
            <!--Host-->
            <tr>
                <th scope="row"><label for="field_option_smtp_host">Host</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_option_smtp_host" value="<?= ($options['triangle_smtp_host']) ? $options['triangle_smtp_host'] : '' ?>" placeholder="mail.host.com">
                    </div>
                </td>
            </tr>
            <!--Username-->
            <tr>
                <th scope="row"><label for="field_option_smtp_username">Username</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_option_smtp_username" value="<?= ($options['triangle_smtp_username']) ? $options['triangle_smtp_username'] : '' ?>" placeholder="Username">
                    </div>
                </td>
            </tr>
            <!--Password-->
            <tr>
                <th scope="row"><label for="field_option_smtp_password">Password</label></th>
                <td>
                    <div class="field-container">
                        <input type="text" name="field_option_smtp_password" value="<?= ($options['triangle_smtp_password']) ? $options['triangle_smtp_password'] : '' ?>" placeholder="Password">
                    </div>
                </td>
            </tr>
            <!--Auth-->
            <tr>
                <th scope="row"><label for="field_option_smtp_auth">Auth</label></th>
                <td>
                    <div class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_auth" <?= ($options['triangle_smtp_auth']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> Turn off/on </p>
                    </div>
                </td>
            </tr>
            <!--TLS-->
            <tr>
                <th scope="row"><label for="field_option_smtp_tls">Auto TLS</label></th>
                <td>
                    <div class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_tls" <?= ($options['triangle_smtp_tls']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> By default TLS encryption is automatically used if the server supports it, which is recommended. In some cases, due to server misconfigurations, this can cause issues and may need to be disabled.  </p>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <h3>User Interface (UI)</h3>
                </th>
            </tr>

            <!-- Animation -->
            <tr>
                <th scope="row"><label for="field_option_animation">Animation</label></th>
                <td>
                    <div id="field-template-container" class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_animation" <?= ($options['triangle_animation']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> Turn off/on </p>
                    </div>
                </td>
            </tr>

            <!-- Submit -->
            <tr>
                <th scope="row">&nbsp;</th>
                <td>
                    <div class="field-container">
                        <button typpe="submit" class="btn-submit">SAVE</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</form>