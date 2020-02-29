<?php
/**
 * Castle Sidebar Class
 * Last Update: 2020/01/26
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Castle_Sidebar {
 
 /**
  * 获取侧栏菜单
  */
 public static function getMenuList() {
  $sidebarMenu = Helper::options()->sidebarMenu;
  if (!$sidebarMenu) return false;
  if (!is_array(json_decode($sidebarMenu, true))) return false;

  //分类
  Typecho_Widget::widget('Widget_Metas_Category_List')->to($category);
  //页面
  Typecho_Widget::widget('Widget_Contents_Page_List')->to($pages);
  //数量
  Typecho_Widget::widget('Widget_Stat')->to($stat);

  //转换为组数
  $sidebarMenu = json_decode($sidebarMenu, true);
  for($menuCount=0; $menuCount<count($sidebarMenu); $menuCount++) {
   //类型为按钮
   if ($sidebarMenu[$menuCount]['type'] == 'button') {
    $sidebarMenu[$menuCount]['link'] = str_replace("{siteIndex}", Castle_Libs::index(), $sidebarMenu[$menuCount]['link']);
   }

   //类型为归档
   if ($sidebarMenu[$menuCount]['type'] == 'archives') {
   //归档
   $sidebarMenu[$menuCount]['setting']['date'] = ($sidebarMenu[$menuCount]['setting']['date']) ? $sidebarMenu[$menuCount]['setting']['date'] : 'Y 年 m 月';
   Typecho_Widget::widget('Widget_Contents_Post_Date', 'type=month&format='.$sidebarMenu[$menuCount]['setting']['date'])->to($archives);
    for($i=0; $i<count($archives->stack); $i++) {
     $sidebarMenu[$menuCount]['archives'][$i] = [
      'date'  => ($archives->stack)[$i]['date'],
      'count' => ($archives->stack)[$i]['count'],
      'link' => ($archives->stack)[$i]['permalink'],
     ];
    }
   }

   //类型为分类
   if ($sidebarMenu[$menuCount]['type'] == 'category') {
    for($i=0; $i<count($category->stack); $i++) {
     $sidebarMenu[$menuCount]['category'][$i] = [
      'name' => ($category->stack)[$i]['name'],
      'count' => ($category->stack)[$i]['count'],
      'link' => ($category->stack)[$i]['permalink']
     ];
    }
   }

   //类型为页面
   if ($sidebarMenu[$menuCount]['type'] == 'pages') {
    for($i=0; $i<count($pages->stack); $i++) {
     $sidebarMenu[$menuCount]['pages'][$i] = [
      'name' => ($pages->stack)[$i]['title'],
      'link' => ($pages->stack)[$i]['permalink']
     ];
    }
   }

   //类型为 Rss
   if ($sidebarMenu[$menuCount]['type'] == 'RssLink') {
    $sidebarMenu[$menuCount]['RssLink'] = Helper::options()->feedUrl;
   }

   //类型为文章总数
   if($sidebarMenu[$menuCount]['type'] == 'TotalPost') {
    $sidebarMenu[$menuCount]['count'] = $stat->publishedPostsNum;
   }

   //类型为页面总数
   if($sidebarMenu[$menuCount]['type'] == 'TotalPage') {
    $sidebarMenu[$menuCount]['count'] = $stat->publishedPagesNum;
   }

   //类型为评论总数
   if($sidebarMenu[$menuCount]['type'] == 'TotalComments') {
    $sidebarMenu[$menuCount]['count'] = $stat->publishedCommentsNum;
   }

   //类型为分类总数
   if($sidebarMenu[$menuCount]['type'] == 'TotalCategory') {
    $sidebarMenu[$menuCount]['count'] = $stat->categoriesNum;
   }
  }

  return $sidebarMenu;
 }
}