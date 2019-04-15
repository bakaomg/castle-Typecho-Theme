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
   if($this->options->cardt == '0'){
   }elseif($this->options->cardt == '10'){
    echo '.moe-card-tr{background-color: rgba(255,255,255,0.9)!important;}@media(max-width:600px){.moe-nav{background-color: rgba(255,255,255,0.9)!important;}}';
   }elseif($this->options->cardt == '20'){
    echo '.moe-card-tr{background-color: rgba(255,255,255,0.8)!important;}@media(max-width:600px){.moe-nav{background-color: rgba(255,255,255,0.8)!important;}}';
   }elseif($this->options->cardt == '30'){
    echo '.moe-card-tr{background-color: rgba(255,255,255,0.7)!important;}@media(max-width:600px){.moe-nav{background-color: rgba(255,255,255,0.7)!important;}}';
   }
   ?>
  </style>