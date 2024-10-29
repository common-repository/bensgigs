<?

if(is_postback())
{
  $key = trim(p('api_key'));
  $len = strlen('bd2001d81450cd97314ff5859ebb8541');
  if(strlen($key)!=$len)
  {
    $errors[] = "Invalid input. API key must be $len digits.";
  } else {
    $this_plugin_settings->api_key = $params['api_key'];
    flash_next("Your Day Pass has been activated.");
    js_redirect_to(page_url('bensgigs'));
  }
}
