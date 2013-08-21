<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
      <meta name="description" content="TicketMule support ticket tracking" />
      <title>AcadLabs</title>
      <link rel="shortcut icon" type="image/ico" href="<%=app_root%>/favicon.ico" />
      <?php echo $html->css(array('print'), 'stylesheet', array('media' => 'print')); ?>
      <?php echo $html->css('screen'); ?>
      <?php echo $html->script('jquery-1.4.4.min'); ?>
      <?php echo $html->script('jquery.tools.min'); ?>
      <?php echo $html->script('application'); ?>
      <?php echo $html->script('jquery-ui-1.8.8.custom.min'); ?>
      <?php echo $html->script('jquery.ui.spinner'); ?>
      <?php echo $html->script('jquery.purr'); ?>
      <?php echo $html->css('screen'); ?>
      
   </head>

   <body>
      <div id="content">

         <div id="header">
            <div id="inner-header">
               <h1>AcadLabs</h1>
            </div>
         </div>

         <div id="shadow"></div>

         <div id="main">
            <?php echo $content_for_layout; ?>
         </div><!-- end main -->

         <br/><br/></div><!-- end content -->

      <div id="footer">
         <p><strong><a href="mailto:fabiozoroastro@gmail.com">FZS</a></strong></p>
      </div>

   </body>
</html>
