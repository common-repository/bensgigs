<?


class WordFilter extends RegexFilter
{
  function __construct($words, $type)
  {
    parent::__construct($words);
    $this->type = $type;
  }

  function filter($p)
  {
    preg_match($this->words, $p->search, $matches);
    if(count($matches)==0) return null;
    return $this->type;
  }
}
