<?php
/**
 * [UserImport] ユーザー情報CSVインポート
 * @author          yutori
 * @link			https://yutori-shine.com/
 * @package			UserImport
 * @license			MIT
 */
?>
<div id="AlertMessage" class="message" style="display:none"></div>
<?php echo $this->BcForm->create('UserImport', array('url' => array('action' => 'csv_up'), 'enctype' => 'multipart/form-data')) ?>
<?php echo $this->BcFormTable->dispatchBefore() ?>
<div class="section">
    <table cellpadding="0" cellspacing="0" class="form-table bca-form-table" id="FormTable">
        <tr>
            <th class="col-head bca-form-table__label">
                <?php echo $this->BcForm->label('UserImport.csv', 'CSVファイル') ?>
                &nbsp;<span class="bca-label required size-small" data-bca-label-type="required"><?php echo __d('baser', '必須') ?></span>
            </th>
            <td class="col-input bca-form-table__input">
                <?php echo $this->BcForm->file('UserImport.csv') ?>
                <?php echo $this->BcForm->error('UserImport.csv') ?>
            </td>
        </tr>
        <?php echo $this->BcForm->dispatchAfterForm() ?>
    </table>
    <?php echo $this->BcFormTable->dispatchAfter() ?>
</div>
<div class="submit bca-actions">
    <?php echo $this->BcForm->submit('インポート', [
        'div' => false, 'class' => 'button bca-btn bca-actions__item',
        'data-bca-btn-type' => 'save', 'data-bca-btn-size' => 'lg', 'data-bca-btn-width' => 'lg', 'id' => 'BtnSave',
        'onClick' => "return confirm('CSVをインポートします。')",
    ]); ?>
</div>
<?php echo $this->BcForm->end() ?>