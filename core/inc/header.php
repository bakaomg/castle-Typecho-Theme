<?php
/**
 * Castle Header
 * Last Update: 2020/03/18
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$newuiClass = (Helper::options()->TestSwitch && in_array('newui', Helper::options()->TestSwitch) && Helper::options()->TestSwitch && in_array('newuiUPRadius', Helper::options()->TestSwitch)) ? " newui-up-radius" : "";
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title><?php Castle_Header::title($this, '', ' - ', true, true); ?></title>
  <?php echo ($this->options->ChromeThemeColor) ? '<meta name="theme-color" content="'.$this->options->ChromeThemeColor.'">'."\n" : NULL; ?>
  <link rel="icon" type="image/x-icon" href="<?php
   echo ($this->options->siteFavicon) ? $this->options->siteFavicon : Castle_Libs::resources('static/img/favicon.png');
  ?>">
  <?php Castle_Header::export($this) ?>
  <?php echo ($this->options->addHeader) ? $this->options->addHeader() : NULL; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
 </head>

 <body class="mdui-theme-primary-<?php $this->options->themeColor(); ?> mdui-theme-accent-<?php $this->options->themeAccentColor(); ?><?php echo (Helper::options()->themeDarkColor == 'dark') ? ' mdui-theme-layout-dark' : NULL; ?><?php echo $newuiClass; ?>">

  <header class="mdui-appbar mdui-appbar-fixed mdui-appbar-inset<?php echo ($this->options->appbar && in_array('scrollHide', $this->options->appbar)) ? ' mdui-appbar-scroll-hide' : NULL; ?>" id="header"></header>

<?php $this->need('/core/inc/sidebar.php'); ?>


  <div id="moe-pjax-content"<?php echo Castle_Header::cardTransparent(); ?>>
