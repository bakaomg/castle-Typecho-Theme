<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function threadedComments($comments, $options) {
  $commentClass = '';
  if ($comments->authorId) {
    if ($comments->authorId == $comments->ownerId) {
      $commentClass .= '<i class="iconfont icon-author moe-comments-ua moe-author-icon" mdui-tooltip="{content: \''.lang('comment', 'author').'\'}"></i>';
    } else {
      $commentClass .= '';
    }
  }
  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
   <li class="moe-comments-list-li" id="<?php $comments->theId(); ?>">
    <div class="moe-comments-headimg-box">
     <img class="moe-comments-headimg moe-headimg-xz" data-original="<?php echo userHeadimg($comments); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>">
	</div>
	<div class="moe-comments-content">
	 <div class="moe-author-name mdui-typo"><?php
	 $AdminMail = Castle::getAdminMail();
     if ($AdminMail == $comments->mail) { $commentsClassName = '<i class="iconfont icon-bloger moe-comments-ua moe-author-icon" mdui-tooltip="{content: \''.lang('comment', 'bloger').'\'}"></i>'; }else{ $commentsClassName = ''; }
     if (!empty($comments->url)) { 
      echo '<a href="'.$comments->url.'" target="_blank">'.$comments->author.'</a>'.$commentsClassName.$commentClass.'';
     }else{
	  echo '<span>'.$comments->author.'</span>'.$commentsClassName.$commentClass.'';
     } ?><?php getBrowser($comments->agent); getOs($comments->agent); ?></div>
	 <div class="moe-comments-time"><?php $comments->date(lang('comment', 'time')); ?></div>
	 <div class="moe-reply"><?php $comments->reply('<button class="mdui-btn">'.lang('comment', 'reply').'</button>'); ?></div>
	 <div class="moe-comments-textBox">
	  <?php echo Castle::commentsReply($comments); echo preg_replace('#</?[p][^>]*>#','', Castle::parseAll($comments->content)); ?>
	 </div>
	</div>
   </li>
   <?php if ($comments->children){ $comments->threadedComments($options); }?>
   <div class="mdui-divider moe-dv-t"></div>
<?php } ?>

<?php $this->comments()->to($comments); ?>
  <?php if($this->allow('comment')): ?>
  <div id="<?php $this->respondId(); ?>">
  <div class="mdui-card moe-comments-box moe-card-tr" id="commentsBoxOuO">
  <center><h1><?php echo lang('comment', 'commentTitle'); ?></h1></center>
  <?php if($this->user->hasLogin()): ?>
   <div class="mdui-card-header moe-comments-admin-header">
    <img class="mdui-card-header-avatar moe-headimg-xz" src="<?php echo siteHeadimg('pauthor', $this); ?>">
    <div class="mdui-card-header-title"><?php $this->user->screenName(); ?></div>
    <div class="mdui-card-header-subtitle"><?php echo lang('comment', 'loginUserCommentTitle'); ?></div>
	<div class="mdui-card-menu">
	 <a no-pjax href="<?php $this->options->logoutUrl(); ?>"><button class="mdui-btn mdui-btn-icon" mdui-tooltip="{content: '<?php echo lang('comment', 'loginOut'); ?>'}"><i class="mdui-icon material-icons mdui-text-color-black">power_settings_new</i></button></a>
	</div>
   </div>
   
   <form id="commentsSubmit-Form" onKeyDown="if(event.ctrlKey && event.keyCode == 13){commentSubmit();}"<?php if ($this->options->comment && in_array('ajax', $this->options->comment)){}else{ echo ' method="post" action="'.$this->commentUrl.'"'; }?>>
   <div class="mdui-textfield mdui-textfield-floating-label" style="width: calc(100% - 60px);">
    <i class="mdui-icon material-icons">textsms</i>
    <label class="mdui-textfield-label"><?php echo lang('comment', 'commentTextsms'); ?></label>
    <textarea class="mdui-textfield-input" id="moe-comments-pl" name="text" type="text"></textarea>
	<div class="mdui-textfield-helper"><?php echo lang('comment', 'markdown'); ?></div>
   </div>
   
   <button onclick="openSmile()" type="button" mdui-tooltip="{content: '<?php echo lang('comment', 'smile'); ?>'}" class="mdui-btn mdui-btn-icon mdui-float-right moe-owo-btn-login"><i class="mdui-icon material-icons">sentiment_very_satisfied</i></button>
   <?php if ($this->options->comment && in_array('ajax', $this->options->comment)){}else{ ?><div class="moe-comments-btn">
    <?php $comments->cancelReply('<button class="mdui-btn mdui-ripple moe-comments-close-btn mdui-text-color-red" mdui-tooltip="{content: \''.lang('comment', 'cancelReply').'\'}" type="button"><i class="mdui-icon material-icons">close</i></button>'); ?>
    <button class="mdui-btn mdui-color-theme mdui-ripple moe-comments-submit-btn mdui-btn-raised" mdui-tooltip="{content: '<?php echo lang('comment', 'sendComment'); ?>'}" type="submit"><i class="mdui-icon material-icons">send</i></button>
   </div>
   <?php } ?>
   </form>
  <?php else: ?>
   <form id="commentsSubmit-Form" onKeyDown="if(event.ctrlKey && event.keyCode == 13){commentSubmit();}"<?php if ($this->options->comment && in_array('ajax', $this->options->comment)){}else{ echo ' method="post" action="'.$this->commentUrl.'"'; }?>>
   <div class="mdui-textfield mdui-textfield-floating-label" style="width: calc(100% - 60px);">
    <i class="mdui-icon material-icons">textsms</i>
    <label class="mdui-textfield-label"><?php echo lang('comment', 'commentTextsms'); ?></label>
    <textarea class="mdui-textfield-input" id="moe-comments-pl" name="text" type="text"></textarea>
	<div class="mdui-textfield-helper"><?php echo lang('comment', 'markdown'); ?></div>
   </div>
   
   <button onclick="openSmile()" type="button" mdui-tooltip="{content: '<?php echo lang('comment', 'smile'); ?>'}" class="mdui-btn mdui-btn-icon mdui-float-right moe-owo-btn-usr"><i class="mdui-icon material-icons">sentiment_very_satisfied</i></button>
   
   <div class="mdui-textfield mdui-textfield-floating-label moe-input-name">
    <i class="mdui-icon"><img class="moe-comment-ajax-headimg moe-headimg-xz" data-original="<?php $this->options->themeUrl('others/img/huaji.png'); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>"></i>
    <label class="mdui-textfield-label"><?php echo lang('comment', 'commentUserName'); ?></label>
    <input class="mdui-textfield-input" type="text" name="author" value="<?php $this->remember('author'); ?>" required />
   </div>
	 
   <div class="mdui-textfield mdui-textfield-floating-label moe-input-email">
    <i class="mdui-icon material-icons">email</i>
    <label class="mdui-textfield-label"><?php echo lang('comment', 'commentUserEmail'); ?></label>
    <input class="mdui-textfield-input" id="moe-comment-ajax-email" type="email" name="mail" value="<?php $this->remember('mail'); ?>" required />
   </div>
	 
   <div class="mdui-textfield mdui-textfield-floating-label moe-input-url" id="moe-input-url">
    <i class="mdui-icon material-icons">link</i>
    <label class="mdui-textfield-label"><?php echo lang('comment', 'commentUserURL'); ?></label>
    <input class="mdui-textfield-input" type="url" name="url" value="<?php $this->remember('url'); ?>"/>
	<input id="LinksX" name="LinksX" type="hidden" value="false"/>
   </div>
   <?php if ($this->options->comment && in_array('ajax', $this->options->comment)){}else{ ?><div class="moe-comments-btn">
    <button class="mdui-btn mdui-btn-icon mdui-ripple moe-comments-url-btn mdui-color-grey-800 mdui-btn-raised" onclick="commentLinks()" mdui-tooltip="{content: '<?php echo lang('comment', 'URLbutton'); ?>'}" type="button"><i class="mdui-icon material-icons">link</i></button>
    <?php $comments->cancelReply('<button class="mdui-btn mdui-ripple moe-comments-close-btn mdui-text-color-red" mdui-tooltip="{content: \''.lang('comment', 'cancelReply').'\'}"><i class="mdui-icon material-icons">close</i></button>'); ?>
    <button class="mdui-btn mdui-color-theme mdui-ripple moe-comments-submit-btn mdui-btn-raised" mdui-tooltip="{content: '<?php echo lang('comment', 'sendComment'); ?>'}" type="submit"><i class="mdui-icon material-icons">send</i></button>
   </div>
   <?php } ?>
   </form>
  <?php endif; ?>
   <?php if ($this->options->comment && in_array('ajax', $this->options->comment)){ ?><div class="moe-comments-btn">
    <?php if($this->user->hasLogin()){}else{ echo '<button class="mdui-btn mdui-btn-icon mdui-ripple moe-comments-url-btn mdui-color-grey-800 mdui-btn-raised" onclick="commentLinks()" mdui-tooltip="{content: \''.lang('comment', 'URLbutton').'\'}"><i class="mdui-icon material-icons">link</i></button>'; } ?>
    <?php $comments->cancelReply('<button class="mdui-btn mdui-ripple moe-comments-close-btn mdui-text-color-red" mdui-tooltip="{content: \''.lang('comment', 'cancelReply').'\'}"><i class="mdui-icon material-icons">close</i></button>'); ?>
    <button class="mdui-btn mdui-color-theme mdui-ripple moe-comments-submit-btn mdui-btn-raised" onclick="commentSubmit()" mdui-tooltip="{content: '<?php echo lang('comment', 'sendComment'); ?>'}" id="commentsSuBtt"><i class="mdui-icon material-icons" id="commentSuBt">send</i></button>
   </div><?php } ?>

   
   <br>
  </div>
  </div>
  <?php else: ?>
  <div class="mdui-card moe-comments-ban mdui-color-red">
   <span class="moe-text">
    <i class="mdui-icon material-icons">speaker_notes_off</i> <span><?php echo lang('comment', 'commentOff'); ?></span>
   </span>
  </div>
  <?php endif; ?>
  
  <div class="moe-comments-list-box mdui-card moe-card-tr" id="comments">
  <div class="mdui-divider moe-c-d"></div>
   <div class="moe-comments-list-headText-box">
    <span class="moe-title"><i class="mdui-icon material-icons">mode_comment</i> <?php echo lang('comment', 'commentAllTitle'); ?></span>
	<span class="moe-number"><?php $this->commentsNum(_t(lang('comment', 'NoComment')), _t(lang('comment', 'OnlyOneComment')), _t(lang('comment', 'AllCommentNumber'))); ?></span>
   </div>
   <div class="mdui-divider"></div>
<?php if ($comments->have()){ $comments->listComments(); }?>
   <div class="mdui-divider"></div>
  </div>
  <?php $comments->pageNav('<<', '>>', 1, '···', array('wrapTag' => 'div', 'wrapClass' => 'moe-comments-nav mdui-card mdui-card-content moe-card-tr', 'itemTag' => 'li', 'currentClass' => 'mdui-shadow-3 current',)); ?>
  
<?php if($this->allow('comment')){$this->need("includes/owo.php");}else{} ?>
<div class="mdui-divider moe-c-d"></div>