<?php
/* @var $this HabilidadController */
/* @var $model Habilidad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'habilidad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'clientOptions'=>array('validateOnSubmit'=>true),
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son requeridos.</p>
	
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
						<?php #echo $form->labelEx($model,'id_desempe'); ?>
						<?php  if ($model->isNewRecord) echo $form->hiddenField($model,'id_habilidad',array('value'=>$model->buscarUltimo())); ?>
						<?php #echo $form->error($model,'id_desempe'); ?>

					</div>

					<div class="row" style="margin:10px;">
						<?php echo $form->labelEx($model,'Cedula',array('label' =>'Elige el funcionario que se le asignaran puntaje' , )); ?>
						<?php #echo $form->dropDownList($model,'Cedula',$model->menuCedula()); ?>
						<?php // Working with selector					 
						 $this->widget('ext.select2.ESelect2',array(				 
						  'model'=>$model,
						  'attribute'=>'Cedula',
						  'data'=>$model->menuCedula(),
						  'htmlOptions' => array('class' => 'span5')
						)); ?>
						<?php echo $form->error($model,'Cedula'); ?>
					</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_carisma_lider'); ?>
		<?php 
		
		echo $form->radioButton($model, 'num_carisma_lider', array(
		'value'=>0,
		'uncheckValue'=>null));echo "<span>  0 </span>" ;
		
		echo $form->radioButton($model, 'num_carisma_lider', array(
		'value'=>0.2,
		'uncheckValue'=>null));echo "<span>  1 </span>" ;
	
		echo $form->radioButton($model, 'num_carisma_lider', array(
		'value'=>0.4,
		'uncheckValue'=>null));echo "<span>  2 </span>" ; 
		
		echo $form->radioButton($model, 'num_carisma_lider', array(
		'value'=>0.6,
		'uncheckValue'=>null));echo "<span>  3 </span>" ;
                
                echo $form->radioButton($model, 'num_carisma_lider', array(
		'value'=>0.8,
		'uncheckValue'=>null));echo "<span>  4 </span>" ; 
		?>
		<?php echo $form->error($model,'num_carisma_lider'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_iniciativa_crea'); ?>
		<?php 
		
		echo $form->radioButton($model, 'num_iniciativa_crea', array(
		'value'=>0,
		'uncheckValue'=>null));echo "<span>  0 </span>" ;
		
		echo $form->radioButton($model, 'num_iniciativa_crea', array(
		'value'=>0.2,
		'uncheckValue'=>null));echo "<span>  1 </span>" ;
	
		echo $form->radioButton($model, 'num_iniciativa_crea', array(
		'value'=>0.4,
		'uncheckValue'=>null));echo "<span>  2 </span>" ; 
		
		echo $form->radioButton($model, 'num_iniciativa_crea', array(
		'value'=>0.6,
		'uncheckValue'=>null));echo "<span>  3 </span>" ;
                
                echo $form->radioButton($model, 'num_iniciativa_crea', array(
		'value'=>0.8,
		'uncheckValue'=>null));echo "<span>  4 </span>" ; 
		?>
		<?php echo $form->error($model,'num_iniciativa_crea'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_manejo_conflitos'); ?>
		<?php 
		
		echo $form->radioButton($model, 'num_manejo_conflitos', array(
		'value'=>0,
		'uncheckValue'=>null));echo "<span>  0 </span>" ;
		
		echo $form->radioButton($model, 'num_manejo_conflitos', array(
		'value'=>0.2,
		'uncheckValue'=>null));echo "<span>  1 </span>" ;
	
		echo $form->radioButton($model, 'num_manejo_conflitos', array(
		'value'=>0.4,
		'uncheckValue'=>null));echo "<span>  2 </span>" ; 
		
		echo $form->radioButton($model, 'num_manejo_conflitos', array(
		'value'=>0.6,
		'uncheckValue'=>null));echo "<span>  3 </span>" ;
                
                echo $form->radioButton($model, 'num_manejo_conflitos', array(
		'value'=>0.8,
		'uncheckValue'=>null));echo "<span>  4 </span>" ; 
		?>
		<?php echo $form->error($model,'num_manejo_conflitos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_coordinacion'); ?>
		<?php 
		
		echo $form->radioButton($model, 'num_coordinacion', array(
		'value'=>0,
		'uncheckValue'=>null));echo "<span>  0 </span>" ;
		
		echo $form->radioButton($model, 'num_coordinacion', array(
		'value'=>0.2,
		'uncheckValue'=>null));echo "<span>  1 </span>" ;
	
		echo $form->radioButton($model, 'num_coordinacion', array(
		'value'=>0.4,
		'uncheckValue'=>null));echo "<span>  2 </span>" ; 
		
		echo $form->radioButton($model, 'num_coordinacion', array(
		'value'=>0.6,
		'uncheckValue'=>null));echo "<span>  3 </span>" ;
                
		 echo $form->radioButton($model, 'num_coordinacion', array(
		'value'=>0.8,
		'uncheckValue'=>null));echo "<span>  4 </span>" ; 
		?>
		<?php echo $form->error($model,'num_coordinacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'num_toma_decisiones'); ?>
		<?php 
		
		echo $form->radioButton($model, 'num_toma_decisiones', array(
		'value'=>0,
		'uncheckValue'=>null));echo "<span>  0 </span>" ;
		
		echo $form->radioButton($model, 'num_toma_decisiones', array(
		'value'=>0.2,
		'uncheckValue'=>null));echo "<span>  1 </span>" ;
	
		echo $form->radioButton($model, 'num_toma_decisiones', array(
		'value'=>0.4,
		'uncheckValue'=>null));echo "<span>  2 </span>" ; 
		
		echo $form->radioButton($model, 'num_toma_decisiones', array(
		'value'=>0.6,
		'uncheckValue'=>null));echo "<span>  3 </span>" ;
                
                echo $form->radioButton($model, 'num_toma_decisiones', array(
		'value'=>0.8,
		'uncheckValue'=>null));echo "<span>  4 </span>" ; 
		?>
		<?php echo $form->error($model,'num_toma_decisiones'); ?>
	</div>

		<div class="row-check">
					<div  id="ave" lass="ave" >RESULTADOS</div>
					</div>

	<div class="row">
		<?php  #echo $form->labelEx($model,'num_TotHaPorc'); ?>
		<?php echo $form->hiddenField($model,'num_TotHaPorc',array('size'=>18,'maxlength'=>18)); ?>
		<?php  #echo $form->error($model,'num_TotHaPorc'); ?>
	</div>

	<div class="row">
		<?php # echo $form->labelEx($model,'num_TotHaNota'); ?>
		<?php echo $form->hiddenField($model,'num_TotHaNota',array('size'=>18,'maxlength'=>18)); ?>
		<?php #echo $form->error($model,'num_TotHaNota'); ?>
	</div>

	<div class="row-check">
						<?php if (yii::app()->user->checkAccess('Evaluador'))
								{
								echo $form->hiddenField($model,'id_evaluador', array('value' =>yii::app()->user->getState('cedula') , )); 
								}else{
									echo $form->labelEx($model,'id_evaluador',array('label' =>'Funcionario de Recepcion'));
									 $this->widget('ext.select2.ESelect2',array(				 
								  'model'=>$model,
								  'attribute'=>'id_evaluador',
								  'data'=>$model->menuCedula(),
								  'htmlOptions' => array('class' => 'span5')
								)); 
								}	

						# echo $form->dropDownList($model,'id_evaluador',$model->menuevaluador(),array('empty'=>' Seleccione ')); 
								?>
						
						<?php echo $form->error($model,'id_evaluador'); ?>
					</div><br>

					<div class="row-check">
						<?php echo'<br> '.$form->labelEx($model,'id_conf_asc_fecha'); ?>						
						<?php echo $form->dropDownList($model,'id_conf_asc_fecha',$model->menufecha(),array('empty'=>' Seleccione ')); ?>
						<?php echo $form->error($model,'id_conf_asc_fecha'); ?>
					</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Registrar' : 'Actualizar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->