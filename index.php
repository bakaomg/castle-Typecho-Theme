<?php
/**
 * 从零开始<br>作者：<a href="https://ohmyga.cn/">ohmyga</a>
 * 
 * @package Castle
 * @author ohmyga
 * @version 0.3.3
 * @link https://ohmyga.cn/
 */
 if (!defined('__TYPECHO_ROOT_DIR__')) exit;
  /** 文章置顶 */
  $sticky = $this->options->sticky; //置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔
  if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));//分割文本 
    $sticky_html = "<span style=\"color:red;text-shadow:none;\">[置顶] </span>"; //置顶标题的 html
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    //清空原有文章的列队
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
        if($i == 0) $select1->where('cid = ?', $cid);
        else $select1->orWhere('cid = ?', $cid);
        $order .= " when $cid then $i";
        $select2->where('table.contents.cid != ?', $cid); //避免重复
    }
    if ($order) $select1->order(null,"(case cid$order end)"); //置顶文章的顺序 按 $sticky 中 文章ID顺序
    if ($this->_currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){ //首页第一页才显示
        $sticky_post['sticky'] = $sticky_html;
        $this->push($sticky_post); //压入列队
    }
    $uid = $this->user->uid; //登录时，显示用户各自的私密文章
    if($uid) $select2->orWhere('authorId = ? && status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); //压入列队
    $this->setTotal($this->getTotal()-count($sticky_cids)); //置顶文章不计算在所有文章内
  }
 if (isset($_GET['_pjax'])) {
  echo '<title>';
  $this->archiveTitle(array('category'=>_t('分类 %s 下的文章'),'search'=>_t('包含关键字 %s 的文章'),'tag'=>_t('标签 %s 下的文章'),'author'=>_t('%s 发布的文章')), '', ' - ');
  echo $this->options->title.'</title>';
  echo '<div id="moe-body">';
 } else {
  $this->need('includes/header.php');
 }
?>
   <div id="moe-post">
    <div class="moe-margin-card-top"></div>
    <?php while($this->next()): ?>
	<?php $PostType = $this->fields->PostType;
    if($PostType == "nopic"){ ?>
	<div class="mdui-card moe-card moe-card-day moe-card-a moe-card-tr">
	 <div class="moe-card-day-icon moe-headimg-xz"><i class="mdui-icon material-icons"><?php $Dicon = PSetting($this, 'Dicon'); if(!empty($Dicon)) { echo PSetting($this, 'Dicon'); }else{ echo 'message'; } ?></i></div>
	 <h2 class="moe-day-title"><a href="<?php $this->permalink() ?>" title="<?php echo sprintf(lang('index', 'FloatingTitle'), $this->title); ?>"><?php $this->sticky(); $this->title() ?></a></h2>
	 <span class="moe-day-d"><?php if($this->fields->des){ $this->fields->des(); }else{ $this->excerpt(100); } ?></span>
	 <div class="mdui-divider"></div>
	 <div class="moe-day-info">
	  <i class="mdui-icon material-icons moe-author-icon">account_circle</i>
	  <span class="moe-author"><?php $this->author(); ?></span>
	  <i class="mdui-icon material-icons moe-time-icon">access_time</i>
	  <span class="moe-time"><?php $this->date(lang('index', 'time')); ?></span>
	  <i class="mdui-icon material-icons moe-comments-t">forum</i>
	  <span class="moe-comments moe-comments-t"><?php echo sprintf(lang('index', 'commentNopic'), $this->commentsNum); ?></span>
	 </div>
	</div>
	<?php }elseif($PostType == "dynamic"){?>
	<div class="mdui-card moe-card-day2 moe-card-a moe-card-tr">
	 <div class="moe-day2">
	  <i class="mdui-icon material-icons">autorenew</i>
	  <span class="moe-body">
	   <span class="moe-t"><?php $Dtitle = PSetting($this, 'Dtitle'); if(!empty($Dtitle)) { $this->sticky(); echo PSetting($this, 'Dtitle'); }else{ $this->sticky(); $this->title(); } ?>（<a href="<?php $this->permalink() ?>"><?php echo lang('index', 'LinkDynamic'); ?></a>）</span>
	   <span class="moe-info"><?php $this->date(lang('index', 'time')); ?> • <?php echo sprintf(lang('index', 'commentDynamic'), $this->commentsNum); ?> • <?php echo sprintf(lang('index', 'viewDynamic'), PostView($this)); ?></span>
	  </span>
	 </div>
	</div>
	<?php }else{ ?>
    <div class="mdui-card moe-card mdui-hoverable moe-card-a moe-card-tr">
     <div class="mdui-card-media moe-card-media">
	  <main class="moe-card-img" data-original="<?php $wzimg = $this->fields->wzimg;
	 if(!empty($wzimg)){
      echo $this->fields->wzimg;
	 }else{
	  echo randPic();
	 }?>" style="background-image: url('<?php echo themeResource('others/img/loading.gif'); ?>');"></main>
	  <div class="mdui-card-media-covered">
	   <div class="mdui-card-primary">
	    <a href="<?php $this->permalink() ?>" class="mdui-card-primary-title moe-card-title moe-text-ellipsis" title="<?php echo sprintf(lang('index', 'FloatingTitle'), $this->title); ?>"><?php $this->sticky(); $this->title() ?></a>
		<div class="mdui-card-primary-subtitle"><?php echo sprintf(lang('index', 'view'), PostView($this)); ?> | <?php echo sprintf(lang('index', 'comment'), $this->commentsNum); ?></div>
       </div>
	  </div>
	 </div>
	 
	 <div class="mdui-card-actions">
	  <div class="moe-post-margin"></div>
	  <span class="moe-post-text">
	   <?php if($this->fields->des){ $this->fields->des(); }else{ $this->excerpt(100); } ?>
	  </span>
	  <div class="moe-post-margin"></div>
	 </div>
	 
	 <div class="mdui-divider"></div>
	 
	 <div class="mdui-card-header">
	  <img class="mdui-card-header-avatar moe-headimg-xz" data-original="<?php echo siteHeadimg('pauthor', $this); ?>" src="<?php echo themeResource('others/img/loading.gif'); ?>">
	  <div class="mdui-card-header-title"><?php $this->author(); ?></div>
	  <div class="mdui-card-header-subtitle"><?php $this->date(lang('index', 'time')); ?></div>
	  <div class="mdui-card-menu">
	   <a href="<?php $this->permalink() ?>" class="mdui-btn mdui-text-color-theme"><?php echo lang('index', 'ViewLink'); ?></a>
	  </div>
	 </div>
    </div>
	<?php } ?>
    <?php endwhile; ?>
    <div class="moe-margin-card-top"></div>
	<div class="moe-page-div moe-card-a">
	 <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-prev"><i class="mdui-icon material-icons">navigate_before</i></button>','prev'); ?>
	 <button class="mdui-btn moe-number" disabled><span class=""><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> / <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></span></button>
	 <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-next"><i class="mdui-icon material-icons">navigate_next</i></button>','next'); ?>
    </div>
   </div>

<?php
if (isset($_GET['_pjax'])) {
 echo '</div>';
} else {
 $this->need('includes/footer.php');
}
?>