<?php
/**
 * 归档页
 *
 * @package custom
 */
/**
 * Castle Archives
 * Last Update: 2020/02/26
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 header('HTTP/1.1 200 OK');
 echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
 echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
}else{
 $this->need('core/inc/header.php');
}

$this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=30')->to($tags);
if(is_array($tags->stack)) {
 $tagsCount = count($tags->stack);
}else{
 $tagsCount = NULL;
}
?>
   <div id="archives-view"  data-view="<?php echo Castle_Contents::PostView($this); ?>"></div>
   <div class="mdui-card moe-archive-card moe-archive-tags-card">
    <header class="moe-archive-tags-header">
     <div class="moe-archive-tags-title"><?php echo $GLOBALS['CastleLang']['page-archives']['tags']['title']; ?></div>
     <?php if($tagsCount) { echo "<div class=\"moe-archive-tags-count\">".sprintf($GLOBALS['CastleLang']['page-archives']['tags']['count'], $tagsCount)."</div>"; } ?>
    </header>

    <div class="moe-archive-tags-content">
    <?php if($tags->have()): ?>
     <?php while ($tags->next()): ?>
     <a href="<?php $tags->permalink(); ?>" class="moe-archive-tags-link mdui-hoverable" mdui-tooltip="{content: '<?php echo sprintf($GLOBALS['CastleLang']['page-archives']['tags']['have'], $tags->count) ?>'}"># <?php $tags->name(); ?></a>
     <?php endwhile; ?>
    <?php else: ?>
     <div class="moe-archive-tag-not"><?php echo $GLOBALS['CastleLang']['page-archives']['tags']['empty']; ?></div>
    <?php endif; ?>
    </div>
   </div>

   <div class="mdui-card moe-archive-card moe-archives-list-card">
    <header class="moe-archives-list-card-header">
     <div class="moe-archives-list-title"><?php echo $GLOBALS['CastleLang']['page-archives']['archives']['title']; ?></div>
    </header>

    <div class="moe-archives-list-content">
     <div class="mdui-panel mdui-panel-gapless" mdui-panel>

     <?php
      $archives = Castle_Contents::archives($this);
      $number = 0;
      foreach($archives as $year => $posts) {
       $panelOpen = ($number === 0) ? ' mdui-panel-item-open' : NULL;
       echo '<div class="mdui-panel-item'.$panelOpen.'">
        <div class="mdui-panel-item-header">';
       echo '<div class="mdui-panel-item-title">'.$year.'</div>
        <div class="mdui-panel-item-summary">'.sprintf($GLOBALS['CastleLang']['page-archives']['archives']['count'], count($posts)).'</div>';
       echo '<i class="mdui-panel-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
        </div>
        <div class="mdui-panel-item-body">
        ';
        foreach($posts as $created => $post) {
         echo '<a href="'.$post['permalink'].'" class="moe-archives-list-alist mdui-ripple">
          <span class="date">'.date('m-d', $created).'</span>
          '.$post['title'].'
        </a>';
        }
       echo '</div></div>';
       $number++;
      }
     ?>

     </div>
    </div>
   </div>

<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>