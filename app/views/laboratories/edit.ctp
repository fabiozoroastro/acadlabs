<div class="right" id="controls">
   <a href="<?php echo ($this->here);?>/../index/" class="back">Voltar</a>
</div>

<div class="laboratory form"><?php echo $form->create('Laboratory', array('action' => 'edit')); ?>

<table class="form">
      <tr>
         <th>
         <?php echo $form->input('id', array('type' =>'hidden'));?>
         <h2 class="left">Laborat&oacute;rio #<?php echo $this->data['Laboratory']['name']?> </h2></th>
      </tr>
	  <tr>
         <th>&nbsp;</th>
      </tr>
      <tr><td><label for="LaboratoryName">Novo Laboratorio</label><span class="required">*</span></td></tr>
      <tr><td><?php echo $form->input('name', array('label' => false, 'class' => 'textfield', 'style' => 'width: 300px')); ?></td></tr>
      
      <tr><td><label for="LaboratoryNumberComputers">N&#176; de Computadores</label><span class="required">*</span></td></tr>
      <tr><td><?php echo $form->input('number_computers', array('label' => false, 'class' => 'textfield', 'style' => 'width: 50px')); ?></td></tr>
      
      <tr><td><label for="LaboratoryDescription">Descri&ccedil;&atilde;o</label></td></tr>
      <tr><td><?php echo $form->textarea('description', array('label' => false, 'class' => 'textfield', 'style' => 'height: 100px; width: 300px')); ?></td></tr>
      <tr><td>&nbsp;</td></tr>
      <tr><td><?php
         	$options=array('1'=>'Ativo','0'=>'Inativo');
			$attributes=array('legend'=>false, 'value' => $this->data['Laboratory']['active'], 'style' => 'height:10px');
			echo $form->radio('active',$options,$attributes);
			?>
          </td>
      </tr>
      <tr>
         <td><?php echo $form->submit('Gravar', array( 'id' => 'save', 'class' => 'form button' )); ?></td>
      </tr>
   </table>

<?php echo $form->end(); ?></div>
