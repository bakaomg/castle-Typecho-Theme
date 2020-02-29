<?php
/**
 * Castle 404 Page
 * Last Update: 2020/02/09
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 header('HTTP/1.1 200 OK');
 echo '<title>'.Castle_Header::title($this, '', ' - ', true, false).'</title>';
 echo '<div id="moe-pjax-content"'.Castle_Header::cardTransparent().'>';
}else{
 $this->need('core/inc/header.php');
}
?>
   <style>header{display:none;}footer{display:none;}#moe-pjax-content{padding:0px;}</style>
   <main class="moe-404-box">
    <div class="mdui-card moe-404-card">
     <div class="mdui-card-media">
      <div class="moe-card-cover-image lazyload" data-src="<?php
       $cover = $this->options->Cover404;
       if (!empty($cover)) {
        echo $cover;
       }else{
        Castle_Libs::resources('static/img/404.png', false, true);
       }
      ?>" style="background-image:url('');"></div>
      <div class="mdui-card-media-covered">
       <div class="mdui-card-primary">
        <div class="mdui-card-primary-title mdui-text-truncate"><?php $this->options->title() ?></div>
       </div>
      </div>
     </div>

     <div class="mdui-card-content">
      <div class="mdui-typo-title"><?php echo $GLOBALS['CastleLang']['404']['title']; ?></div>
      <div class="mdui-typo-subheading"><?php echo $GLOBALS['CastleLang']['404']['try']; ?></div>
      <form id="search-404-form" onkeydown="if(event.keyCode == 13){CastleSearch.submit($$('#search-404-form #searchInput')); return false;}">
       <div class="mdui-textfield">
        <input class="mdui-textfield-input" type="text" id="searchInput" placeholder="<?php echo $GLOBALS['CastleLang']['404']['search']; ?>">
       </div>
       <button class="mdui-btn mdui-btn-icon mdui-color-theme-accent mdui-ripple moe-btn mdui-btn-raised" type="button" onclick="CastleSearch.submit($$('#search-404-form #searchInput'))"><i class="mdui-icon material-icons">search</i></button>
      </form> 
     </div>
    
     <div class="moe-404-btn">
      <ul class="mdui-list">
       <a href="<?php $this->options->index(); ?>" class="mdui-list-item mdui-ripple">
        <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
        <div class="mdui-list-item-content"><?php echo $GLOBALS['CastleLang']['404']['home']; ?></div>
       </a>
      </ul>
     </div>
    </div>
   </main>
<?php
if (@$_SERVER['HTTP_X_PJAX'] == true) {
 echo '</div>';
}else{
 $this->need('core/inc/footer.php');
}
?>