<form method="POST" id="setting-form">
    <input type="hidden" name="field_menu_slug" value="<?= $menuSlug ?>">
    <div id="form-result" class="form-result-<?= $result ?>">Options saved successfully!</div>
    <div id="form-message"></div>
    <table class="form-table" role="presentation">
        <tbody>
            <tr>
                <th scope="row">
                    <h3>Animation</h3>
                </th>
            </tr>

            <!-- Animation -->
            <tr>
                <th scope="row"><label for="field_option_animation">Enable Option</label></th>
                <td>
                    <div id="field-template-container" class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_animation" <?= ($options['triangle_animation']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info">
                            You can turn on/off the animation by switching the toggle button. To see animation reference you can go to <code><a href="https://daneden.github.io/animate.css/" target="_blank">Animate.css</a></code>.
                        </p>
                    </div>
                </td>
            </tr>
            <!-- Section Tab -->
            <tr>
                <th scope="row"><label for="field_option_animation_tab">Section Tab</label></th>
                <td>
                    <div class="field-container">
                        <select name="field_option_animation_tab" id="field_option_animation_tab" class="select2">
                            <?= $this->loadContent('Element.option_animations', [
                                'value' => $options['triangle_animation_tab']
                            ]) ?>
                        </select>
                    </div>
                </td>
            </tr>
            <!-- Section Content -->
            <tr>
                <th scope="row"><label for="field_option_animation_content">Section Content</label></th>
                <td>
                    <div class="field-container">
                        <select name="field_option_animation_content" id="field_option_animation_content" class="select2">
                            <?= $this->loadContent('Element.option_animations', [
                                'value' => $options['triangle_animation_content']
                            ]) ?>
                        </select>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row"></th>
            </tr>

            <tr>
                <th scope="row">
                    <h3>Builder</h3>
                </th>
            </tr>

            <!-- Inliner -->
            <tr>
                <th scope="row"><label for="field_option_builder_inliner">CSSInliner</label></th>
                <td>
                    <div id="field-template-container" class="field-container">
                        <?php
                            $value = $options['triangle_builder_inliner'];
                            $opts = [ 'none' => 'None', 'juice' => 'Automattic/Juice'];
                        ?>
                        <select name="field_option_builder_inliner" id="field_option_builder_inliner" class="select2">
                            <?php foreach($opts as $key => $opt): ?>
                                <option value="<?= $key ?>" <?= ($key==$value) ? 'selected' : '' ?>>
                                    <?= $opt ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="field-info">
                            For more info you can go to <code>Docs</code> tab to see the reference.
                        </p>
                    </div>
                </td>
            </tr>

            <tr>
                <th scope="row"></th>
            </tr>

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
                            <input type="checkbox" name="field_option_smtp" <?= ($options['triangle_smtp']) ? 'checked' : '' ?> id="field_option_smtp">
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info">
                            Please turn off SMTP options if you're using <code>wp_mail</code> route plugin like <code>WP MAIL SMTP</code>.
                            So then it's not conflicted between these two options.
                        </p>
                    </div>
                </td>
            </tr>
            <!--Auth-->
            <tr>
                <th scope="row"><label for="field_option_smtp_auth">Auth</label></th>
                <td>
                    <div class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_smtp_auth" <?= ($options['triangle_smtp_auth']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>
                </td>
            </tr>
            <!--Host-->
            <tr>
                <th scope="row"><label for="field_option_smtp_host">Host/Port</label></th>
                <td>
                    <div class="field-container grid">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" name="field_option_smtp_host" value="<?= ($options['triangle_smtp_host']) ? $options['triangle_smtp_host'] : '' ?>" placeholder="mail.host.com">
                            </div>
                            <div class="col-3">
                                <input type="text" name="field_option_smtp_port" value="<?= ($options['triangle_smtp_port']) ? $options['triangle_smtp_port'] : '' ?>" placeholder="25 | 465 | 587">
                            </div>
                        </div>
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
                        <input type="password" name="field_option_smtp_password" value="<?= ($options['triangle_smtp_password']) ? $options['triangle_smtp_password'] : '' ?>" placeholder="Password">
                    </div>
                </td>
            </tr>
            <!--Encryption-->
            <tr>
                <th scope="row"><label for="field_option_smtp_encryption">Encryption</label></th>
                <td>
                    <div class="field-container">
                        <?php
                        $value = $options['triangle_smtp_encryption'];
                        $opts = [ 'none' => 'None', 'tls' => 'TLS', 'ssl' => 'SSL'];
                        ?>
                        <select name="field_option_smtp_encryption" id="field_option_smtp_encryption" class="select2">
                            <?php foreach($opts as $key => $opt): ?>
                                <option value="<?= $key ?>" <?= ($key==$value) ? 'selected' : '' ?>>
                                    <?= $opt ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </td>
            </tr>
            <!--TLS-->
            <tr>
                <th scope="row"><label for="field_option_smtp_tls">Auto TLS</label></th>
                <td>
                    <div class="field-container">
                        <label class="switch">
                            <input type="checkbox" name="field_option_smtp_tls" <?= ($options['triangle_smtp_tls']) ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                        <p class="field-info"> By default TLS encryption is automatically used if the server supports it, which is recommended. In some cases, due to server misconfigurations, this can cause issues and may need to be disabled.  </p>
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