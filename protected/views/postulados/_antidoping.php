<div class="view">

    <h2> Antidoping </h2>

<?php 

if ($model)
{
	$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'des_antid_asistencia',
		'des_antid_siglas_asistencia',
		'des_antid_condicion',		
	),
));
}else
{
	echo CHtml::link("ver",array('funcionarios/evaluacionesyExamenes','cedula'=>$cedula),array('class'=>"btn btn-primary"));  
#echo CHtml::button('Cargar Antidoping', array('submit' => array('Antidoping/Create', 'id'=>$id)));
}
?>
	
</div>