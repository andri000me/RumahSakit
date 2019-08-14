<?php
/* @var $this StudentQuizController */
/* @var $model StudentQuiz */

$this->breadcrumbs=array(
	'Student Quizs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List StudentQuiz', 'url'=>array('index')),
	array('label'=>'Create StudentQuiz', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#student-quiz-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Student Quizs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'student-quiz-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'quiz_id',
		'student_id',
		'created_at',
		'updated_at',
		'score',
		/*
		'right_answer',
		'wrong_answer',
		'unanswered',
		'student_answer',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
