<div>
<?php		
	$sql = 'select * from modelr.raster where idsource = '.$idsource;
	$res = pg_exec($conn,$sql);
	while ($row = pg_fetch_array($res)){ ?>
	
		<input <?php if ($Experimento->usaRaster($id,$row['idraster'])) echo "checked";?> type="checkbox" name="raster[]" id="checkraster<?php echo $row['idraster'];?>" value="<?php echo $row['idraster'];?>" data-parsley-mincheck="2" required class="flat" /> <?php echo $row['raster'];?>
		<br />				
<?php } ?>
</div>