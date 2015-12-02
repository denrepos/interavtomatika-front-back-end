<?php

class WpdiscuzTemplateBuilder {

    private $helper;
    private $optimizationHelper;
    private $dbManager;
    private $options;
    private $optionsSerialized;

    function __construct($helper, $optimizationHelper, $dbManager, $options, $optionsSerialized) {
        $this->helper = $helper;
        $this->optimizationHelper = $optimizationHelper;
        $this->dbManager = $dbManager;
        $this->options = $options;
        $this->optionsSerialized = $optionsSerialized;
        add_action('plugins_loaded', array(&$this->optionsSerialized, 'initPhrasesOnLoad'), 2129);
    }

    /**
     * @param type $comment the current comment object
     * @param type $args
     * @return single comment template
     */
    public function getCommentTemplate($comment, $args, $depth) {
        $current_user = $args['current_user'];
        $depth = isset($args['addComment']) ? $args['addComment'] : $depth;
        $commentContent = wp_kses($comment->comment_content, $this->helper->wc_allowed_tags);
        $commentContent = $this->helper->makeClickable($commentContent);
        $commentContent = apply_filters('comment_text', $commentContent, $comment, $args);
        $commentContent .= $comment->comment_approved == 0 ? '<p class="wc_held_for_moderate">' . $this->optionsSerialized->phrases['wc_held_for_moderate'] . '</p>' : '';
        $hideAvatarStyle = $this->optionsSerialized->wordpressShowAvatars ? '' : 'style = "margin-left : 0;"';
        $hideReplyHtml = '';
        $commentWrapperClass = '';
        if ($this->optionsSerialized->wordpressIsPaginate && $comment->comment_parent) {
            $rootComment = $this->optimizationHelper->getCommentRoot($comment->comment_parent);
        }
        if (isset($args['new_loaded_class'])) {
            $commentWrapperClass .= $args['new_loaded_class'] . ' ';
            $depth = 1;
            if ($args['isSingle']) {
                $commentWrapperClass .= ' wpdiscuz_single ';
            } else {
                $depth = $this->optimizationHelper->getCommentDepth($comment->comment_ID);
            }
        }
        $user = get_user_by('id', $comment->user_id);
        $commentAuthorUrl = ('http://' == $comment->comment_author_url) ? '' : $comment->comment_author_url;
        $commentAuthorUrl = esc_url($commentAuthorUrl, array('http', 'https'));
        $commentAuthorUrl = apply_filters('get_comment_author_url', $commentAuthorUrl, $comment->comment_ID, $comment);
        if ($user) {
            $userInfo = get_userdata($comment->user_id);
            $commentAuthorUrl = $commentAuthorUrl ? $commentAuthorUrl : $user->user_url;
            $post = get_post($comment->comment_post_ID);
            if ($user->ID == $post->post_author) {
                $authorClass = 'wc-blog-post_author';
                $author_title = $this->optionsSerialized->phrases['wc_user_title_author_text'];
            } else {
                $authorClass = $userInfo->roles ? 'wc-blog-' . $userInfo->roles[0] : 'wc-blog-member';
                $author_title = $this->optionsSerialized->phrases['wc_user_title_member_text'];
            }
        } else {
            $authorClass = 'wc-blog-guest';
            $author_title = $this->optionsSerialized->phrases['wc_user_title_guest_text'];
        }

        if ($this->optionsSerialized->simpleCommentDate) {
            $dateFormat = $this->optionsSerialized->wordpressDateFormat;
            $timeFormat = $this->optionsSerialized->wordpressTimeFormat;
            if (wpdiscuzHelper::isPostedToday($comment)) {
                $posted_date = $this->optionsSerialized->phrases['wc_posted_today_text'] . ' ' . mysql2date($timeFormat, $comment->comment_date);
            } else {
                $posted_date = get_comment_date($dateFormat . ' ' . $timeFormat, $comment->comment_ID);
            }
        } else {
            $posted_date = $this->helper->dateDiff(time(), strtotime($comment->comment_date_gmt), 2);
        }

        $replyText = $this->optionsSerialized->phrases['wc_reply_text'];
        $shareText = $this->optionsSerialized->phrases['wc_share_text'];
        if (isset($rootComment) && $rootComment->comment_approved != 1) {
            $commentWrapperClass .= 'wc-comment';
        } else {
            $commentWrapperClass .= ($comment->comment_parent && $this->optionsSerialized->wordpressThreadComments) && !$args['isSingle'] ? 'wc-comment wc-reply' : 'wc-comment';
            $hideReplyHtml = '<span  class="wc-toggle" style="display:block;">' . $this->optionsSerialized->phrases['wc_hide_replies_text'] . ' &and;' . '</span>';
        }
        $voteCount = isset($comment->meta_value) ? $comment->meta_value : get_comment_meta($comment->comment_ID, WpdiscuzCore::META_KEY_VOTES, true);
        $unique_id = $comment->comment_ID . '_' . $comment->comment_parent;

        $authorName = $this->getAuthorName($comment);
        $profileUrl = $this->getProfileUrl($user);

        if ($profileUrl) {
            $commentAuthorAvatar = "<a href='$profileUrl'>" . $this->helper->getCommentAuthorAvatar($comment) . "</a>";
        } else {
            $commentAuthorAvatar = $this->helper->getCommentAuthorAvatar($comment);
        }

        if ($commentAuthorUrl) {
            $authorName = "<a rel='nofollow' href='$commentAuthorUrl'>" . $authorName . "</a>";
        } else {
            if ($profileUrl) {
                $authorName = "<a href='$profileUrl'>" . $authorName . "</a>";
            }
        }

        $childCommentsCount = $this->dbManager->getCommentsCountByParentId($comment->comment_ID);

        if (!$this->optionsSerialized->isGuestCanVote && !$current_user->ID) {
            $voteClass = ' wc_tooltipster';
            $voteTitleText = $this->optionsSerialized->phrases['wc_login_to_vote'];
            $voteUp = $voteTitleText;
            $voteDown = $voteTitleText;
        } else {
            $voteClass = ' wc_vote wc_tooltipster';
            $voteUp = $this->optionsSerialized->phrases['wc_vote_up'];
            $voteDown = $this->optionsSerialized->phrases['wc_vote_down'];
        }

        $commentContentClass = '';
        $output = '<div id="wc-comm-' . $unique_id . '" class="' . $commentWrapperClass . ' ' . $authorClass . ' wc_comment_level-' . $depth . '">';
        if ($this->optionsSerialized->wordpressShowAvatars) {
            $output .= '<div class="wc-comment-left">' . $commentAuthorAvatar;
            if (!$this->optionsSerialized->authorTitlesShowHide) {
                $output .= '<div class="' . $authorClass . ' wc-comment-label">' . $author_title . '</div>';
            }
            if (class_exists('userpro_api') && $comment->user_id) {
                $output .= userpro_show_badges($comment->user_id, $inline = true);
            }
            $wpdiscuzAfterLabelHtml ='';
            $wpdiscuzAfterLabelData = apply_filters('wpdiscuz_after_label',array($wpdiscuzAfterLabelHtml,$comment));
            $output .= $wpdiscuzAfterLabelData[0];
            $output .= '</div>';
        }
        $commentLink = get_comment_link($comment);
        $output .= '<div id="comment-' . $comment->comment_ID . '" class="wc-comment-right ' . $commentContentClass . '" ' . $hideAvatarStyle . '>';
        $output .= '<div class="wc-comment-header"><div class="wc-comment-author">' . $authorName . '</div>';
        if (!$this->optionsSerialized->showHideCommentLink) {
            $output .= '<div class="wc-comment-link"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/icon-link.gif') . '" class="wc-comment-img-link" title="&lt;input type=&quot;text&quot; class=&quot;wc-comment-link-input&quot; value=&quot;' . $commentLink . '&quot; /&gt;" /></div>';
        }
        $output .= '<div class="wc-comment-date">' . $posted_date . '</div><div style="clear:right"></div></div>';
        $output .= '<div class="wc-comment-text">' . $commentContent . '</div>';
        if ($comment->comment_approved == '1') {
            $output .= '<div class="wc-comment-footer">';
            if (!$this->optionsSerialized->votingButtonsShowHide) {
                $output .= '<div  class="wc-vote-result">' . $voteCount . '</div>';
                $output .= ' <span  class="wc-vote-link wc-up ' . $voteClass . '" title="' . $voteUp . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/thumbs-up.png') . '"  align="absmiddle" class="wc-vote-img-up" /></span> &nbsp;|&nbsp; <span class="wc-vote-link wc-down ' . $voteClass . '" title="' . $voteDown . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/thumbs-down.png') . '"  align="absmiddle" class="wc-vote-img-down" /></span>&nbsp;';
            }

            if (comments_open($comment->comment_post_ID) && $this->optionsSerialized->wordpressThreadComments) {
                if ($this->optionsSerialized->wordpressCommentRegistration) {
                    if (!$this->optionsSerialized->replyButtonMembersShowHide && $current_user->ID) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    } else if (in_array('administrator', $current_user->roles)) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    }
                } else {
                    if (!$this->optionsSerialized->replyButtonMembersShowHide && !$this->optionsSerialized->replyButtonGuestsShowHide) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    } else if (!$this->optionsSerialized->replyButtonMembersShowHide && $current_user->ID) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    } else if (!$this->optionsSerialized->replyButtonGuestsShowHide && !$current_user->ID) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    } else if (in_array('administrator', $current_user->roles)) {
                        $output .= '&nbsp;&nbsp;<span  class="wc-reply-link" title="' . $replyText . '">' . $replyText . '</span> &nbsp;&nbsp;';
                    }
                }
            }

            if ($this->optionsSerialized->shareButtons) {
                $output .= '-&nbsp;&nbsp; <span  class="wc-share-link" title="' . $shareText . '">' . $shareText . '</span> &nbsp;&nbsp;';

                $twitt_content = strip_tags($commentContent) . ' ' . $commentLink;

                $output .= '<span class="share_buttons_box">';
                $output .= in_array('fb', $this->optionsSerialized->shareButtons) ? '<a target="_blank" href="http://www.facebook.com/sharer.php" title="' . $this->optionsSerialized->phrases['wc_share_facebook'] . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/fb-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/fb-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/fb-18x18.png') . '\'"/></a>&nbsp;&nbsp;' : '';
                $output .= in_array('twitter', $this->optionsSerialized->shareButtons) ? '<a target="_blank" href="https://twitter.com/home?status=' . $twitt_content . '" title="' . $this->optionsSerialized->phrases['wc_share_twitter'] . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/twitter-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/twitter-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/twitter-18x18.png') . '\'"/></a>&nbsp;&nbsp;' : '';
                $output .= in_array('google', $this->optionsSerialized->shareButtons) ? '<a target="_blank" href="https://plus.google.com/share?url=' . get_permalink($comment->comment_post_ID) . '" title="' . $this->optionsSerialized->phrases['wc_share_google'] . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/google-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/google-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/google-18x18.png') . '\'"/></a>&nbsp;&nbsp;' : '';
                $output .= in_array('vk', $this->optionsSerialized->shareButtons) ? '<a target="_blank" href="http://vk.com/share.php?url=' . get_permalink($comment->comment_post_ID) . '" title="' . $this->optionsSerialized->phrases['wc_share_vk'] . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/vk-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/vk-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/vk-18x18.png') . '\'"/></a>&nbsp;&nbsp;' : '';
                $output .= in_array('ok', $this->optionsSerialized->shareButtons) ? '<a target="_blank" href="http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' . get_permalink($comment->comment_post_ID) . '" title="' . $this->optionsSerialized->phrases['wc_share_ok'] . '"><img src="' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/ok-18x18.png') . '" onmouseover="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/ok-18x18-orig.png') . '\'" onmouseout="this.src=\'' . plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . '/assets/img/social-icons/ok-18x18.png') . '\'"/></a>&nbsp;&nbsp;' : '';
                $output .= '</span>';
            }

            if (current_user_can('edit_comment', $comment->comment_ID)) {
                $output .= '-&nbsp;&nbsp; <a href="' . get_edit_comment_link($comment->comment_ID) . '">' . __('Edit', 'default') . '</a>';
            } else {
                $isEditable = $this->optionsSerialized->commentEditableTime == 'unlimit' ? true : $this->helper->isCommentEditable($comment);
                if ($current_user->ID && $current_user->ID == $comment->user_id && $isEditable) {
                    $output .= '<span class="wc_editable_comment">-&nbsp;&nbsp;' . $this->optionsSerialized->phrases['wc_edit_text'] . '</span>';
                    $output .= '<span  class="wc_cancel_edit">-&nbsp;&nbsp;' . $this->optionsSerialized->phrases['wc_comment_edit_cancel_button'] . '</span>';
                    $output .= '<span  class="wc_save_edited_comment" style="display:none;">&nbsp;&nbsp;-&nbsp;&nbsp;' . $this->optionsSerialized->phrases['wc_comment_edit_save_button'] . '</span>';
                }
            }

            if ($childCommentsCount && $depth < $this->optionsSerialized->wordpressThreadCommentsDepth && $this->optionsSerialized->wordpressThreadComments) {
                $output .= $hideReplyHtml;
            }
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '<div class="wpdiscuz-comment-message"></div>';
        $output .= '<div id="wpdiscuz_form_anchor-' . $unique_id . '"  style="clear:both"></div>';
        return $output;
    }

    /**
     *
     * get profile url
     */
    private function getProfileUrl($user) {
        $wc_profile_url = '';
        $wc_profile_url_filter = '';
        if ($user) {
            if (class_exists('BuddyPress')) {
                $wc_profile_url = bp_core_get_user_domain($user->ID);
            } else if (class_exists('XooUserUltra')) {
                global $xoouserultra;
                $wc_profile_url = $xoouserultra->userpanel->get_user_profile_permalink($user->ID);
            } else if (class_exists('userpro_api')) {
                global $userpro;
                $wc_profile_url = $userpro->permalink($user->ID);
            } else if (class_exists('UM_API')) {
                um_fetch_user($user->ID);
                $wc_profile_url = um_user_profile_url();
            } else {
                if (count_user_posts($user->ID)) {
                    $wc_profile_url = get_author_posts_url($user->ID);
                }
            }
            $user_id = $user->ID;
            $wc_profile_url_data = apply_filters('wpdiscuz_profile_url', array('user_id' => $user_id, 'permalink' => ''));

            $wc_profile_url_filter = $wc_profile_url_data['permalink'];
        }

        return $wc_profile_url_filter ? $wc_profile_url_filter : $wc_profile_url;
    }

    public function getAuthorName($comment) {
        if (class_exists('UM_API') && isset($comment->user_id) && $comment->user_id) {
            um_fetch_user($comment->user_id);
            $author_name = um_user('display_name');
            um_reset_user();
        } else if (isset($comment->user_id) && $comment->user_id) {
            $author_name = get_the_author_meta('display_name', $comment->user_id);
            $author_name = $author_name ? $author_name : get_the_author_meta('user_nicename', $comment->user_id);
        } else {
            $author_name = $comment->comment_author ? $comment->comment_author : __('Anonymous', 'wpdiscuz');
        }
        return $author_name;
    }

}
