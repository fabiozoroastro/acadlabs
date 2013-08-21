<?php if( isset($softwares) && count($softwares) > 0 ) {?>
<table>
	<tr>
		<td><label for="LabsoftSoftwareId">Softwares</label><span
			class="required">*</span></td>
	</tr>
	<tr>
		<td>
		
    <?php
    	$indexId = 0;
    	foreach ($softwares as $obj ) {
	    	$exists = false;  
	    	if( isset($mySoftwares) && count($mySoftwares) > 0)
    		foreach ($mySoftwares as $currExis ) {	
    			if($currExis['Labsoft']['software_id'] == $obj['Software']['id']){
    				$exists = true;
    			}
    		}
    	?>		
    	<?php if( $exists ){ ?>
    		<input id="<?php echo "lab$indexId"?>" type="checkbox" value="<?php echo $obj['Software']['id']?>" name="data[software_id][]" checked="checked" />
    	<?php }else{?><input id="<?php echo "lab$indexId"?>" type="checkbox" value="<?php echo $obj['Software']['id']?>" name="data[software_id][]" /><?php }?>
    	<label for="<?php echo ("lab$indexId");?>"><?php echo $obj['Software']['name']?></label>
    	<?php $indexId;?>
    	<?php echo "<br />";?>
    <?php }?>		
		</td>
	</tr>
	<tr>
		<td><?php echo $form->submit('Gravar', array( 'id' => 'save', 'class' => 'form button' )); ?></td>
	</tr>
</table>
<?php }?>