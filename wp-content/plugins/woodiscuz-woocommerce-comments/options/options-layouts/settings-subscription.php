<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Email Subscription Settings', 'woodiscuz'); ?></h2>
    <table class="wp-list-table widefat plugins"  style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Notify post author on new comment', 'woodiscuz'); ?> 
                </th>
                <td colspan="2">                                
                    <label for="wpc_notify_moderator">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_notify_moderator == 1) ?> value="1" name="wpc_notify_moderator" id="wpc_notify_moderator" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Notify comment author on new reply', 'woodiscuz'); ?> 
                </th>
                <td colspan="2">                                
                    <label for="wpc_notify_comment_author">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_notify_comment_author == 1) ?> value="1" name="wpc_notify_comment_author" id="wpc_notify_comment_author" />
                    </label>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <?php _e('Requesting for comment on purchased product', 'woodiscuz'); ?> 
                </th>
                <td colspan="2">                                
                    <label for="wpc_request_for_comment">
                        <input type="checkbox" <?php checked($this->wpc_options_serialized->wpc_request_for_comment == 1) ?> value="1" name="wpc_request_for_comment" id="wpc_request_for_comment" />
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
</div>