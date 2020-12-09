<?php

use humhub\modules\ui\form\widgets\SortOrderField;
use humhub\widgets\Button;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use humhub\libs\Html;
use humhub\modules\user\widgets\UserPickerField;
use humhub\modules\space\widgets\SpacePickerField;

?>

<?php $this->beginContent('@admin/views/group/_manageLayout.php', ['group' => $group]) ?>
<div class="panel-body">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($group, 'name'); ?>
    <?= $form->field($group, 'description')->textarea(['rows' => 5]); ?>

    <?php if (!$group->is_admin_group): ?>
        <?= SpacePickerField::widget([
            'form' => $form,
            'model' => $group,
            'attribute' => 'defaultSpaceGuid',
            'selection' => $group->defaultSpaces,
            'maxSelection' => 1000,
        ])
        ?>
    <?php endif; ?>

    <div class="reassign-spaces">
        <?= Html::submitButton(Yii::t('AdminModule.user', 'Reassign All'), ['name' => 'submitReassignAll', 'value' => 'reassign-all', 'class' => 'btn btn-primary btn-reassign', 'data-method' => 'POST', 'data-confirm' => Yii::t('AdminModule.modules', 'Are you sure? All members of this group will be reassigned to all specified Spaces.')]); ?>
        <div class="help-block"><?= Yii::t('AdminModule.settings', 'Reassign default spaces to all users') ?></div>
    </div>

    <?php if ($isManagerApprovalSetting && !$group->is_admin_group): ?>
        <?php $url = ($group->isNewRecord) ? null : Url::to(['/admin/group/admin-user-search', 'id' => $group->id]); ?>
        <?= UserPickerField::widget([
            'form' => $form,
            'model' => $group,
            'attribute' => 'managerGuids',
            'selection' => $group->manager,
            'url' => $url
        ])
        ?>
    <?php endif; ?>

    <strong><?= Yii::t('AdminModule.user', 'Visibility'); ?></strong>
    <br>
    <br>
    <?php if (!$group->is_admin_group): ?>
        <?= $form->field($group, 'show_at_registration')->checkbox(); ?>
    <?php endif; ?>
    <?= $form->field($group, 'show_at_directory')->checkbox(); ?>
    <?= $form->field($group, 'sort_order')->widget(SortOrderField::class) ?>

    <?= Button::save()->submit(); ?>
    <?php
    if ($showDeleteButton) {
        echo Html::a(Yii::t('AdminModule.user', 'Delete'), Url::toRoute(['/admin/group/delete', 'id' => $group->id]), ['class' => 'btn btn-danger', 'data-method' => 'POST']);
    }
    ?>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->endContent(); ?>
