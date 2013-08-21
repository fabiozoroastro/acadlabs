<div id="login-content" style="text-align: center;">
<h1>Autentica&ccedil;&atilde;o</h1>

<div class="form box" style="text-align: center;"><?php echo $form->create('User', array('action' => 'login')); ?>
<table class="form" width="100%">
	<tr>
		<td><?php if($this->Session->read('firstAccess')){
			echo("<span class='required'>Primeiro acesso. Informe e-mail e senha para pr&eacute;-cadastro</span>");
		}?> <?php echo $session->flash(); ?>
		</td>
	</tr>
	<tr>
		<td><label for="UserEmail">E-mail</label></td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('email', array('label' => false, 'class' => 'textfield', 'style' => 'width:250px')); ?></td>
	</tr>
	<tr>
		<td><label for="UserPassword">Senha</label></td>
	</tr>
	<tr>
		<td><?php echo $this->Form->input('password', array('label' => false, 'class' => 'textfield', 'style' => 'width:250px')); ?></td>
	</tr>
	<tr>
		<td><?php echo $this->Form->submit('Login', array('class' => 'button')); ?></td>
	</tr>
</table>
		<?php echo $form->end(); ?></div>
</div>






