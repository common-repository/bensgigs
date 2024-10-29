<?


function import_emails($s)
{
  $parts = preg_split("/\s+/m",trim($s));
  foreach($parts as $p)
  {
    $pieces = explode(":",$p);
    EmailAccount::create(array(
      'attributes'=>array(
        'login'=>$pieces[0],
        'password'=>$pieces[1],
      )
    ));
  }
}