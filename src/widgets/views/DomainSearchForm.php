<?php
/**
 * Selling site for HiPanel
 *
 * @link      http://hipanel.com/
 * @package   hipanel-site
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hiqdev\combo\StaticCombo;

/* @var $model \hipanel\modules\domain\models\Domain */

$this->registerJs("
$('.check-all').click(function() {
    var selector = $(this).is(':checked') ? ':not(:checked)' : ':checked';

    $('#bulkcheckform-zones input[type=\"checkbox\"]' + selector).each(function() {
        $(this).trigger('click');
    });
});

// Synchronize both form values
$('.domain-search-form-container li > a').click(function() {
    var currentValue = $('.domain-search-form-container .tab-pane.active #fqdns').val();
    $('.domain-search-form-container .tab-pane:not(.active) #fqdns').focus().val(currentValue);
});
");

$this->registerCss('
#bulkcheckform-zones {
    column-count: 5;
}

#bulkcheckform-zones label {
    display: block;
}

.domain-search-form-container ul[role="tablist"] a {
    font-size: small;
    text-transform: lowercase;
}

.domain-search-form-container ul[role="tablist"] li.active {
    display: none;
}

.domain-search-form-container .tab-content > .tab-pane {
    padding: 0px;
    border: none;
}
@media (max-width: 768px) {
    .domainavailability .domain-form-container {
        width: 93%;
    }
    .domain-search-form-container ul {
        text-align: center;
        margin-top: 1em;
    }
}
');

?>
<div class="domain-search-form-container">
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="simple-search">
            <?php $form = ActiveForm::begin([
                'id' => 'check-domain',
                'method' => 'get',
                'action' => Url::toRoute('/domain/check/check-domain'),
                'options' => [
                    'class' => 'material',
                ],
                'fieldConfig' => [
                    'template' => "{input}\n{hint}\n{error}",
                ],
            ]) ?>

            <?= $form->field($model, 'fqdns', ['template' => $template])->textInput([
                'placeholder' => Yii::t('hipanel:domain', 'Domain search'),
                'name' => 'fqdns',
                'id' => 'domain',
                'value' => $model->fqdnsInline,
                'autocomplete' => 'off',
                'autofocus' => true,
            ]) ?>

            <?php $form::end() ?>
        </div>
        <div role="tabpanel" class="tab-pane" id="mass-search">
            <?php $form = ActiveForm::begin([
                'id' => 'check-domain',
                'method' => 'get',
                'action' => Url::toRoute('/domain/check/check-domain'),
                'options' => [
                    'class' => 'material',
                ],
                'fieldConfig' => [
                    'template' => "{input}\n{hint}\n{error}",
                ],
            ]) ?>

            <?= $form->field($model, 'fqdns', ['template' => $template])->textarea([
                'placeholder' => Yii::t('hipanel:domain', 'Domain search'),
                'name' => 'fqdns',
                'id' => 'domain',
                'value' => $model->fqdnsInline,
                'autocomplete' => 'off',
                'autofocus' => true,
            ]) ?>

            <div class="row">
                <div class="col-sm-12">
                    <?= $form->field($model, 'zones')->checkboxList($zones, ['name' => 'zones']) ?>
                    <div class="row no-gutter">
                        <div class="col-sm-10">
                            <?= Html::checkbox(null, false, [
                                'label' => Yii::t('hipanel:site', 'Check all'),
                                'class' => 'check-all',
                            ]) ?>
                        </div>
                        <div class="col-sm-2">
                            <?= Html::submitButton(null, ['class' => 'mtr-btn button-fab fa fa-search hidden-xs hidden-sm']) ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php $form::end() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <ul class="list-inline" role="tablist">
                <li role="presentation" class="active">
                    <a href="#simple-search" aria-controls="simple-search" role="tab"
                       data-toggle="tab" class="btn btn-danger btn-sm">
                        <?= Yii::t('hipanel:site', 'Simple search') ?>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#mass-search" aria-controls="mass-search" role="tab"
                       data-toggle="tab" class="btn btn-danger btn-sm">
                        <?= Yii::t('hipanel:site', 'Mass search') ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
