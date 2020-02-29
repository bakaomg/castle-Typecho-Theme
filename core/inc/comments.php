<?php
/**
 * Castle Comments
 * Last Update: 2020/02/09
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$showLink = (Helper::options()->commentSwitch && in_array('displayLinkBtn', Helper::options()->commentSwitch)) ? NULL : ' moe-comment-input-url-hidden';
$parameter = array(
   'parentId'      => $this->hidden ? 0 : $this->cid,
   'parentContent' => $this->row,
   'respondId'     => $this->respondId,
   'commentPage'   => $this->request->filter('int')->commentPage,
   'allowComment'  => $this->allow('comment')
);
$this->widget('Castle_Comments_Archive', $parameter)->to($comments);

//如果有密码且有权查看则显示评论区
if(!$this->hidden):
?>
   <div id="<?php $this->respondId(); ?>" class="respondID" data-commentUrl="<?php $this->commentUrl() ?>">
    <div class="mdui-card moe-comment-card " id="comment-card-box">
     <header class="moe-comment-card-header">
      <div class="moe-comment-card-title"><?php echo $GLOBALS['CastleLang']['comment']['respond']['title']; ?></div>
      <?php if(!$this->user->hasLogin()){
       echo (Helper::options()->commentTips) ? '<div class="moe-comment-card-small-title">'.Helper::options()->commentTips.'</div>' : NULL;
      } ?>
     </header>

     <form class="moe-comment-card-content" onKeyDown="if(event.ctrlKey && event.keyCode == 13){CastleComments.submitComment();return false;}">
     <?php if($this->user->hasLogin()): ?>
      <div class="mdui-card-header">
       <img class="mdui-card-header-avatar" src="<?php echo Castle_Avatar::getCommentAvatar($this->user->mail) ?>">
       <div class="mdui-card-header-title"><?php $this->user->screenName(); ?></div>
       <div class="mdui-card-header-subtitle"><?php echo $GLOBALS['CastleLang']['comment']['respond']['login']['tips']; ?></div>
       <div class="mdui-card-menu">
        <a href="javascript:CastleLogin.Logout();" class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo $GLOBALS['CastleLang']['comment']['respond']['login']['logout']; ?>'}" no-go no-pjax><i class="mdui-icon material-icons mdui-text-color-black">power_settings_new</i></a>
       </div>
      </div>

      <main class="moe-comment-textarea-and-owoBtn-main">
       <div class="mdui-textfield mdui-textfield-floating-label moe-comment-input-text">
        <i class="mdui-icon material-icons">textsms</i>
        <label class="mdui-textfield-label"><?php echo $GLOBALS['CastleLang']['comment']['respond']['message']['input']; ?></label>
        <textarea class="mdui-textfield-input" name="text" id="text"></textarea>
        <div class="mdui-textfield-helper"><?php echo $GLOBALS['CastleLang']['comment']['respond']['message']['helper']; ?></div>
       </div>
       <button class="mdui-btn mdui-btn-icon moe-comment-owo-btn" onclick="CastleOwO.toggle();" type="button" mdui-tooltip="{content: '<?php echo $GLOBALS['CastleLang']['comment']['respond']['smile']; ?>'}"><i class="mdui-icon material-icons">sentiment_very_satisfied</i></button>
      </main>
     <?php else: ?>
      <div style="margin-top: 10px"><?php //偷偷在这加个 margin 应该没人发现 ?></div>
      <main class="moe-comment-textarea-and-owoBtn-main">
       <div class="mdui-textfield mdui-textfield-floating-label moe-comment-input-text">
        <i class="mdui-icon material-icons">textsms</i>
        <label class="mdui-textfield-label"><?php echo $GLOBALS['CastleLang']['comment']['respond']['message']['input']; ?></label>
        <textarea class="mdui-textfield-input" name="text" id="text"></textarea>
        <div class="mdui-textfield-helper"><?php echo $GLOBALS['CastleLang']['comment']['respond']['message']['helper']; ?></div>
       </div>
       <button class="mdui-btn mdui-btn-icon moe-comment-owo-btn" onclick="CastleOwO.toggle();" type="button" mdui-tooltip="{content: '<?php echo $GLOBALS['CastleLang']['comment']['respond']['smile']; ?>'}"s><i class="mdui-icon material-icons">sentiment_very_satisfied</i></button>
      </main>

      <div class="mdui-textfield mdui-textfield-floating-label moe-comment-input-username">
       <i class="mdui-icon" id="moe-comment-author-avatar"><img src="<?php echo Castle_Libs::resources('static/img/commentAvatar.png', true, true); ?>" /></i>
       <label class="mdui-textfield-label"><?php echo $GLOBALS['CastleLang']['comment']['respond']['user']; ?></label>
       <input class="mdui-textfield-input" type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" required/>
      </div>

      <div class="mdui-textfield mdui-textfield-floating-label moe-comment-input-email">
       <i class="mdui-icon material-icons">email</i>
       <label class="mdui-textfield-label"><?php echo $GLOBALS['CastleLang']['comment']['respond']['email']['input']; ?>（<?php echo Helper::options()->commentsRequireMail ? $GLOBALS['CastleLang']['comment']['respond']['email']['require'] : $GLOBALS['CastleLang']['comment']['respond']['email']['optional'] ?>）</label>
       <input class="mdui-textfield-input" type="email" name="mail" id="email" value="<?php $this->remember('mail'); ?>" required/>
      </div>

      <div class="mdui-textfield mdui-textfield-floating-label moe-comment-input-url<?php echo $showLink; ?>">
       <i class="mdui-icon material-icons">link</i>
       <label class="mdui-textfield-label"><?php echo $GLOBALS['CastleLang']['comment']['respond']['url']['input']; ?>（<?php echo Helper::options()->commentsRequireURL? $GLOBALS['CastleLang']['comment']['respond']['url']['require'] : $GLOBALS['CastleLang']['comment']['respond']['url']['optional'] ?>）</label>
       <input class="mdui-textfield-input" type="url" name="url" id="url" value="<?php $this->remember('url'); ?>"/>
      </div>
     <?php endif; ?>
     </form>

     <footer class="moe-comment-card-footer">
      <div class="moe-comment-card-btns">
       <?php if(!$this->user->hasLogin()) { ?><button class="mdui-btn mdui-btn-icon mdui-btn-raised mdui-color-grey-800" id="showLinkInput" onclick="CastleComments.showLinkInput();" mdui-tooltip="{content: '<?php echo $GLOBALS['CastleLang']['comment']['respond']['buttons']['link']; ?>'}"><i class="mdui-icon material-icons">&#xe157;</i></button><?php } ?>
       <?php $comments->cancelReply('<button class="mdui-btn mdui-ripple moe-comments-close-btn mdui-text-color-red" mdui-tooltip="{content: \''.$GLOBALS['CastleLang']['comment']['respond']['buttons']['cancelReply'].'\'}"><i class="mdui-icon material-icons">close</i></button>'); ?>
       <button class="mdui-btn mdui-btn-raised mdui-color-theme" id="submitCommentBtn" onclick="CastleComments.submitComment();" mdui-tooltip="{content: '<?php echo $GLOBALS['CastleLang']['comment']['respond']['buttons']['reply']; ?>'}"><i class="mdui-icon material-icons">&#xe163;</i></button>
      </div>
     </footer>

    </div>
   </div>

   <div class="mdui-card moe-comments-list-card" id="comments">
    <header class="moe-comments-list-header">
     <div class="moe-comments-list-title"><?php echo $GLOBALS['CastleLang']['comment']['commrntsBox']['title']; ?></div>
     <div class="moe-comments-list-number"><?php $this->commentsNum($GLOBALS['CastleLang']['comment']['commrntsBox']['counts']['no'], sprintf($GLOBALS['CastleLang']['comment']['commrntsBox']['counts']['have'], '1'), $GLOBALS['CastleLang']['comment']['commrntsBox']['counts']['have']); ?></div>
    </header>

    <?php if ($comments->have()){
         $comments->listComments(array(
          'before'        =>  '<div class="moe-comments-list-box">',
          'after'         =>  '</div>',
          'avatarSize'    =>  64,
          'dateFormat'    =>  'Y-m-d H:i'
         ));
      }
    ?>

    <footer class="moe-comments-list-footer">
     <?php $comments->pageNav('<span><<</span>', '<span>>></span>', 1, '...', 'wrapTag=div&wrapClass=moe-comments-page-navigator&prevClass=prev&nextClass=next'); ?>
    </footer>
   </div>
<?php
endif;
?>