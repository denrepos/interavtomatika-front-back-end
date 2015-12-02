<?php

class WpdiscuzOptimizationHelper {

    private $isCommentInMeta;
    private $subComments;
    private $optionsSerialized;
    private $dbManager;
    private $emailHelper;

    public function __construct($optionsSerialized, $dbManager, $emailHelper) {
        $this->optionsSerialized = $optionsSerialized;
        $this->dbManager = $dbManager;
        $this->emailHelper = $emailHelper;
    }

    public function setSubComment($commentId) {
        $childCommentIds = array();
        $this->getCommentsTree(array($commentId), $childCommentIds);
        $childCommentIdsString = implode(',', $childCommentIds);
        if ($childCommentIdsString) {
            $childCommentIdsString .=',';
        }
        update_comment_meta($commentId, WpdiscuzCore::META_KEY_CHILDREN, $childCommentIdsString);
        return $childCommentIds;
    }

    /**
     * recursively get new comments tree
     */
    public function getCommentsTree($wc_parent_comments, &$wc_child_comments) {
        if (!$wc_parent_comments) {
            return $wc_child_comments;
        }
        $child_comments = array();
        foreach ($wc_parent_comments as $parent_comment) {
            $child_comments = $this->dbManager->getCommentsByParentId($parent_comment);
            foreach ($child_comments as $child_comment) {
                if (!$this->hasComment($wc_child_comments, $child_comment)) {
                    $wc_child_comments[] = $child_comment;
                }
            }
            if ($child_comments) {
                $this->getCommentsTree($child_comments, $wc_child_comments);
            }
        }
        return $this->getCommentsTree($child_comments, $wc_child_comments);
    }

    private function hasComment($comments, $comment) {
        foreach ($comments as $c) {
            if ($c == $comment) {
                return true;
            }
        }
        return false;
    }

    /**
     * get list of comments by parent ids
     * @param type $comment_ids the parent comment ids
     * @return type list of comments
     */
    public function getCommentListByParentIds($comment_ids) {
        $comments = array();
        foreach ($comment_ids as $comment_id) {
            $children = $this->dbManager->getCommentMeta($comment_id, WpdiscuzCore::META_KEY_CHILDREN);
            if (!$children) {
                $children = $this->setSubComment($comment_id);
                $comments = array_merge($comments, $children);
            } elseif ($children && $children->meta_value) {
                $children = array_filter(explode(',', $children->meta_value));
                $comments = array_merge($comments, $children);
            }
        }
        return $comments;
    }

    /**
     * add new insertd commnt id in _commentmeta
     * @param type $id the current comment id
     * @param type $comment the current comment object
     */
    public function addCommentToTree($id, $comment) {
        if (in_array(get_post_type($comment->comment_post_ID), $this->optionsSerialized->postTypes)) {
            if ($comment->comment_approved == '1' && $comment->comment_parent) {
                $this->updateCommentTree($comment);
            }
            update_comment_meta($id, WpdiscuzCore::META_KEY_VOTES, 0);
            if (!$comment->comment_parent) {
                update_comment_meta($id, WpdiscuzCore::META_KEY_CHILDREN, '');
            }
        }
    }

    /**
     * add new comment id in comment meta if status is approved
     * @param type $newStatus the comment new status
     * @param type $oldStatus the comment old status
     * @param type $comment current comment object
     */
    public function statusEventHandler($newStatus, $oldStatus, $comment) {
        if ($newStatus != $oldStatus) {
            if ($newStatus == 'approved') {
                $this->updateCommentTree($comment);
                $this->notifyOnApprove($comment);
            }
        }
    }

    private function updateCommentTree($comment) {
        $id = $comment->comment_ID;
        $rootComment = $this->getCommentRoot($id);
        $rootId = $rootComment->comment_ID;
        if ($rootId != $id) {
            $this->_updateCommentTree($rootId, $id);
        }
    }

    private function _updateCommentTree($parentId, $commentId) {
        $children = get_comment_meta($parentId, WpdiscuzCore::META_KEY_CHILDREN, TRUE);
        $childrenArray = explode(',', $children);
        if (($key = array_search($commentId, $childrenArray)) === false) {
            $childrenString = $children ? $children . $commentId . ',' : $commentId . ',';
            update_comment_meta($parentId, WpdiscuzCore::META_KEY_CHILDREN, $childrenString);
        }
    }

    public function initSubComments($commentId) {
        $this->isCommentInMeta = $this->dbManager->isCommentInMeta($commentId);
        if ($this->isCommentInMeta) {
            $subParentIds = $this->dbManager->getCommentsByParentId($commentId);
            foreach ($subParentIds as $subParentId) {
                $this->subComments[] = $subParentId;
            }
        }
    }

    public function deleteCommentFromTree($commentId) {
        if ($this->subComments && is_array($this->subComments)) {
            foreach ($this->subComments as $subCommentId) {
                $this->setSubComment($subCommentId);
            }
        }
        $this->_deleteCommentFromTree($commentId);
    }

    private function _deleteCommentFromTree($commentId) {
        $rows = $this->dbManager->getRowsContainingCommentId($commentId);
        $this->deleteImmediately($rows, $commentId);
    }

    private function deleteImmediately($rows, $commentId) {
        $pattern = "#(,|^)$commentId,#is";
        foreach ($rows as $row) {
            $replaced = preg_replace($pattern, '${1}', $row['meta_value']);
            update_comment_meta($row['comment_id'], WpdiscuzCore::META_KEY_CHILDREN, $replaced);
        }
    }

    /**
     * get the current comment root comment
     * @param type $commentId the current comment id
     * @return type comment
     */
    public function getCommentRoot($commentId) {
        $comment = get_comment($commentId);
        if ($comment->comment_parent) {
            return $this->getCommentRoot($comment->comment_parent);
        } else {
            return $comment;
        }
    }

    public function getCommentDepth($commentId, &$depth = 1) {
        $comment = get_comment($commentId);
        if ($comment->comment_parent && ($depth < $this->optionsSerialized->wordpressThreadCommentsDepth)) {
            $depth++;
            return $this->getCommentDepth($comment->comment_parent, $depth);
        } else {
            return $depth;
        }
    }

    private function notifyOnApprove($comment) {
        $postId = $comment->comment_post_ID;
        $commentId = $comment->comment_ID;
        $email = $comment->comment_author_email;
        $parentComment = get_comment($comment->comment_parent);
        $this->emailHelper->notifyPostSubscribers($postId, $commentId, $email);
        if ($parentComment) {
            $parentCommentEmail = $parentComment->comment_author_email;
            if ($parentCommentEmail != $email) {
                $this->emailHelper->notifyAllCommentSubscribers($postId, $commentId, $email);
                $this->emailHelper->notifyCommentSubscribers($parentComment->comment_ID, $commentId, $email);
            }
        }
    }
    
    public function clearChildrenData(){
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'clear_children_data') && isset($_GET['clear']) && trim($_GET['clear']) && current_user_can('manage_options')) {
            $this->dbManager->clearChildrenDataFromMeta();
        }
        wp_redirect(admin_url('edit-comments.php?page=wpdiscuz_options_page'));
    }

}
