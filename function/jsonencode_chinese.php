<?php
/**
 * json_encode 不转义中文字符
 * JSON_UNESCAPED_UNICODE php5.4版本以上可用
 * callback0|callback1 都可做回调函数
 */

function callback0($matches){
    return iconv('UCS-2BE', 'UTF-8', pack('H4', $matches[1]));
}

function callback1($matches){
    $a = '{"str":"'.$matches[0].'"}';
    $b = json_decode($a, true);
    return $b['str'];
}

function json_encode_ch($array){
  if(version_compare(PHP_VERSION,'5.4.0','<')){
      $str = json_encode($array);
      $str = preg_replace_callback("#\\\u([0-9a-f]{4})#i", 'callback0', $str); //低版本php不支持匿名函数
      return $str;
  }else{
      return json_encode($array, JSON_UNESCAPED_UNICODE);
  }
}