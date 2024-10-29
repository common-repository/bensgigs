<?

$ws = new ClickWebService("http://www.benallfree.com/wp-admin/admin-ajax.php", array('api_key'=>$this_plugin_settings->api_key));

if(is_postback())
{
  $key = trim(p('api_key'));
  $len = strlen('bd2001d81450cd97314ff5859ebb8541');
  if(strlen($key)!=$len)
  {
    $errors[] = "Invalid input. API key must be $len digits.";
  } else {
    $this_plugin_settings->api_key = $params['api_key'];
  }
}

