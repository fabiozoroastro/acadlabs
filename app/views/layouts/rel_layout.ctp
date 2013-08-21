<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name="description" content="AcadLabs - Gestão de Laboratórios." />
<title>AcadLabs</title>
<link rel="shortcut icon" type="img/ico"
	href="<?php echo ($this->base);?>/favicon.ico" />
<?php echo $html->css(array('print'), 'stylesheet', array('media' => 'print')); ?>
<?php /*echo $html->css('black-tie/jquery-ui-1.8.8.custom'); */ ?>
<?php echo $html->css('jquery.ui.spinner'); ?>

<?php echo $html->css('screen'); ?>
<?php echo $html->css('message'); ?>
<?php echo $html->script('jquery-1.4.4.min'); ?>
<?php echo $html->script('jquery.tools.min'); ?>
<?php echo $html->script('application'); ?>
<?php echo $html->script('jquery-ui-1.8.8.custom.min'); ?>
<?php echo $html->script('jquery.purr'); ?>

<?php echo $content_for_layout; ?>
</body>

</html>
