<?php

class WpdiscuzHelper {

    public static $datetime = 'datetime';
    public static $year = 'wc_year_text';
    public static $years = 'wc_year_text_plural';
    public static $month = 'wc_month_text';
    public static $months = 'wc_month_text_plural';
    public static $day = 'wc_day_text';
    public static $days = 'wc_day_text_plural';
    public static $hour = 'wc_hour_text';
    public static $hours = 'wc_hour_text_plural';
    public static $minute = 'wc_minute_text';
    public static $minutes = 'wc_minute_text_plural';
    public static $second = 'wc_second_text';
    public static $seconds = 'wc_second_text_plural';
    private $optionsSerialized;
    private $dbManager;
    public $wcFormAvatar;
    public $wc_allowed_tags = array(
        'br' => array(),
        'a' => array('href' => array(), 'title' => array(), 'target' => array(), 'rel' => array(), 'download' => array(), 'hreflang' => array(), 'media' => array(), 'type' => array()),
        'i' => array(),
        'b' => array(),
        'u' => array(),
        'strong' => array(),
        's' => array(),
        'p' => array('class' => array()),
        'img' => array('src' => array(), 'width' => array(), 'height' => array(), 'alt' => array()),
        'blockquote' => array('cite' => array()),
        'ul' => array(),
        'li' => array(),
        'ol' => array(),
        'code' => array(),
        'em' => array(),
        'abbr' => array('title' => array()),
        'q' => array('cite' => array()),
        'acronym' => array('title' => array()),
        'cite' => array(),
        'strike' => array(),
        'del' => array('datetime' => array()),
    );
    public $captchaDir;
    public $captchaString;

    function __construct($wpdiscuzOptionsSerialized, $dbManager) {
        $this->optionsSerialized = $wpdiscuzOptionsSerialized;
        $this->dbManager = $dbManager;
        $this->captchaDir = DIR_PATH . WPD_DS . 'utils' . WPD_DS . 'temp';
    }

// Set timezone
// Time format is UNIX timestamp or
// PHP strtotime compatible strings
    public function dateDiff($time1, $time2, $precision = 2) {

// If not numeric then convert texts to unix timestamps
        if (!is_int($time1)) {
            $time1 = strtotime($time1);
        }
        if (!is_int($time2)) {
            $time2 = strtotime($time2);
        }

// If time1 is bigger than time2
// Then swap time1 and time2
        if ($time1 > $time2) {
            $ttime = $time1;
            $time1 = $time2;
            $time2 = $ttime;
        }

// Set up intervals and diffs arrays
        $intervals = array(
            $this->optionsSerialized->phrases['wc_year_text']['datetime'][1],
            $this->optionsSerialized->phrases['wc_month_text']['datetime'][1],
            $this->optionsSerialized->phrases['wc_day_text']['datetime'][1],
            $this->optionsSerialized->phrases['wc_hour_text']['datetime'][1],
            $this->optionsSerialized->phrases['wc_minute_text']['datetime'][1],
            $this->optionsSerialized->phrases['wc_second_text']['datetime'][1]
        );
        $diffs = array();
//        exit('ddddd');
// Loop thru all intervals
        foreach ($intervals as $interval) {
// Create temp time from time1 and interval
            $interval = $this->dateComparisionByIndex($interval);
            $ttime = strtotime('+1 ' . $interval, $time1);
// Set initial values
            $add = 1;
            $looped = 0;
// Loop until temp time is smaller than time2
            while ($time2 >= $ttime) {
// Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime("+" . $add . " " . $interval, $time1);
                $looped++;
            }

            $time1 = strtotime("+" . $looped . " " . $interval, $time1);
            $diffs[$interval] = $looped;
        }

        $count = 0;
        $times = array();
// Loop thru all diffs
        foreach ($diffs as $interval => $value) {
            $interval = $this->dateTextByIndex($interval, $value);
// Break if we have needed precission
            if ($count >= $precision) {
                break;
            }
// Add value and interval
// if value is bigger than 0
            if ($value > 0) {
// Add value and interval to times array
                $times[] = $value . " " . $interval;
                $count++;
            }
        }

// Return string with times
        $ago = ($times) ? $this->optionsSerialized->phrases['wc_ago_text'] : $this->optionsSerialized->phrases['wc_right_now_text'];
        return implode(" ", $times) . ' ' . $ago;
    }

    /**
     * get comment author avatar if exists otherwise default avatar
     */
    public function getCommentAuthorAvatar($comment = null, $current_user = null) {
        if (function_exists('the_champ_init') && get_user_meta($current_user->ID, 'thechamp_avatar') && is_null($comment)) {
            $comment = (object) array('user_id' => $current_user->ID, 'comment_author_email' => $current_user->user_email, 'comment_type' => '');
        } elseif (!$comment) {
            $comment = $current_user->user_email;
        }
        $comm_auth_avatar = get_avatar($comment, 48);
        if (!$this->wcFormAvatar) {
            $this->wcFormAvatar = $comm_auth_avatar;
        }
        return $comm_auth_avatar;
    }

    public static function initPhraseKeyValue($phrase) {
        $phrase_value = stripslashes($phrase['phrase_value']);
        switch ($phrase['phrase_key']) {
            case WpdiscuzHelper::$year:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 1));
            case WpdiscuzHelper::$years:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 1));
            case WpdiscuzHelper::$month:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 2));
            case WpdiscuzHelper::$months:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 2));
            case WpdiscuzHelper::$day:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 3));
            case WpdiscuzHelper::$days:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 3));
            case WpdiscuzHelper::$hour:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 4));
            case WpdiscuzHelper::$hours:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 4));
            case WpdiscuzHelper::$minute:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 5));
            case WpdiscuzHelper::$minutes:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 5));
            case WpdiscuzHelper::$second:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 6));
            case WpdiscuzHelper::$seconds:
                return array(WpdiscuzHelper::$datetime => array($phrase_value, 6));
            default :
                return $phrase_value;
        }
    }

    private function dateComparisionByIndex($index) {
        switch ($index) {
            case 1:
                return 'year';
            case 2:
                return 'month';
            case 3:
                return 'day';
            case 4:
                return 'hour';
            case 5:
                return 'minute';
            case 6:
                return 'second';
        }
    }

    private function dateTextByIndex($index, $value) {
        switch ($index) {
            case 'year':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_year_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_year_text']['datetime'][0];
            case 'month':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_month_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_month_text']['datetime'][0];
            case 'day':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_day_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_day_text']['datetime'][0];
            case 'hour':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_hour_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_hour_text']['datetime'][0];
            case 'minute':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_minute_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_minute_text']['datetime'][0];
            case 'second':
                return ($value > 1) ? $this->optionsSerialized->phrases['wc_second_text_plural']['datetime'][0] : $this->optionsSerialized->phrases['wc_second_text']['datetime'][0];
        }
    }

    public static function getArray($array) {
        $new_array = array();
        foreach ($array as $value) {
            $new_array[] = $value[0];
        }
        return $new_array;
    }

    public function makeUrlClickable($matches) {
        $ret = '';
        $url = $matches[2];

        if (empty($url))
            return $matches[0];
// removed trailing [.,;:] from URL
        if (in_array(substr($url, -1), array('.', ',', ';', ':')) === true) {
            $ret = substr($url, -1);
            $url = substr($url, 0, strlen($url) - 1);
        }
        return $matches[1] . "<a href=\"$url\" rel=\"nofollow\">$url</a>" . $ret;
    }

    public function makeWebFtpClickable($matches) {
        $ret = '';
        $dest = $matches[2];
        $dest = 'http://' . $dest;

        if (empty($dest)) {
            return $matches[0];
        }
        if (in_array(substr($dest, -1), array('.', ',', ';', ':')) === true) {
            $ret = substr($dest, -1);
            $dest = substr($dest, 0, strlen($dest) - 1);
        }
        return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$dest</a>" . $ret;
    }

    public function makeEmailClickable($matches) {
        $email = $matches[2] . '@' . $matches[3];
        return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
    }

    public function makeClickable($ret) {
        $ret = ' ' . $ret;
        $ret = preg_replace('#[^\"|\'](https?:\/\/[^\s]+(\.jpe?g|\.png|\.gif|\.bmp))#i', '<a href="$1"><img src="$1" /></a>', $ret);
// in testing, using arrays here was found to be faster
        $ret = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array(&$this, 'makeUrlClickable'), $ret);
        $ret = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', array(&$this, 'makeWebFtpClickable'), $ret);
        $ret = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i', array(&$this, 'makeEmailClickable'), $ret);
// this one is not in an array because we need it to run last, for cleanup of accidental links within links
        $ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
        $ret = trim($ret);
        return $ret;
    }

    /**
     * check if comment has been posted today or not
     * return boolean
     */
    public static function isPostedToday($comment) {
        return date('Ymd', strtotime(current_time('Ymd'))) <= date('Ymd', strtotime($comment->comment_date));
    }

    /**
     * check if comment is still editable or not
     * return boolean
     */
    public function isCommentEditable($comment) {
        $wc_editable_comment_time = isset($this->optionsSerialized->commentEditableTime) ? $this->optionsSerialized->commentEditableTime : 0;
        return $wc_editable_comment_time && ((time() - strtotime($comment->comment_date_gmt)) < intval($wc_editable_comment_time));
    }

    /**
     * return client real ip
     */
    public function getRealIPAddr() {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    private function isGuestCanComment($isUserLoggedIn) {
        $user_can_comment = TRUE;
        if (get_option('comment_registration')) {
            if (!$isUserLoggedIn) {
                $user_can_comment = FALSE;
            }
        }
        return $user_can_comment;
    }

    public function formBuilder($isMain, $uniqueId, $commentsCount, $current_user) {
        global $post;

        $wc_is_name_field_required = ($this->optionsSerialized->isNameFieldRequired) ? 'required="required"' : '';
        $wc_is_email_field_required = ($this->optionsSerialized->isEmailFieldRequired) ? 'required="required"' : '';

        if (!$isMain || $commentsCount) {
            $textarea_placeholder = $this->optionsSerialized->phrases['wc_comment_join_text'];
        } else {
            $textarea_placeholder = $this->optionsSerialized->phrases['wc_comment_start_text'];
        }
        $validateCommentlength = (intval($this->optionsSerialized->commentTextMinLength) && intval($this->optionsSerialized->commentTextMaxLength)) ? 'data-validate-length-range="' . $this->optionsSerialized->commentTextMinLength . ',' . $this->optionsSerialized->commentTextMaxLength . '"' : '';
        ?>
        <div class="wc-form-wrapper <?php echo!$isMain ? 'wc-secondary-form-wrapper' : 'wc-main-form-wrapper'; ?>"  <?php echo!$isMain ? "id='wc-secondary-form-wrapper-$uniqueId'  style='display: none;'" : "id='wc-main-form-wrapper-$uniqueId'"; ?> >
            <div class="wpdiscuz-comment-message" style="display: block;"></div>
            <?php if (!$isMain) { ?>
                <div class="wc-secondary-forms-social-content"></div>
            <?php } ?>
            <?php
            if ($this->isGuestCanComment($current_user->ID)) {
                ?>
                <form class="wc_comm_form <?php echo!$isMain ? 'wc-secondary-form-wrapper' : 'wc_main_comm_form'; ?>" method="post" action="">
                    <div class="wc-field-comment">

                        <?php if ($this->optionsSerialized->wordpressShowAvatars) { ?>
                            <div class="wc-field-avatararea">
                                <?php echo $this->getCommentAuthorAvatar(null, $current_user); ?>
                            </div>
                        <?php } ?>
                        <div class="wpdiscuz-item wc-field-textarea" <?php
                        if (!$this->optionsSerialized->wordpressShowAvatars) {
                            echo ' style="margin-left: 0;"';
                        }
                        ?>>
                            <textarea <?php echo $validateCommentlength; ?> placeholder="<?php echo $textarea_placeholder; ?>" required="required" name="wc_comment" class="wc_comment wc_field_input"></textarea>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <div class="wc-form-footer"  style="display: none;">
                        <?php if (!$current_user->ID) { ?>
                            <div class="wc-author-data">
                                <div class="wc-field-name wpdiscuz-item">
                                    <input type="text" placeholder="<?php echo $this->optionsSerialized->phrases['wc_name_text']; ?>" value=""  <?php echo $wc_is_name_field_required; ?> name="wc_name" class="wc_name wc_field_input" >
                                </div>
                                <div class="wc-field-email wpdiscuz-item">
                                    <input type="email" placeholder="<?php echo $this->optionsSerialized->phrases['wc_email_text']; ?>" value="" <?php echo $wc_is_email_field_required; ?> name="wc_email"  class="wc_email wc_field_input email">
                                </div>
                                <div style="clear:both"></div>
                            </div>
                        <?php } ?>
                        <div class="wc-form-submit">
                            <?php
                            // generate captcha for secondary form on clone if img path not exists
                            if ($this->isShowCaptcha($current_user->ID)) {
                                ?>
                                <div class="wc-field-captcha wpdiscuz-item">
                                    <input type="text" maxlength="5" value="" required="required" name="wc_captcha"  class="wc_field_input wc_field_captcha">
                                    <span class="wc-label wc-captcha-label">
                                        <?php
                                        $captchaData = $this->createCaptchaImage();
                                        $captchaFile = $captchaData['captcha'];
                                        $key = $captchaData['key'];
                                        $captchaFile = $captchaFile ? plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . WPD_DS . 'utils' . WPD_DS . 'temp' . WPD_DS . $captchaFile) : '';
                                        ?>
                                        <a class="wpdiscuz-nofollow" href="#" rel="nofollow">                                            
                                            <img class="wc_captcha_img" src="<?php echo $captchaFile; ?>">
                                        </a>
                                        <a class="wpdiscuz-nofollow wc_captcha_refresh_img" href="#" rel="nofollow">
                                            <img class="" alt="<?php _e('Error', 'wpdiscuz'); ?>" src="<?php echo plugins_url(WpdiscuzCore::$PLUGIN_DIRECTORY . WPD_DS . 'assets' . WPD_DS . 'img' . WPD_DS . 'captcha-loading.png'); ?>">
                                        </a>
                                        <input type="hidden" id="<?php echo $key; ?>" class="wpdiscuz-cnonce" name="cnonce" value="<?php echo $key; ?>" />
                                    </span>
                                    <span class="captcha_msg"><?php echo $this->optionsSerialized->phrases['wc_captcha_text']; ?></span>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="wc-field-submit">
                                <?php if (!$current_user->ID && $this->optionsSerialized->weburlShowHide) { ?>
                                    <div class="wc-field-website wpdiscuz-item">
                                        <input type="url" placeholder="<?php echo $this->optionsSerialized->phrases['wc_website_text']; ?>" value="" name="wc_website" class="wc_website wc_field_input">
                                    </div>
                                <?php } ?>
                                <?php if ($this->optionsSerialized->wordpressThreadComments || class_exists('Prompt_Comment_Form_Handling')) { ?>
                                    <div class="wc_notification_checkboxes" style="display:block">
                                        <?php
                                        if (class_exists('Prompt_Comment_Form_Handling') && $this->optionsSerialized->usePostmaticForCommentNotification) {
                                            ?>
                                            <input id="wc_notification_new_comment-<?php echo $uniqueId; ?>" class="wc_notification_new_comment-<?php echo $uniqueId; ?>" value="post"  type="checkbox" name="wpdiscuz_notification_type"/> <label class="wc-label-comment-notify" for="wc_notification_new_comment-<?php echo $uniqueId; ?>"><?php _e('Participate in this discussion via email', 'wpdiscuz'); ?></label><br />
                                            <?php
                                        } elseif ($this->optionsSerialized->showHideReplyCheckbox) {
                                            $wpdiscuz_subscription_type = '';
                                            if ($current_user->ID) {
                                                $wpdiscuz_subscription_type = $this->dbManager->hasSubscription($post->ID, $current_user->user_email);
                                            }
                                            if (!$wpdiscuz_subscription_type) {
                                                ?>
                                                <input id="wc_notification_new_comment-<?php echo $uniqueId; ?>" class="wc_notification_new_comment-<?php echo $uniqueId; ?>" value="comment"  type="checkbox" name="wpdiscuz_notification_type"/> <label class="wc-label-comment-notify" for="wc_notification_new_comment-<?php echo $uniqueId; ?>"><?php echo $this->optionsSerialized->phrases['wc_notify_on_new_reply']; ?></label><br />
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                <?php } ?>
                                <input type="button" class="wc_comm_submit button alt"  value="<?php echo $this->optionsSerialized->phrases['wc_submit_text']; ?>" name="submit">
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                    <?php wp_nonce_field(WpDiscuzConstants::ACTION_FORM_NONCE, 'wpdiscuz_comment_form_nonce'); ?>
                    <input type="hidden"  value="<?php echo $uniqueId; ?>" name="wpdiscuz_unique_id">
                </form>
            <?php } else { ?>
                <p class="wc-must-login">
                    <?php
                    echo $this->optionsSerialized->phrases['wc_you_must_be_text'];
                    $login = wp_loginout(get_permalink(), false);
                    $login = preg_replace('!>([^<]+)!is', '>' . $this->optionsSerialized->phrases['wc_logged_in_text'], $login);
                    echo ' ' . $login . ' ' . $this->optionsSerialized->phrases['wc_to_post_comment_text'];
                    ?>
                </p>
                <?php
            }
            ?>
        </div>
        <?php
    }

    public function getUIDData($uid) {
        $id_strings = explode('_', $uid);
        return $id_strings;
    }

    public function isShowLoadMore($parentId, $args) {
        $postId = $args['post_id'];
        $postAllParent = $this->dbManager->getAllParentCommentCount($postId, $this->optionsSerialized->wordpressThreadComments);
        $showLoadeMore = false;
        if ($postAllParent) {
            if ($args['orderby'] == 'comment_date_gmt') {
                if ($args['order'] == 'desc' && $parentId) {
                    $minId = min($postAllParent);
                    $showLoadeMore = $minId < $parentId;
                } else {
                    $maxId = max($postAllParent);
                    $showLoadeMore = $maxId > $parentId;
                }
                $showLoadeMore = $showLoadeMore && $this->optionsSerialized->wordpressCommentPerPage && (count($postAllParent) > $this->optionsSerialized->wordpressCommentPerPage);
            } else {
                if ($this->optionsSerialized->commentListLoadType == 1 && $args['limit'] == 0) {
                    $showLoadeMore = false;
                } else {
                    $showLoadeMore = $args['offset'] + $this->optionsSerialized->wordpressCommentPerPage < count($postAllParent);
                }
            }
        }
        return $showLoadeMore;
    }

    public function superSocializerFix() {
        if (function_exists('the_champ_login_button')) {
            ?>
            <div id="comments" style="width: 0;height: 0;clear: both;margin: 0;padding: 0;"></div>
            <div id="respond" class="comments-area">
            <?php } else { ?>
                <div id="comments" class="comments-area">
                    <div id="respond" style="width: 0;height: 0;clear: both;margin: 0;padding: 0;"></div>
                    <?php
                }
            }

            public function generateCaptcha() {
                $messageArray = array();
                if (isset($_POST['wpdiscuzAjaxData'])) {
                    parse_str($_POST['wpdiscuzAjaxData']);
                    $uniqueId = trim($uniqueId);
                    $captchaData = $this->createCaptchaImage();
                    $messageArray['code'] = 1;
                    $messageArray['message'] = $captchaData['captcha'];
                    $messageArray['key'] = $captchaData['key'];
                    wp_die(json_encode($messageArray));
                }
            }

            private function getMicrotime() {
                list($usec, $sec) = explode(" ", microtime());
                return ((float) $usec + (float) $sec);
            }

            public function createCaptchaImage() {
                if (!$this->createTempDir()) {
                    return '';
                }

                if (defined('DISABLE_WP_CRON') && DISABLE_WP_CRON == true) {
                    $this->removeOldFiles();
                }

                $t = time();
                $captchaData = array();
                $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $randomString = '';
                $prefix = '';
                for ($i = 0; $i < WpdiscuzCore::CAPTCHA_LENGTH; $i++) {
                    $randomString .= $chars[rand(0, strlen($chars) - 1)];
                    $prefix .= $chars[rand(0, strlen($chars) - 1)];
                }
                $this->captchaString = $randomString;
                $filesPath = plugin_dir_path(__FILE__) . WPD_DS . 'captcha' . WPD_DS;
                $im = @imagecreatefrompng($filesPath . 'captcha_bg_easy.png');
                $fontPath = $filesPath . 'consolai.ttf';

                $size = 16;
                $angle = 0;
                $x = 5;
                $y = 20;
                for ($i = 0; $i < strlen($randomString); $i++) {
                    $color = imagecolorallocate($im, rand(0, 255), 0, rand(0, 255));
                    $letter = substr($randomString, $i, 1);
                    imagettftext($im, $size, $angle, $x, $y, $color, $fontPath, $letter);
                    $x += 13;
                }

                for ($i = 0; $i < 5; $i++) {
                    $color = imagecolorallocate($im, rand(0, 255), rand(0, 200), rand(0, 255));
                    imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
                }
                $fileName = $prefix . '-' . $t . '.png';
                $filePath = $this->captchaDir . WPD_DS . $fileName;
                imagepng($im, $filePath, 0);
                imagedestroy($im);
                @chmod($filePath, 0444);
                $key = $this->createAnswer($prefix, $t);
                $captchaData['captcha'] = $fileName;
                $captchaData['key'] = $prefix . $key;
                return $captchaData;
            }

            private function createAnswer($prefix, $t) {
                $key = '';
                $dir = trailingslashit($this->captchaDir);
                $answerFileName = $prefix . '-' . $t . '.txt';
                $answerFile = $dir . WPD_DS . $answerFileName;

                if ($fh = @fopen($answerFile, 'w')) {
                    $loweredString = strtolower($this->captchaString);
                    $key = hash_hmac('sha256', $loweredString, time() . '');
                    $hash = hash_hmac('sha256', $loweredString, $key);
                    fwrite($fh, $key . '=' . $hash);
                    fclose($fh);
                }
                @chmod($answerFile, 0440);
                return $key;
            }

            public function checkCaptcha($key, $fileName, $captcha) {
                if (!$key || !$fileName || !$captcha) {
                    return false;
                }
                $captcha = strtolower($captcha);
                $file = $fileName . '.txt';
                $filePath = $this->captchaDir . WPD_DS . $file;
                $parts = explode('=', file_get_contents($filePath));
                $tKey = $parts[0];
                $tAnswer = $parts[1];
                return is_readable($filePath) && $tKey == $key && hash_hmac('sha256', $captcha, $key) == $tAnswer;
            }

            public function scheduleTask() {
                $timestamp = wp_next_scheduled('wpdiscuzRemoveOldFiles');
                if ($timestamp == false) {
                    wp_schedule_event(time(), 'hourly', 'wpdiscuzRemoveOldFiles');
                }
            }

            public function unScheduleTask() {
                wp_clear_scheduled_hook('wpdiscuzRemoveOldFiles');
                if ($this->captchaDir && @chmod($this->captchaDir, 0777)) {
                    if (!unlink($this->captchaDir)) {
                        $this->removeOldFiles();
                    }
                }
            }

            public function removeOldFiles() {
                $files = scandir($this->captchaDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && $file != '.htaccess') {
                        $fileName = $this->captchaDir . WPD_DS . $file;
                        $fData = stat($fileName);
                        if (is_file($fileName) && $fData) {
                            $expired = $fData['mtime'] + (60 * 60 + 1000);
                            if ($expired < time() && @chmod($fileName, 0777)) {
                                if (!unlink($fileName)) {
                                    @chmod($fileName, 0440);
                                }
                            }
                        }
                    }
                }
            }

            public function createTempDir() {
                if (!wp_mkdir_p($this->captchaDir)) {
                    return false;
                }

                $htaccessFile = $this->captchaDir . WPD_DS . '.htaccess';
                if (file_exists($htaccessFile)) {
                    return true;
                }

                if ($handle = @fopen($htaccessFile, 'w')) {
                    fwrite($handle, 'Order deny,allow' . "\n");
                    fwrite($handle, 'Deny from all' . "\n");
                    fwrite($handle, '<Files ~ "^[0-9A-Za-z_\\-]+\\.(png)$">' . "\n");
                    fwrite($handle, '    Allow from all' . "\n");
                    fwrite($handle, '</Files>' . "\n");
                    fclose($handle);
                }
                return true;
            }

            /**
             * check if the captcha field show or not
             * @return type boolean 
             */
            public function isShowCaptcha($isUserLoggedIn) {
                return ($isUserLoggedIn && $this->optionsSerialized->captchaShowHideForMembers) || (!$isUserLoggedIn && !$this->optionsSerialized->captchaShowHide);
            }

        }
        