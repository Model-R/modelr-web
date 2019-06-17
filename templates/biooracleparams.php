
 <table id="BioOracleTable">
  <tr>
	<th></th>
	<th class="thAlign">Max</th>
	<th class="thAlign">Mean</th>
	<th class="thAlign">Min</th>
	<th class="thAlign">Lt. Max</th>
	<th class="thAlign">Lt. Min</th>
	<th class="thAlign">Range</th>
  </tr>
  <?php 
	$sql = 'select * from modelr.raster where idsource = '.$idsource;
	$res = pg_exec($conn,$sql);
	while ($row = pg_fetch_array($res))
	{
		if($row['raster'] == 'Cloud cover' || $row['raster'] == 'Diffuse attenuation'){	
			?>
			<th class="fontSize"><?php echo $row['raster'];?></th>						
			<th class="thAlign" style="display: none;"><input checked type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Mean')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Mean" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Range')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Range" data-parsley-mincheck="2" required class="flat" /></th>
			</tr>
		<?php } 
		
		else if($row['raster'] == 'Calcite' || $row['raster'] == 'pH'){ ?>
			<th class="fontSize"><?php echo $row['raster'];?></th>						
			<th class="thAlign" style="display: none;"><input checked type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Mean')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Mean" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign" style="visibility: hidden;"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Range')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Range" data-parsley-mincheck="2" required class="flat" /></th>
			</tr>
		 <?php } else { ?>
			<th class="fontSize"><?php echo $row['raster'];?></th>						
			<th class="thAlign" style="display: none;"><input checked type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Mean')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Mean" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt max')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt max" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Lt min')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Lt min" data-parsley-mincheck="2" required class="flat" /></th>
			<th class="thAlign"><input <?php if ($Experimento->usaBioRaster($id,$row['idraster'],'Range')) echo "checked";?> type="checkbox" name="<?php echo str_replace(' ', '_', $row['raster']);?>[]" id="check<?php echo $row['raster'];?><?php echo $row['idraster'];?>" value="Range" data-parsley-mincheck="2" required class="flat" /></th>
			</tr>
		 <?php } ?>
 <?php } ?>
</table>

<style>
#BioOracleTable {
	width:650px;
	border-collapse: unset;
}

.fontSize{
	font-weight: 100;
}

.thAlign {
	text-align: center;
}
</style>