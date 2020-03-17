<?php
/**
 * Castle Footer
 * Last Update: 2020/03/17
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
  </div>

  <?php $this->need('core/inc/toc.php'); ?>
  <?php echo ($this->options->addFooter) ? $this->options->addFooter() : NULL; ?>
  <?php Castle_Footer::export($this) ?>
  <?php $this->footer(); ?>

 </body>

</html>
<?php if ($this->options->switch && in_array('html', $this->options->switch)){ $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); } ?>