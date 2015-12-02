<?php

class WpdiscuzOptions {

    private $optionsSerialized;
    private $dbManager;
    private $postTypes;
    private $blogRoles;
    private $shareButtons;

    public function __construct($optionsSerialized, $dbManager) {
        $this->dbManager = $dbManager;
        $this->optionsSerialized = $optionsSerialized;
        $this->initShareButtons();
    }

    /**
     * Builds options page
     */
    public function mainOptionsForm() {
        $defaultPostTypes = get_post_types('', 'names');
        foreach ($defaultPostTypes as $postType) {
            if ($postType != 'revision' && $postType != 'nav_menu_item') {
                $this->postTypes[] = $postType;
            }
        }
        $this->blogRoles['post_author'] = '#00B38F';
        $blogRoles = get_editable_roles();
        foreach ($blogRoles as $roleName => $roleInfo) {
            $this->blogRoles[$roleName] = '#00B38F';
        }
        $this->blogRoles['guest'] = '#00B38F';

        if (isset($_POST['wc_submit_options'])) {

            if (function_exists('current_user_can') && !current_user_can('manage_options')) {
                die(_e('Hacker?', 'wpdiscuz'));
            }

            if (function_exists('check_admin_referer')) {
                check_admin_referer('wc_options_form');
            }

            $this->optionsSerialized->postTypes = isset($_POST['wc_post_types']) ? $_POST['wc_post_types'] : array();
            $this->optionsSerialized->commentListUpdateType = isset($_POST['wc_comment_list_update_type']) ? $_POST['wc_comment_list_update_type'] : 0;
            $this->optionsSerialized->commentListUpdateTimer = isset($_POST['wc_comment_list_update_timer']) ? $_POST['wc_comment_list_update_timer'] : 30;
            $this->optionsSerialized->liveUpdateGuests = isset($_POST['wc_live_update_guests']) ? $_POST['wc_live_update_guests'] : 0;
            $this->optionsSerialized->commentEditableTime = isset($_POST['wc_comment_editable_time']) ? $_POST['wc_comment_editable_time'] : 900;
            $this->optionsSerialized->redirectPage = isset($_POST['wpdiscuz_redirect_page']) ? $_POST['wpdiscuz_redirect_page'] : 0;
            $this->optionsSerialized->isGuestCanVote = isset($_POST['wc_is_guest_can_vote']) ? $_POST['wc_is_guest_can_vote'] : 0;
            $this->optionsSerialized->commentListLoadType = isset($_POST['commentListLoadType']) ? $_POST['commentListLoadType'] : 0;
            $this->optionsSerialized->votingButtonsShowHide = isset($_POST['wc_voting_buttons_show_hide']) ? $_POST['wc_voting_buttons_show_hide'] : 0;
            $this->optionsSerialized->shareButtons = isset($_POST['wpdiscuz_share_buttons']) ? $_POST['wpdiscuz_share_buttons'] : array();
            $this->optionsSerialized->captchaShowHide = isset($_POST['wc_captcha_show_hide']) ? $_POST['wc_captcha_show_hide'] : 0;
            $this->optionsSerialized->captchaShowHideForMembers = isset($_POST['wc_captcha_show_hide_for_members']) ? $_POST['wc_captcha_show_hide_for_members'] : 0;
            $this->optionsSerialized->weburlShowHide = isset($_POST['wc_weburl_show_hide']) ? $_POST['wc_weburl_show_hide'] : 0;
            $this->optionsSerialized->headerTextShowHide = isset($_POST['wc_header_text_show_hide']) ? $_POST['wc_header_text_show_hide'] : 0;
            $this->optionsSerialized->isNameFieldRequired = isset($_POST['wc_is_name_field_required']) ? $_POST['wc_is_name_field_required'] : 0;
            $this->optionsSerialized->isEmailFieldRequired = isset($_POST['wc_is_email_field_required']) ? $_POST['wc_is_email_field_required'] : 0;
            $this->optionsSerialized->showHideLoggedInUsername = isset($_POST['wc_show_hide_loggedin_username']) ? $_POST['wc_show_hide_loggedin_username'] : 0;
            $this->optionsSerialized->replyButtonGuestsShowHide = isset($_POST['wc_reply_button_guests_show_hide']) ? $_POST['wc_reply_button_guests_show_hide'] : 0;
            $this->optionsSerialized->replyButtonMembersShowHide = isset($_POST['wc_reply_button_members_show_hide']) ? $_POST['wc_reply_button_members_show_hide'] : 0;
            $this->optionsSerialized->authorTitlesShowHide = isset($_POST['wc_author_titles_show_hide']) ? $_POST['wc_author_titles_show_hide'] : 0;
            $this->optionsSerialized->simpleCommentDate = isset($_POST['wc_simple_comment_date']) ? $_POST['wc_simple_comment_date'] : 0;
            $this->optionsSerialized->showSubscriptionBar = isset($_POST['show_subscription_bar']) ? $_POST['show_subscription_bar'] : 0;
            $this->optionsSerialized->showHideReplyCheckbox = isset($_POST['wc_show_hide_reply_checkbox']) ? $_POST['wc_show_hide_reply_checkbox'] : 0;
            $this->optionsSerialized->showSortingButtons = isset($_POST['show_sorting_buttons']) ? $_POST['show_sorting_buttons'] : 0;
            $this->optionsSerialized->mostVotedByDefault = isset($_POST['mostVotedByDefault']) ? $_POST['mostVotedByDefault'] : 0;
            $this->optionsSerialized->usePostmaticForCommentNotification = isset($_POST['wc_use_postmatic_for_comment_notification']) ? $_POST['wc_use_postmatic_for_comment_notification'] : 0;
            $this->optionsSerialized->formBGColor = isset($_POST['wc_form_bg_color']) ? $_POST['wc_form_bg_color'] : '#f9f9f9';
            $this->optionsSerialized->commentTextSize = isset($_POST['wc_comment_text_size']) ? $_POST['wc_comment_text_size'] : '14px';
            $this->optionsSerialized->commentBGColor = isset($_POST['wc_comment_bg_color']) ? $_POST['wc_comment_bg_color'] : '#fefefe';
            $this->optionsSerialized->replyBGColor = isset($_POST['wc_reply_bg_color']) ? $_POST['wc_reply_bg_color'] : '#f8f8f8';
            $this->optionsSerialized->commentTextColor = isset($_POST['wc_comment_text_color']) ? $_POST['wc_comment_text_color'] : '#555';
            $this->optionsSerialized->primaryColor = isset($_POST['wc_comment_username_color']) ? $_POST['wc_comment_username_color'] : '#00B38F';
            $this->optionsSerialized->blogRoles = isset($_POST['wc_blog_roles']) ? wp_parse_args($_POST['wc_blog_roles'], $this->blogRoles) : $this->blogRoles;
            $this->optionsSerialized->voteReplyColor = isset($_POST['wc_vote_reply_color']) ? $_POST['wc_vote_reply_color'] : '#666666';
            $this->optionsSerialized->inputBorderColor = isset($_POST['wc_input_border_color']) ? $_POST['wc_input_border_color'] : '#d9d9d9';
            $this->optionsSerialized->newLoadedCommentBGColor = isset($_POST['wc_new_loaded_comment_bg_color']) ? $_POST['wc_new_loaded_comment_bg_color'] : '#FFFAD6';
            $this->optionsSerialized->customCss = isset($_POST['wc_custom_css']) ? $_POST['wc_custom_css'] : '.comments-area{width:auto; margin: 0 auto;}';
            $this->optionsSerialized->showPluginPoweredByLink = isset($_POST['wc_show_plugin_powerid_by']) ? $_POST['wc_show_plugin_powerid_by'] : 0;
            $this->optionsSerialized->isUsePoMo = isset($_POST['wc_is_use_po_mo']) ? $_POST['wc_is_use_po_mo'] : 0;
            $this->optionsSerialized->disableMemberConfirm = isset($_POST['wc_disable_member_confirm']) ? $_POST['wc_disable_member_confirm'] : 0;
            $this->optionsSerialized->commentTextMinLength = (isset($_POST['wc_comment_text_min_length']) && intval($_POST['wc_comment_text_min_length']) && intval($_POST['wc_comment_text_min_length']) > 0) ? intval($_POST['wc_comment_text_min_length']) : 1;
            $this->optionsSerialized->commentTextMaxLength = (isset($_POST['wc_comment_text_max_length']) && intval($_POST['wc_comment_text_max_length']) && intval($_POST['wc_comment_text_max_length']) > 0) ? intval($_POST['wc_comment_text_max_length']) : '';
            $this->optionsSerialized->showHideCommentLink = isset($_POST['showHideCommentLink']) ? $_POST['showHideCommentLink'] : 0;
            $this->optionsSerialized->updateOptions();
        }
        ?>

        <div class="wrap wpdiscuz_options_page">
            <div style="float:left; width:50px; height:55px; margin:10px 10px 20px 0px;">
                <img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/plugin-icon/plugin-icon-48.png'); ?>"/>
            </div>
            <h2 style="padding-bottom:20px; padding-top:15px;"><?php _e('wpDiscuz General Settings', 'wpdiscuz'); ?></h2>
            <br style="clear:both" />
            <link rel="stylesheet" href="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>bxslider/jquery.bxslider.css" type="text/css" />
            <script src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>bxslider/jquery.min.js"></script>
            <script src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>bxslider/jquery.bxslider.js"></script>
            <table width="100%" border="0" cellspacing="1" class="widefat">
                <tr>
                    <td style="padding:10px; padding-left:0px; vertical-align:top; width:500px;">
                        <div class="slider">
                            <ul class="bxslider">
                                <li><a href="https://wordpress.org/plugins/woodiscuz-woocommerce-comments/screenshots/"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/3.png" title="Free Download from Wordpress.org" style="padding:0px 0px 20px 20px;" /></a></li>
                                <li><a href="https://wordpress.org/plugins/woocommerce-category-slider/screenshots/"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/5.png" title="Free Download from Wordpress.org" style="padding:0px 0px 20px 20px;" /></a></li>
                                <li><a href="https://wordpress.org/plugins/woocommerce-pdf-print/"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/4.png" title="Free Download from Wordpress.org" style="padding:0px 0px 20px 20px;" /></a></li>
                                <li><a href="https://wordpress.org/plugins/advanced-content-pagination/screenshots/"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/1.png" title="Free Download from Wordpress.org" style="padding:0px 0px 20px 20px;" /></a></li>
                                <li><a href="https://wordpress.org/plugins/author-and-post-statistic-widgets/"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/2.png" title="Free Download from Wordpress.org" style="padding:0px 0px 20px 20px;" /></a></li>
                            </ul>
                        </div>
                        <div style="clear:both"></div>
                    </td>
                    <td valign="top" style="padding:20px;">
                        <table width="100%" border="0" cellspacing="1" class="widefat">
                            <thead>
                                <tr>
                                    <th style="font-size:14px; background-color:#FEFCE7">&nbsp;Information</th>
                                </tr>
                            </thead>
                            <tr valign="top">
                                <td style="background:#FFF; text-align:left; font-size:13px;">
                                    wpDiscuz is also available for WooCommerce. The WooCommerce Comments plugin name is <a href="https://wordpress.org/plugins/woodiscuz-woocommerce-comments/" style="color:#993399; text-decoration:underline;"><strong>WooDiscuz</strong></a>. It adds a new "Discussion" Tab on product page and allows your customers ask Pre-Sale Questions and discuss about your products.
                                </td>
                            </tr>
                        </table><br />
                        <table width="100%" border="0" cellspacing="1" class="widefat">
                            <thead>
                                <tr>
                                    <th style="font-size:16px; background-color:#FEFCE7;"><strong>Like wpDiscuz?</strong> <br /><span style="font-size:15px">We really need your reviews!</span></th>
                                </tr>
                            </thead>
                            <tr valign="top">
                                <td style="background:#FFF; text-align:left; font-size:13px;">
                                    We do our best to make wpDiscuz the best self-hosted comment plugin for Wordpress. Thousands users are currently satisfied with wpDiscuz but only about 1% of them give us 5 start rating.
                                    However we have a very few users who for some very specific reasons are not satisfied and they are very active in decreasing wpDiscuz rating.
                                    Please help us keep plugin rating high, encouraging us to develop and maintain this plugin. Take a one minute to leave <a href="https://wordpress.org/support/view/plugin-reviews/wpdiscuz?filter=5" title="Go to wpDiscuz Reviews section on Wordpress.org"><img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/'); ?>assets/img/gc/5s.png" border="0" align="absmiddle" /></a> star review on <a href="https://wordpress.org/support/view/plugin-reviews/wpdiscuz?filter=5">Wordpress.org</a>. Thank You!
                                    <hr style="border-style:dotted;" />
                                    <div style="width:200px; float:right;">
                                        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                            <input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="UC44WQM5XJFPA"><input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                                        </form>
                                    </div>
                                    We spend as much of my spare time as possible working on wpDiscuz and any donation is appreciated. Donations play a crucial role in supporting Free and Open Source Software projects.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <script>
                $('.bxslider').bxSlider({
                    mode: 'fade',
                    captions: false,
                    auto: true
                });
            </script>
            <br />
            <?php
            if (isset($_GET['wpdiscuz_reset_options']) && $_GET['wpdiscuz_reset_options'] == 1 && current_user_can('manage_options')) {
                delete_option(WpdiscuzCore::OPTION_SLUG_OPTIONS);
                $this->optionsSerialized->postTypes = array('post');
                $this->optionsSerialized->shareButtons = array('fb', 'twitter', 'google');
                $this->optionsSerialized->addOptions();
                $this->optionsSerialized->initOptions(get_option(WpdiscuzCore::OPTION_SLUG_OPTIONS));
                $this->optionsSerialized->blogRoles['post_author'] = '#00B38F';
                $blogRoles = get_editable_roles();
                foreach ($blogRoles as $roleName => $roleInfo) {
                    $this->optionsSerialized->blogRoles[$roleName] = '#00B38F';
                }
                $this->optionsSerialized->blogRoles['guest'] = '#00B38F';
                $this->optionsSerialized->showPluginPoweredByLink = 1;
                $this->optionsSerialized->updateOptions();
            }
            ?>

            <form action="<?php echo admin_url(); ?>edit-comments.php?page=wpdiscuz_options_page" method="post" name="wpdiscuz_options_page" class="wc-main-settings-form wc-form">
                <?php
                if (function_exists('wp_nonce_field')) {
                    wp_nonce_field('wc_options_form');
                }
                ?>
                <h2>&nbsp;</h2>
                <div id="optionsTab">
                    <ul class="resp-tabs-list options_tab_id">
                        <li><?php _e('General settings', 'wpdiscuz'); ?></li>
                        <li><?php _e('Live Update', 'wpdiscuz'); ?></li>
                        <li><?php _e('Show/Hide Components', 'wpdiscuz'); ?></li>
                        <li><?php _e('Email Subscription', 'wpdiscuz'); ?> <?php if (class_exists('Prompt_Comment_Form_Handling')): ?> <?php _e('and Postmatic', 'wpdiscuz'); ?> <?php endif; ?></li>
                        <li><?php _e('Background and Colors', 'wpdiscuz'); ?></li>
                        <li><?php _e('Social Login', 'wpdiscuz'); ?></li>
                    </ul>
                    <div class="resp-tabs-container options_tab_id">
                        <?php
                        include 'options-layouts/settings-general.php';
                        include 'options-layouts/settings-live-update.php';
                        include 'options-layouts/settings-show-hide.php';
                        include 'options-layouts/settings-subscription.php';
                        include 'options-layouts/settings-style.php';
                        include 'options-layouts/settings-social.php';
                        ?>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var width = 0;
                        var optionsTabsType = 'default';
                        $('#optionsTab ul.resp-tabs-list.options_tab_id li').each(function () {
                            width += $(this).outerWidth(true);
                        });

                        if (width > $('#optionsTab').innerWidth()) {
                            optionsTabsType = 'vertical';
                        }

                        var url = '<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/'); ?>';
                        $('.wpdiscuz-share-buttons').each(function () {
                            setBG($(this));
                        });
                        $('.wpdiscuz-share-buttons').click(function () {
                            setBG($(this));
                        });
                        function setBG(field) {
                            if ($('.wc_share_button', field).is(':checked')) {
                                $(field).css('background', 'url("' + url + $('.wc_share_button', field).val() + '-18x18-orig.png")');
                            } else {
                                $(field).css('background', 'url("' + url + $('.wc_share_button', field).val() + '-18x18.png")');
                            }
                        }
                        //Horizontal Tab
                        $('#optionsTab').easyResponsiveTabs({
                            type: optionsTabsType, //Types: default, vertical, accordion
                            width: 'auto', //auto or any width like 600px
                            fit: true, // 100% fit in a container
                            tabidentify: 'options_tab_id' // The tab groups identifier
                        });
                        $(document).delegate('.options_tab_id .resp-tab-item', 'click', function () {
                            var activeTabIndex = $('.resp-tabs-list.options_tab_id li.resp-tab-active').index();
                            $.cookie('optionsActiveTabIndex', activeTabIndex, {expires: 30});
                        });
                        var savedIndex = $.cookie('optionsActiveTabIndex') >= 0 ? $.cookie('optionsActiveTabIndex') : 0;
                        $('.resp-tabs-list.options_tab_id li').removeClass('resp-tab-active');
                        $('.resp-tabs-container.options_tab_id > div').removeClass('resp-tab-content-active');
                        $('.resp-tabs-container.options_tab_id > div').css('display', 'none');
                        $('.resp-tabs-list.options_tab_id li').eq(savedIndex).addClass('resp-tab-active');
                        $('.resp-tabs-container.options_tab_id > div').eq(savedIndex).addClass('resp-tab-content-active');
                        $('.resp-tabs-container.options_tab_id > div').eq(savedIndex).css('display', 'block');
                    });
                </script>
                <table class="form-table wc-form-table">
                    <tbody>
                        <tr valign="top">
                            <td colspan="4">
                                <p class="submit">
                                    <a style="float: left;" class="button button-secondary" href="<?php echo admin_url(); ?>edit-comments.php?page=wpdiscuz_options_page&wpdiscuz_reset_options=1"><?php _e('Reset Options', 'wpdiscuz'); ?></a>
                                    <?php  $clearChildrenUrl = admin_url('admin-post.php/?action=clearChildrenData&clear=1'); ?>
                                    <a href="<?php echo wp_nonce_url($clearChildrenUrl, 'clear_children_data'); ?>" class="button button-secondary" title="Use this button if wpDiscuz has been deactivated for a while." style="margin-left: 5px;" id="wpdiscuz_synch_comments"><?php _e('Refresh comment optimization', 'wpdiscuz'); ?></a>
                                    <input style="float: right;" type="submit" class="button button-primary" name="wc_submit_options" value="<?php _e('Save Changes', 'wpdiscuz'); ?>" />                                
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="action" value="update" />
            </form>
        </div>
        <?php
    }

    public function phrasesOptionsForm() {
        if (isset($_POST['wc_submit_phrases'])) {
            if (function_exists('current_user_can') && !current_user_can('manage_options')) {
                die(_e('Hacker?', 'wpdiscuz'));
            }
            if (function_exists('check_admin_referer')) {
                check_admin_referer('wc_phrases_form');
            }
            $this->optionsSerialized->phrases['wc_leave_a_reply_text'] = $_POST['wc_leave_a_reply_text'];
            $this->optionsSerialized->phrases['wc_be_the_first_text'] = $_POST['wc_be_the_first_text'];
            $this->optionsSerialized->phrases['wc_header_text'] = $_POST['wc_header_text'];
            $this->optionsSerialized->phrases['wc_header_text_plural'] = $_POST['wc_header_text_plural'];
            $this->optionsSerialized->phrases['wc_header_on_text'] = $_POST['wc_header_on_text'];
            $this->optionsSerialized->phrases['wc_comment_start_text'] = $_POST['wc_comment_start_text'];
            $this->optionsSerialized->phrases['wc_comment_join_text'] = $_POST['wc_comment_join_text'];
            $this->optionsSerialized->phrases['wc_email_text'] = $_POST['wc_email_text'];
            $this->optionsSerialized->phrases['wc_name_text'] = $_POST['wc_name_text'];
            $this->optionsSerialized->phrases['wc_website_text'] = $_POST['wc_website_text'];
            $this->optionsSerialized->phrases['wc_captcha_text'] = $_POST['wc_captcha_text'];
            $this->optionsSerialized->phrases['wc_submit_text'] = $_POST['wc_submit_text'];
            $this->optionsSerialized->phrases['wc_notify_of'] = $_POST['wc_notify_of'];
            $this->optionsSerialized->phrases['wc_notify_on_new_comment'] = $_POST['wc_notify_on_new_comment'];
            $this->optionsSerialized->phrases['wc_notify_on_all_new_reply'] = $_POST['wc_notify_on_all_new_reply'];
            $this->optionsSerialized->phrases['wc_notify_on_new_reply'] = $_POST['wc_notify_on_new_reply'];
            $this->optionsSerialized->phrases['wc_sort_by'] = $_POST['wc_sort_by'];
            $this->optionsSerialized->phrases['wc_newest'] = $_POST['wc_newest'];
            $this->optionsSerialized->phrases['wc_oldest'] = $_POST['wc_oldest'];
            $this->optionsSerialized->phrases['wc_most_voted'] = $_POST['wc_most_voted'];
            $this->optionsSerialized->phrases['wc_load_more_submit_text'] = $_POST['wc_load_more_submit_text'];
            $this->optionsSerialized->phrases['wc_load_rest_comments_submit_text'] = $_POST['wc_load_rest_comments_submit_text'];
            $this->optionsSerialized->phrases['wc_reply_text'] = $_POST['wc_reply_text'];
            $this->optionsSerialized->phrases['wc_share_text'] = $_POST['wc_share_text'];
            $this->optionsSerialized->phrases['wc_edit_text'] = $_POST['wc_edit_text'];
            $this->optionsSerialized->phrases['wc_share_facebook'] = $_POST['wc_share_facebook'];
            $this->optionsSerialized->phrases['wc_share_twitter'] = $_POST['wc_share_twitter'];
            $this->optionsSerialized->phrases['wc_share_google'] = $_POST['wc_share_google'];
            $this->optionsSerialized->phrases['wc_share_vk'] = $_POST['wc_share_vk'];
            $this->optionsSerialized->phrases['wc_share_ok'] = $_POST['wc_share_ok'];
            $this->optionsSerialized->phrases['wc_hide_replies_text'] = $_POST['wc_hide_replies_text'];
            $this->optionsSerialized->phrases['wc_show_replies_text'] = $_POST['wc_show_replies_text'];
            $this->optionsSerialized->phrases['wc_user_title_guest_text'] = $_POST['wc_user_title_guest_text'];
            $this->optionsSerialized->phrases['wc_user_title_member_text'] = $_POST['wc_user_title_member_text'];
            $this->optionsSerialized->phrases['wc_user_title_author_text'] = $_POST['wc_user_title_author_text'];
            $this->optionsSerialized->phrases['wc_user_title_admin_text'] = $_POST['wc_user_title_admin_text'];
            $this->optionsSerialized->phrases['wc_email_subject'] = $_POST['wc_email_subject'];
            $this->optionsSerialized->phrases['wc_email_message'] = $_POST['wc_email_message'];
            $this->optionsSerialized->phrases['wc_new_reply_email_subject'] = $_POST['wc_new_reply_email_subject'];
            $this->optionsSerialized->phrases['wc_new_reply_email_message'] = $_POST['wc_new_reply_email_message'];
            $this->optionsSerialized->phrases['wc_subscribed_on_comment'] = $_POST['wc_subscribed_on_comment'];
            $this->optionsSerialized->phrases['wc_subscribed_on_all_comment'] = $_POST['wc_subscribed_on_all_comment'];
            $this->optionsSerialized->phrases['wc_subscribed_on_post'] = $_POST['wc_subscribed_on_post'];
            $this->optionsSerialized->phrases['wc_unsubscribe'] = $_POST['wc_unsubscribe'];
            $this->optionsSerialized->phrases['wc_ignore_subscription'] = $_POST['wc_ignore_subscription'];
            $this->optionsSerialized->phrases['wc_unsubscribe_message'] = $_POST['wc_unsubscribe_message'];
            $this->optionsSerialized->phrases['wc_subscribe_message'] = $_POST['wc_subscribe_message'];
            $this->optionsSerialized->phrases['wc_confirm_email'] = $_POST['wc_confirm_email'];
            $this->optionsSerialized->phrases['wc_comfirm_success_message'] = $_POST['wc_comfirm_success_message'];
            $this->optionsSerialized->phrases['wc_confirm_email_subject'] = $_POST['wc_confirm_email_subject'];
            $this->optionsSerialized->phrases['wc_confirm_email_message'] = $_POST['wc_confirm_email_message'];
            $this->optionsSerialized->phrases['wc_error_empty_text'] = $_POST['wc_error_empty_text'];
            $this->optionsSerialized->phrases['wc_error_email_text'] = $_POST['wc_error_email_text'];
            $this->optionsSerialized->phrases['wc_error_url_text'] = $_POST['wc_error_url_text'];
            $this->optionsSerialized->phrases['wc_year_text']['datetime'][0] = $_POST['wc_year_text'];
            $this->optionsSerialized->phrases['wc_year_text_plural']['datetime'][0] = $_POST['wc_year_text_plural'];
            $this->optionsSerialized->phrases['wc_month_text']['datetime'][0] = $_POST['wc_month_text'];
            $this->optionsSerialized->phrases['wc_month_text_plural']['datetime'][0] = $_POST['wc_month_text_plural'];
            $this->optionsSerialized->phrases['wc_day_text']['datetime'][0] = $_POST['wc_day_text'];
            $this->optionsSerialized->phrases['wc_day_text_plural']['datetime'][0] = $_POST['wc_day_text_plural'];
            $this->optionsSerialized->phrases['wc_hour_text']['datetime'][0] = $_POST['wc_hour_text'];
            $this->optionsSerialized->phrases['wc_hour_text_plural']['datetime'][0] = $_POST['wc_hour_text_plural'];
            $this->optionsSerialized->phrases['wc_minute_text']['datetime'][0] = $_POST['wc_minute_text'];
            $this->optionsSerialized->phrases['wc_minute_text_plural']['datetime'][0] = $_POST['wc_minute_text_plural'];
            $this->optionsSerialized->phrases['wc_second_text']['datetime'][0] = $_POST['wc_second_text'];
            $this->optionsSerialized->phrases['wc_second_text_plural']['datetime'][0] = $_POST['wc_second_text_plural'];
            $this->optionsSerialized->phrases['wc_right_now_text'] = $_POST['wc_right_now_text'];
            $this->optionsSerialized->phrases['wc_ago_text'] = $_POST['wc_ago_text'];
            $this->optionsSerialized->phrases['wc_posted_today_text'] = $_POST['wc_posted_today_text'];
            $this->optionsSerialized->phrases['wc_you_must_be_text'] = $_POST['wc_you_must_be_text'];
            $this->optionsSerialized->phrases['wc_logged_in_as'] = $_POST['wc_logged_in_as'];
            $this->optionsSerialized->phrases['wc_log_out'] = $_POST['wc_log_out'];
            $this->optionsSerialized->phrases['wc_logged_in_text'] = $_POST['wc_logged_in_text'];
            $this->optionsSerialized->phrases['wc_to_post_comment_text'] = $_POST['wc_to_post_comment_text'];
            $this->optionsSerialized->phrases['wc_vote_counted'] = $_POST['wc_vote_counted'];
            $this->optionsSerialized->phrases['wc_vote_up'] = $_POST['wc_vote_up'];
            $this->optionsSerialized->phrases['wc_vote_down'] = $_POST['wc_vote_down'];
            $this->optionsSerialized->phrases['wc_held_for_moderate'] = $_POST['wc_held_for_moderate'];
            $this->optionsSerialized->phrases['wc_vote_only_one_time'] = $_POST['wc_vote_only_one_time'];
            $this->optionsSerialized->phrases['wc_voting_error'] = $_POST['wc_voting_error'];
            $this->optionsSerialized->phrases['wc_self_vote'] = $_POST['wc_self_vote'];
            $this->optionsSerialized->phrases['wc_deny_voting_from_same_ip'] = $_POST['wc_deny_voting_from_same_ip'];
            $this->optionsSerialized->phrases['wc_login_to_vote'] = $_POST['wc_login_to_vote'];
            $this->optionsSerialized->phrases['wc_invalid_captcha'] = $_POST['wc_invalid_captcha'];
            $this->optionsSerialized->phrases['wc_invalid_field'] = $_POST['wc_invalid_field'];
            $this->optionsSerialized->phrases['wc_new_comment_button_text'] = $_POST['wc_new_comment_button_text'];
            $this->optionsSerialized->phrases['wc_new_comments_button_text'] = $_POST['wc_new_comments_button_text'];
            $this->optionsSerialized->phrases['wc_new_reply_button_text'] = $_POST['wc_new_reply_button_text'];
            $this->optionsSerialized->phrases['wc_new_replies_button_text'] = $_POST['wc_new_replies_button_text'];
            $this->optionsSerialized->phrases['wc_new_comments_text'] = $_POST['wc_new_comments_text'];
            $this->optionsSerialized->phrases['wc_comment_not_updated'] = $_POST['wc_comment_not_updated'];
            $this->optionsSerialized->phrases['wc_comment_edit_not_possible'] = $_POST['wc_comment_edit_not_possible'];
            $this->optionsSerialized->phrases['wc_comment_not_edited'] = $_POST['wc_comment_not_edited'];
            $this->optionsSerialized->phrases['wc_comment_edit_save_button'] = $_POST['wc_comment_edit_save_button'];
            $this->optionsSerialized->phrases['wc_comment_edit_cancel_button'] = $_POST['wc_comment_edit_cancel_button'];
            $this->optionsSerialized->phrases['wc_msg_comment_text_min_length'] = $_POST['wc_msg_comment_text_min_length'];
            $this->optionsSerialized->phrases['wc_msg_comment_text_max_length'] = $_POST['wc_msg_comment_text_max_length'];
            $this->optionsSerialized->phrases['wc_msg_required_fields'] = $_POST['wc_msg_required_fields'];
            $this->optionsSerialized->phrases['wc_connect_with'] = $_POST['wc_connect_with'];
            $this->optionsSerialized->phrases['wc_subscribed_to'] = $_POST['wc_subscribed_to'];
            $this->dbManager->updatePhrases($this->optionsSerialized->phrases);
        }
        $this->optionsSerialized->initPhrasesOnLoad();
        ?>
        <div class="wrap wpdiscuz_options_page">
            <div style="float:left; width:50px; height:55px; margin:10px 10px 20px 0px;">
                <img src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/plugin-icon/plugin-icon-48.png'); ?>" style="height:43px;"/>
            </div>
            <h2 style="padding-bottom:20px; padding-top:15px;"><?php _e('WpDiscuz Front-end Phrases', 'wpdiscuz'); ?></h2>
            <br style="clear:both" />
            <form action="<?php echo admin_url(); ?>edit-comments.php?page=wpdiscuz_phrases_page" method="post" name="wpdiscuz_phrases_page" class="wc-phrases-settings-form wc-form">
                <?php
                if (function_exists('wp_nonce_field')) {
                    wp_nonce_field('wc_phrases_form');
                }
                ?>
                <div id="phrasesTab">
                    <ul class="resp-tabs-list phrases_tab_id">
                        <li><?php _e('General', 'wpdiscuz'); ?></li>
                        <li><?php _e('Form', 'wpdiscuz'); ?></li>
                        <li><?php _e('Comment', 'wpdiscuz'); ?></li>
                        <li><?php _e('Date/Time', 'wpdiscuz'); ?></li>
                        <li><?php _e('Email', 'wpdiscuz'); ?></li>
                        <li><?php _e('Notification', 'wpdiscuz'); ?></li>
                    </ul>
                    <div class="resp-tabs-container phrases_tab_id">
                        <?php include 'phrases-layouts/phrases-general.php'; ?>
                        <?php include 'phrases-layouts/phrases-form.php'; ?>
                        <?php include 'phrases-layouts/phrases-comment.php'; ?>
                        <?php include 'phrases-layouts/phrases-datetime.php'; ?>
                        <?php include 'phrases-layouts/phrases-email.php'; ?>
                        <?php include 'phrases-layouts/phrases-notification.php'; ?>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {
                        var width = 0;
                        var phrasesTabsType = 'default';
                        $('#phrasesTab ul.resp-tabs-list.phrases_tab_id li').each(function () {
                            width += $(this).outerWidth(true);
                        });

                        if (width > $('#phrasesTab').innerWidth()) {
                            phrasesTabsType = 'vertical';
                        }
                        $('#phrasesTab').easyResponsiveTabs({
                            type: 'default', //Types: default, vertical, accordion
                            width: 'auto', //auto or any width like 600px
                            fit: true, // 100% fit in a container
                            tabidentify: 'phrases_tab_id' // The tab groups identifier
                        });
                        $(document).delegate('.phrases_tab_id .resp-tab-item', 'click', function () {
                            var activeTabIndex = $('.resp-tabs-list.phrases_tab_id li.resp-tab-active').index();
                            $.cookie('phrasesActiveTabIndex', activeTabIndex, {expires: 30});
                        });
                        var savedIndex = $.cookie('phrasesActiveTabIndex') >= 0 ? $.cookie('phrasesActiveTabIndex') : 0;
                        $('.resp-tabs-list.phrases_tab_id li').removeClass('resp-tab-active');
                        $('.resp-tabs-container.phrases_tab_id > div').removeClass('resp-tab-content-active');
                        $('.resp-tabs-container.phrases_tab_id > div').css('display', 'none');
                        $('.resp-tabs-list.phrases_tab_id li').eq(savedIndex).addClass('resp-tab-active');
                        $('.resp-tabs-container.phrases_tab_id > div').eq(savedIndex).addClass('resp-tab-content-active');
                        $('.resp-tabs-container.phrases_tab_id > div').eq(savedIndex).css('display', 'block');
                    });
                </script>
                <table class="form-table wc-form-table">
                    <tbody>
                        <tr valign="top">
                            <td colspan="4">
                                <p class="submit">
                                    <input type="submit" class="button button-primary" name="wc_submit_phrases" value="<?php _e('Save Changes', 'wpdiscuz'); ?>" />
                                </p>
                            </td>
                        </tr>
                    <input type="hidden" name="action" value="update" />
                    </tbody>
                </table>
            </form>
        </div>
        <?php
    }

    public function initShareButtons() {
        $this->shareButtons[] = 'fb';
        $this->shareButtons[] = 'twitter';
        $this->shareButtons[] = 'google';
        $this->shareButtons[] = 'vk';
        $this->shareButtons[] = 'ok';
    }

}
