<?php
/**
 * Castle Header
 * Last Update: 2020/01/25
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8" />
  <title><?php Castle_Header::title($this, '', ' - ', true, true); ?></title>
  <?php echo ($this->options->ChromeThemeColor) ? '<meta name="theme-color" content="'.$this->options->ChromeThemeColor.'">'."\n" : NULL; ?>
  <link rel="icon" type="image/x-icon" href="<?php
   echo ($this->options->siteAvatar) ? $this->options->siteAvatar : Castle_Libs::resources('static/img/favicon.png');
  ?>">
  <?php Castle_Header::export($this) ?>
  <?php echo ($this->options->addHeader) ? $this->options->addHeader() : NULL; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
 </head>

 <body class="mdui-theme-primary-<?php $this->options->themeColor(); ?> mdui-theme-accent-<?php $this->options->themeAccentColor(); ?><?php echo (Helper::options()->themeDarkColor == 'dark') ? ' mdui-theme-layout-dark' : NULL; ?>">

  <header class="mdui-appbar mdui-appbar-fixed" id="header"></header>

<?php $this->need('/core/inc/sidebar.php'); ?>


  <div id="moe-pjax-content"<?php echo Castle_Header::cardTransparent(); ?>>
