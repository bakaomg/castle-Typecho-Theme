<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
  <style>
   <?php
   if($this->options->bgp){
    echo '.moe-bg{background-image:url('.$this->options->bgp.')}';
   }
   if($this->options->bgs){
    echo '@media(max-width:600px){.moe-bg{background-image:url('.$this->options->bgs.')}}';
   }elseif($this->options->bgp){
    echo '@media(max-width:600px){.moe-bg{background-image:url('.$this->options->bgp.')}}';
   }
   ?>
  </style>