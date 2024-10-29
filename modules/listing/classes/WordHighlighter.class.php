<?



class WordHighlighter extends RegexFilter
{
  function __construct($words, $type)
  {
    parent::__construct($words);
    $this->type = $type;
  }

  
  function filter($p)
  {
    $this->highlight($p);
  }
  
  function highlight($p)
  {
    foreach(array('title','body') as $field_name)
    {
      $p->$field_name = preg_replace($this->words, "\$1<span class='{$this->type}'>\$2</span>", $p->$field_name);
    }
  } 
}