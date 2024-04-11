<?php

use app\models\Request;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Requests';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Request', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'Категория',
                'value'=> function($data1){
                    return $data1->category->name;
                }
            ],
            'gos_nomer',
            'description:ntext',
            [
                    'label'=>'Статус',
                        'value'=>function ($data){
                            if ($data->status ==0) return 'Новая';
                            if ($data->status ==1) return 'Принята';
                            if ($data->status ==2) return 'Отказано';
                        },
],

            'description_denied',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Request $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
