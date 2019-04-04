<?php
/**
 * json_encode 不转义中文字符
 * JSON_UNESCAPED_UNICODE php5.4版本以上可用
 */
function json_encode_ch($array){
  if(version_compare(PHP_VERSION,'5.4.0','<')){
      $str = json_encode($array);
      $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i",function($matchs){
          return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
      },$str);
      return $str;
  }else{
      return json_encode($array, JSON_UNESCAPED_UNICODE);
  }
}