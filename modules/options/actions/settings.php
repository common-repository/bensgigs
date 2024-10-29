<?

if(is_postback())
{
  foreach(array('keywords', 'killwords') as $k)
  {
    $words = explode(',', p($k));
    $arr = array();
    foreach($words as $w)
    {
      $w = trim($w);
      if(!$w) continue;
      $arr[] = $w;
    }
    $this_plugin_settings->options->$k = $arr;
  }
  
  flash('Updated');
}

