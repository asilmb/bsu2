<?php

use api\v4\modules\active\entities\FieldEntity;
use api\v4\modules\active\helpers\ActiveHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\Fields */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Fields', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fields-view">

    <p>
		<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
    </p>
	
	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'title',
			[
				'label' => t('active/field', 'active_name'),
				'value' => ActiveHelper::getTypeNameById($model->active_id),
			
			],
			'type',
			'sort',
			'is_hidden',
			'is_has_button',
			'is_readonly',
			'mask',
		],
	]) ?>

</div>


<?php
if ($model->type == FieldEntity::TYPE_SELECT) { ?>
    <div class="box box-primary">
		<?= $this->render('/option/index', ['dataProvider' => $dataProvider, 'field_id' => $model->id]) ?>
    </div>
<?php } else { ?>
    <div class="box box-primary">
		<?= $this->render('/validation/index', ['dataProvider' => $dataProvider, 'field_id' => $model->id]) ?>
    </div>
<?php } ?>



