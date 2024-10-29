<?

class ViewedFilter extends PostFilter
{
  function filter($f)
  {
    if($f->type) return 'viewed';
  }
}