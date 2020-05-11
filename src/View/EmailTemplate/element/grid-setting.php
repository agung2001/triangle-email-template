<div class="grid">
    <div class="row section-fields">
        <div class="col-sm-2">
            <label>Column Size</label>
        </div>
        <div class="col-sm-5">
            <select id="grid-column-size">
                <?php for($i = 1; $i<=12; $i++): ?>
                    <option value="<?= $i ?>" <?= (isset($column) && $column==$i) ? 'selected' : '' ?>><?= $i ?> Column</option>
                <?php endfor; ?>
            </select>
            <p class="field-info">
                Grid column size 1-12
            </p>
        </div>
    </div>
</div>