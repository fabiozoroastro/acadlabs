<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta name="description" content="AcadLabs - Gestão de Laboratórios." />
      <title>AcadLabs</title>
      <link rel="shortcut icon" type="img/ico" href="<?php echo ($this->base);?>/favicon.ico" />
      <?php echo $html->css(array('print'), 'stylesheet', array('media' => 'print')); ?>
	  <?php echo $html->css('green-tie/jquery-ui-1.8.12.custom'); ?>
      <?php echo $html->css('jquery.ui.spinner'); ?>
	
	  <?php echo $html->css('screen'); ?>
      <?php echo $html->css('message'); ?>
      <?php echo $html->css('application'); ?>
      <?php echo $html->script('jquery-1.4.4.min'); ?>
      <?php echo $html->script('jquery.tools.min'); ?>
      <?php echo $html->script('application'); ?>
      <?php echo $html->script('jquery-ui-1.8.8.custom.min'); ?>
      <?php echo $html->script('jquery.purr'); ?>
<script>
/*
$(document).ready(function() {
	$('#spinner').spinner();
});
*/
</script>
   </head>
   <body>
      <div id="content">
         <div id="header">
            <div id="inner-header">            
               <?php echo $this->element('fullajaxload'); ?>
               <?php echo $this->element('lightajaxload'); ?>
               <h1>AcadLabs</h1>
               
               <p id="status">Logado:&nbsp;<?php echo $session->read('user.User.name'); ?>&nbsp;|&nbsp;<a href="<?php echo ($this->base);?>/logout">Logout</a></p>

               <div id="nav">

                  <ul id="nav-left">
                     <li><a href="<?php echo ($this->base);?>/users/edit" tabindex="1" title="Admin"><span>Admin</span></a></li>
                     <li><a href="<?php echo ($this->base);?>/reserves/calendar" tabindex="2" title="Calendar"><span>Calend&aacute;rio</span></a></li>
                  </ul>

                  <ul id="nav-right">
                     <li><a href="<?php echo ($this->base);?>/disciplines" tabindex="3"><span>Disciplinas</span></a></li>
                     <li><a href="<?php echo ($this->base);?>/laboratories" tabindex="4"><span>Laborat&oacute;rios</span></a></li>
                     <li><a href="<?php echo ($this->base);?>/softwares" tabindex="5"><span>Softwares</span></a></li>
                     <li><a href="<?php echo ($this->base);?>/periods" tabindex="5"><span>Per&iacute;odos</span></a></li>
                  </ul>
               </div><!-- end nav -->
            </div><!-- end inner-header -->
         </div><!-- end header -->

         <div id="shadow"></div>

         <div id="main">
            <div id="left-column">
               <div class="box">
                  <?php echo $content_for_layout; ?>
               </div>
            </div><!-- end left-column -->
            <div id="right-column">
               <div class="right-container">
                  <?php
                  if(isset($buttonList)){
                     foreach ($buttonList as $bu) {
                        echo "<a href='".$bu['method']."' style='text-decoration:none'>";
                        echo "<button type='button' id='".$bu['id']."' class='green button'>".$bu['text']."</button>";
                        echo "</a>";
                     }
                  }
                  ?>

               </div>
               
               <?php if( isset( $useFind) && $useFind ) {?>
	               <h3>Ir para: </h3>
	               <div class="right-container">
	                  <form id="jumpbox"  method="get" action="<?php echo ($this->base);echo "/"; echo ($this->params['controller']);?>/find">
	                     <p>
	                        <label for="jump_id"><em><?php echo( isset( $nameFilter ) ? $nameFilter : 'Filtro'); ?></em></label><br/>
	                        <input type="text" name="q" id="jump_id" size="8" class="textfield"/>
	                        <button class="button">Ir</button>
	                     </p>
	                  </form>
	               </div>
               <?php }?>
               
            </div><!-- end right-column -->
         </div><!-- end main -->

         <br/><br/></div><!-- end content -->

      <div id="footer">
         <p><strong><a href="mailto:fabiozoroastro@gmail.com">FZS</a></strong></p>
      </div>
		<?php
           try {
           
			$message->displayMessages();
			$message->displayWarnings();
			$message->displayErrors();
           
           } catch (Exception $e) {
	           //log.error(ignore);
           }
		?>
   </body>
</html>
