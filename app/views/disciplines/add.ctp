
<div class="right" id="controls"><a
	href="<?php echo ($this->here);?>/../index/" class="back">Voltar</a></div>

<div class="discipline form"><?php echo $form->create('Discipline', array('action' => 'add')); ?>

<table class="form">
	<tr>
		<th>
		<h2 class="left">Nova Disciplina</h2>
		</th>
	</tr>
	<tr>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><label for="DisciplineName">Nome</label><span class="required">*</span></td>
	</tr>
	<tr>
		<td><?php echo $form->input('name', array('label' => false, 'class' => 'textfield', 'style' => 'width: 300px')); ?></td>
	</tr>
	<tr>
		<td><label for="DisciplineCourseId">Curso</label><span class="required">*</span></td>
	</tr>
	<tr>
		<td><?php echo $form->input('course_id',array('label' => false, 'options' => $courses, 'empty' => true,  'class' => 'textfield', 'style' => 'width: 300px') );?>
			</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php
		$options=array('1'=>'Ativo','0'=>'Inativo');
		$attributes=array('legend'=>false, 'value' => $this->data['Discipline']['active'], 'style' => 'height:10px', 'default' => '1');
		echo $form->radio('active',$options,$attributes);
		?></td>
	</tr>
	<tr>
		<td><?php echo $form->submit('Gravar', array( 'id' => 'save', 'class' => 'form button' )); ?></td>
	</tr>
</table>

		<?php echo $form->end(); ?></div>
