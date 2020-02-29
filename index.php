<?php
/**
 * MD 风格单栏主题<br>
 * 作者：<a href="https://ohmyga.cn/" target="_blank">ohmyga</a> | 主题文档：<a href="https://castle.baka.show/" target="_blank">Wiki</a> | 主题仓库：<a href="https://github.com/ohmyga233/castle-Typecho-Theme" target="_blank">GitHub</a> 
 * 封面贴图图源：<a href="https://www.pixiv.net/artworks/66074820?p=2" target="_blank">最近のケモショタまとめログ③ - #P2</a>
 * 
 * @package Castle
 * @author ohmyga
 * @version 0.9.0
 * @link https://ohmyga.cn/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/** 文章置顶 */
  $sticky = $this->options->StickyArticle; //置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔
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
  if (@$_SERVER['HTTP_X_PJAX'] == true) {
   header('HTTP/1.1 200 OK');
   echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
   echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
  }else{
   $this->need('core/inc/header.php');
  }
?>
   <main id="moe-post-list">
<?php while($this->next()): ?>
    <div class="mdui-card mdui-hoverable moe-default-card">
     <div class="mdui-card-media">
      <div class="moe-card-cover-image lazyload" data-src="<?php
       $cover = $this->fields->cover;
       if (!empty($cover)) {
        echo $cover;
       }else{
        Castle_Libs::randCover(true);
       }
      ?>" style="background-image:url('');"></div>
      <div class="mdui-card-media-covered">
       <div class="mdui-card-primary">
        <a href="<?php $this->permalink() ?>" class="mdui-card-primary-title mdui-text-truncate"><?php $this->sticky(); $this->title() ?></a>
        <div class="mdui-card-primary-subtitle"><?php echo sprintf($GLOBALS['CastleLang']['index']['view'], Castle_Contents::PostView($this)); ?> | <?php echo sprintf($GLOBALS['CastleLang']['index']['comment'], $this->commentsNum); ?></div>
       </div>
      </div>
     </div>

     <div class="mdui-card-actions">
      <div class="moe-card-excerpt">
       <?php if (!$this->excerpt && !$this->fields->excerpt) {
        echo $GLOBALS['CastleLang']['index']['excerptEmpty'];
       } elseif ($this->fields->excerpt) {
        echo Castle_Contents::parseOwO($this->fields->excerpt);
       } else {
        $this->excerpt(100);
       } ?>
      </div>
     </div>

     <div class="mdui-divider"></div>

     <div class="mdui-card-header">
      <img class="mdui-card-header-avatar" src="<?php echo (Helper::options()->siteAvatar) ? Helper::options()->siteAvatar : Castle_Libs::resources('static/img/avatar.jpg'); ?>"/>
      <div class="mdui-card-header-title"><?php $this->author(); ?></div>
      <div class="mdui-card-header-subtitle"><?php $this->date($GLOBALS['CastleLang']['index']['time']); ?></div>
      <div class="mdui-card-menu">
	   <a href="<?php $this->permalink() ?>" class="mdui-btn mdui-text-color-theme"><?php echo $GLOBALS['CastleLang']['index']['viewLink']; ?></a>
	  </div>
     </div>
    </div>
<?php endwhile; ?>

    
    <div class="moe-pagination">
     <?php if ($this->_currentPage>1){ ?>
      <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-prev"><i class="mdui-icon material-icons">navigate_before</i></button>','prev'); ?>
     <?php }else{ ?>
      <button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 mdui-btn-raised moe-prev" disabled><i class="mdui-icon material-icons">navigate_before</i></button>
     <?php } ?>

     <button class="mdui-btn moe-page-number"><span class=""><?php if($this->_currentPage>1) echo $this->_currentPage;  else echo 1;?> / <?php echo ceil($this->getTotal() / $this->parameter->pageSize); ?></span></button>

     <?php if ($this->_currentPage<ceil($this->getTotal()/$this->parameter->pageSize)){ ?>
      <?php $this->pageLink('<button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-shadow-5 moe-next"><i class="mdui-icon material-icons">navigate_next</i></button>','next'); ?>
     <?php } else { ?>
      <button class="mdui-btn mdui-btn-icon mdui-ripple mdui-color-theme-accent mdui-btn-raised mdui-shadow-5 moe-next" disabled><i class="mdui-icon material-icons">navigate_next</i></button>
     <?php } ?>
    </div>
   </main>
<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>