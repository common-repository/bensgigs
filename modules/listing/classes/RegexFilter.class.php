<?

class RegexFilter extends PostFilter
{
  function __construct($words)
  {
    $pfx = '(^|[\W\s])';
    $sfx = '(?=[\W\s]|$)';
    $arr = array();
    foreach($words as $k)
    {
      $arr[] = $this->regexify($k);
    }
    $arr = "/$pfx(" . join("|",$arr) .")$sfx/im";
    $this->words = $arr;
  }
  
  function regexify($k)
  {
    if(startswith($k, '/') && endswith($k,'/'))
    {   
      $k = substr($k,1,strlen($k)-2);
    } else {
      $pieces = preg_split("/\s*,\s*/im", trim($k));
      $arr = array();
      foreach($pieces as $p)
      {
        $arr[] = preg_quote($p);
      }
      $arr = join('|',$arr);
      return $arr;
    }
    return $k;
  }
}