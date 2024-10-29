<?

class PostManager
{
  function __construct($posts=array())
  {
    $this->posts = $posts;
    $this->filters = array();
  }
  
  function addFilter($f)
  {
    $this->filters[] = $f;
  }
  
  function calc($post = null)
  {
    $posts = $this->posts;
    if($post) $posts = array($post);
    $res = array();
    foreach($posts as $post)
    {
      $res['all_posts'][] = $post->id;
      foreach($this->filters as $f)
      {
        $class = $f->filter($post);
        if($class) 
        {
          $res[$class][] = $post->id;
          break;
        }
      }
    }
    
    return $res;
  }
}