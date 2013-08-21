<script type="text/javascript">

$(document).ready(function() {
	var id =  $('#LabsoftLaboratoryId').val();
	if( id != null && id != 'undefined'){
		changeLab(id);
	}
		
});

/**
 * Loads in a URL into a specified divName, and applies the function to
 * all the links inside the pagination div of that page (to preserve the ajax-request)
 * @param string href The URL of the page to load
 * @param string divName The name of the DOM-element to load the data into
 * @return boolean False To prevent the links from doing anything on their own.
 */
function loadPiece(href,divName) {
   
   $(divName).load(href, {}, function(){
      
      //CallBack - Function active
      $("#light-ajax-loading").css("display", "none");

      var divPaginationLinks = divName+" #pagination a";
      $(divPaginationLinks).click(function() {
         var thisHref = $(this).attr("href");
         loadPiece(thisHref,divName);
         return false;
      });
   });
   //New Request...
   $("#light-ajax-loading").css("display", "inline");
}



function changeLab( id ){
	var url = "<?php echo $html->url(array('controller' => 'labsofts', 'action' => 'softs'));?>";
	url += "/";
	url += id;
	loadPiece(url,"#softs");
}

</script>

<div class="right" id="controls"><a
	href="<?php echo ($this->here);?>/../../laboratories/index/" class="back">Voltar</a></div>

<div class="discipline form"><?php echo $form->create('Labsoft',array('action' => 'add')); ?>

<table class="form">
	<tr>
		<th>
		<h2 class="left">Associação de Softwares</h2>
		</th>
	</tr>
	<tr>
		<td colspan="2"><label for="LabsoftLaboratoryId">Laborat&oacute;rios</label><span
			class="required">*</span></td>
			
	</tr>
	<tr>
		<td><?php echo $form->input('laboratory_id',array('label' => false, 'options' => $laboratories, 'empty' => true,  'class' => 'textfield', 'style' => 'width: 300px', 'onchange' => 'changeLab(this.value)') );?></td>
	</tr>
</table>
<br />
<div id="softs"></div>
<?php echo $form->end(); ?></div>
