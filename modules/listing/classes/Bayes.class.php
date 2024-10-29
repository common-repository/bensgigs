<?

class Bayes
{
  function __construct()
  {
    $this->tokens = array();
    $this->training = array();
    $this->exceptions = array(
      "/n't/" => "not",
      "/'ll/" => "will",
      "/asp\.net/"=>"aspdotnet",
      "/'m/" => "am",
    );
    $this->zero_value = 0.1;
    
  }
  
  function train($s, $type, $key)
  {
    $tokens = $this->tokenize($s);
    foreach($tokens as $t)
    {
      $this->add_token($t,$type);
    }
    $this->training[$key] = array('created_at'=>time(), 'type'=>$type, 'tokens'=>$tokens );
  }
  
  function add_token($t,$type)
  {
    if(!$this->tokens[$t]) $this->tokens[$t]=array('spam'=>0, 'ham'=>0);
    $this->tokens[$t][$type]+=1;
    $this->recalc_token($t);
  }
  
  function recalc_token($t)
  {
    extract($this->tokens[$t]);
    if($ham==0) $ham=$this->zero_value;
    if($spam==0) $spam=$this->zero_value;
    $ham *= 1.0;
    $spam *= 1.0;
    if($ham>=$spam) $ratio=$ham/$spam;
    if($spam>$ham) $ratio = -$spam/$ham;
    $this->tokens[$t]['ratio'] = round($ratio,2);
  }
  
  function tokenize($s,$allow_duplicates = false)
  {
    $search = strip_tags($s);
    $search = preg_replace(array_keys($this->exceptions), array_values($this->exceptions), $search);
    $search = preg_replace("/[\s\W]+/", ' ', $search);
    $search = trim(strtolower($search));
    $arr = array_unique(explode(' ',$search));
    $tokens = array();
    foreach($arr as $t)
    {
      if(strlen($t)<=2) continue;
      $tokens[] = $t;
    }
    if(!$allow_duplicates) $tokens = array_unique($tokens);
    return $tokens;
  }
  
  function score($s)
  {
    $tokens = $this->tokenize($s,true);
    $score = 0;
    foreach($tokens as $t)
    {
      if(!isset($this->tokens[$t])) continue;
      $score+=$this->tokens[$t]['ratio'];
    }
    return round($score,2);
  }
}
