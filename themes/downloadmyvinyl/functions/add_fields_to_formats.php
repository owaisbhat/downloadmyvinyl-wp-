<?php
	
add_action( 'format_edit_form_fields', 'formats_edit_taxonomy_custom_fields', 10, 1 );
function formats_edit_taxonomy_custom_fields( $tag ) { 
	$old_format_id = get_metadata( 'taxonomy', $tag->term_id, 'old_format_id', true );
?>
<!-- FORMATS
    -------------------------------------------------------------------------->
    <tr class="form-field">
        <th scope="row" valign="top">
            <label for="old_format_id">Old Format ID</label>
        </th>
        <td>
        <input type="text" name="term_meta[old_format_id]" id="term_meta[old_format_id]" 
value="<?php echo esc_attr( $old_format_id ) ? esc_attr( $old_format_id ) : ''; ?>"  size="25" />
            <br />
            <span class="description">The old Format ID</span>
        </td>
    </tr>
<?php
}

add_action( 'edited_format', 'formats_save_taxonomy_custom_fields', 10, 1 );
function formats_save_taxonomy_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset( $_POST['term_meta'][$key] ) ) {
                update_metadata( 'taxonomy', $term_id, $key, $_POST['term_meta'][$key] );
            }
        }
    }
}

?>
