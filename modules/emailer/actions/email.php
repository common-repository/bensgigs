<?

$posts = GigPost::find_all( array(
  'conditions'=>"type = 'ham'",
  'order'=>'posted_at desc',
));

$skills = Skill::find_all(array(
  'order'=>'id'
));

$rm = new ResumeMaker(BENSGIGS_EMAILER_FPATH."/templates/cover.haml", $skills);

$account = EmailAccount::find( array(
  'order'=>'last_used asc'
));


$pm = new PostManager($posts);
$pm->addFilter(new WordHighlighter(collect($skills,'regex'), 'skill'));
$res = $pm->calc();


/*


$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "{$account->login}@gmail.com";  // GMAIL username
$mail->Password   = $account->password;            // GMAIL password


$mail->SetFrom('benallfree@gmail.com', 'Ben Allfree');

$address = "ben@launchpointsoftware.com";
$mail->AddAddress($address, "John Doe");

$mail->Subject    = "Re: {$post->title} [{$post->post_id}]";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($html);

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
  $account->last_used = time();
  $account->save();
}


*/
