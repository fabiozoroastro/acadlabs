<div class="discipline form"><?php echo $form->create('User', array('action' => 'edit')); ?>
<table class="form">
	<tr>
		<th><?php echo $form->input('id', array('type' =>'hidden'));?>
		<h2 class="left">Usu&aacute;rio #</h2>
		</th>

	</tr>
	<tr>
		<th>&nbsp;</th>
	</tr>
	<tr>
		<td><label for="UserName">Nome</label><span class="required">*</span></td>
	</tr>
	<tr>
		<td><?php echo $form->input('name', array('label' => false, 'class' => 'textfield', 'style' => 'width: 300px', 'maxlength' => '14')); ?></td>
	</tr>
	<tr>
		<td><label for="UserEmail">E-mail</label><span class="required">*</span></td>
	</tr>
	<tr>
		<td><?php echo $form->input('email', array('label' => false, 'class' => 'textfield', 'style' => 'width: 300px', 'maxlength' => '50')); ?></td>
	</tr>
	<tr>
		<td><label for="PasswordId">Senha</label><span
			class="required">*</span></td>
	</tr>
	<tr>
		<td><?php echo $form->input('password',array('label' => false, 'empty' => true,  'class' => 'textfield', 'style' => 'width: 300px', 'maxlength' => '8', 'value'=>'') );?>
		</td>
	</tr>
	<tr>
		<td><?php echo $form->submit('Gravar', array( 'id' => 'save', 'class' => 'form button' )); ?></td>
	</tr>
</table>

		<?php echo $form->end(); ?></div>
