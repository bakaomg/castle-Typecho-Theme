<?php
/**
 * Archive
 * Version 0.1.5
 * Author ohmyga( https://ohmyga.cn/ )
 * 2019/04/10
 **/
 if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 if (isset($_GET['_pjax'])) {
  echo '<title>';
  $this->archiveTitle(array('category'=>_t('分类 %s 下的文章'),'search'=>_t('包含关键字 %s 的文章'),'tag'=>_t('标签 %s 下的文章'),'author'=>_t('%s 发布的文章')), '', ' - ');
  echo $this->options->title.'</title>';
  echo '<div id="moe-body">';
 } else {
  $this->need('includes/header.php');
 }
 $this->need('includes/archive.php');
 if (isset($_GET['_pjax'])) {
  echo '</div>';
 } else {
  $this->need('includes/footer.php');
 }
?>