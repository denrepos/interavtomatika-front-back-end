<?php
	$json_translations = get_option('all_import_translation_corection');
	$translations = json_decode($json_translations);
	$translations = $translations['ru-ua'];

?>

<div class="wrap">
<h2>Translate settings</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

	<table class="form-table">
	
		<tr valign="top">
			<th scope="row">Collumns for translate.<br>Collumns must be separated by commas</th>
			<td><textarea name="all_import_fields_to_translation" cols="100" rows="5" ><?php echo get_option('all_import_fields_to_translation'); ?></textarea></td>
		</tr>
		
		<tr valign="top">
			<th scope="row">Correction of translation.<br>(ru-ua)<br>Exemple: ru text=ua text,ru text 2=ua text 2 etc...</th>
			<?php foreach( $translations as $key => $val ) { ?>
				<td> <?php echo $key .' - '. $val; ?> </td>
			<?php } ?>
			<td><input type="text" name="correction_from" value="" /> - <input type="text" name="correction_to" value="" /> <button class="button-primary"><?php _e('Add'); ?></button> </td>
			<td><input type="hidden" name="all_import_translation_corection" value="<?php echo $json_translations; ?>" /></td>
		</tr>
		
	</table>
	
	<input type="hidden" name="action" value="update" />
	
	<input type="hidden" name="page_options" value="all_import_translation_corection,all_import_fields_to_translation" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>
</form>
</div>

<script>
	
	

</script>