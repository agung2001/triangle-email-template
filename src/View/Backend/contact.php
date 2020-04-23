<div class="triangle-container">
    <div class="header bg-carrot">
        <ul class="nav-tab-wrapper">
            <li class="nav-tab nav-tab-active" data-tab="section-contact">Contact</li>
        </ul>
    </div>
    <div class="content">
        <div id="section-contact" class="tab-content current">
            <table class="form-table" role="presentation">
                <form method="post">
                    <tbody>
                        <!-- Template Field -->
                        <tr>
                            <th scope="row"><label for="template">Template</label></th>
                            <td>
                                <?= $this->loadContent('Element.loading-field', [
                                    'id' => 'loading-field-template'
                                ]) ?>
                                <div id="field-template-container" class="field-container field-ajax">
                                    <select name="field_template" id="select-field-template"></select>
                                    <p class="field-info"> Choose email template </p>
                                </div>
                            </td>
                        </tr>

                        <!-- User Field -->
                        <tr>
                            <th scope="row"><label for="user">User</label></th>
                            <td>
                                <?= $this->loadContent('Element.loading-field', [
                                    'id' => 'loading-field-user'
                                ]) ?>
                                <div id="field-user-container" class="field-container field-ajax">
                                    <select name="user" id="select-user-lists"></select>
                                    <a id="add-user-to-lists"><i class="fas fa-plus-circle"></i></a>
                                    <p class="field-info"> Select user to be contacted </p>
                                    <input type="text" name="field_users" id="field-users">
                                    <div id="user-lists"></div>
                                </div>
                            </td>
                        </tr>

                        <!-- From Name -->
                        <tr>
                            <th scope="row"><label for="from_name">From Name</label></th>
                            <td>
                                <div class="field-container">
                                    <input type="text" name="field_from_name" id="field-from-name">
                                </div>
                            </td>
                        </tr>

                        <!-- From Email -->
                        <tr>
                            <th scope="row"><label for="from_email">From Email</label></th>
                            <td>
                                <div class="field-container">
                                    <input type="text" name="field_from_email" id="field-from-email">
                                </div>
                            </td>
                        </tr>

                        <!-- From Email -->
                        <tr>
                            <th scope="row">&nbsp;</th>
                            <td>
                                <div class="field-container">
                                    <button typpe="submit" class="btn-submit">SEND</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </form>
            </table>
        </div>
    </div>
</div>