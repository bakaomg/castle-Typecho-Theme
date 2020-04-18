<?php
/**
 * 文章和全站字数统计
 *
 * Last Update: 2020/04/18
 * https://github.com/elatisy/Typecho_WordsCounter/
 * https://github.com/Snowflake-Pink/WordCounter/
 */

class Castle_WordCounter {
 /**
  * 单个文章字数
  *
  * @access public
  * @param $archive
  * @return int
  */
  public static function charactersNum($archive) {
   return mb_strlen($archive->text,'UTF-8');
  }

 /**
  * 输出全站字数
  *
  * @access public
  * @return void
  * @throws Typecho_Db_Exception
  * @throws Typecho_Exception
  */
  public static function allOfCharacters() {
   $opts = (isset(Helper::options()->WordsCounterOpts)) ? Helper::options()->WordsCounterOpts : 0;

   $chars = 0;
   $db = Typecho_Db::get();
   if($opts == 0){
    $select = $db ->select('text')
                  ->from('table.contents')
                  ->where('table.contents.status = ?','publish');
   } else {
    $select = $db ->select('text')
                  ->from('table.contents');
   }

   $rows = $db->fetchAll($select);
   foreach ($rows as $row){
    $chars += mb_strlen($row['text'], 'UTF-8');
   }

   $unit = '';
   if($chars >= 10000) {
    $chars /= 10000;
    $unit = 'W';
   } else if($chars >= 1000) {
    $chars /= 1000;
    $unit = 'K';
   }

   $out = sprintf('%.2lf %s', $chars, $unit);

   return $out;
  }
}