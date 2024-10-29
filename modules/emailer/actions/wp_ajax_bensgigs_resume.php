<?

$p = GigPost::find_by_id(p('id'));

$skills = Skill::find_all();

$skills = Skill::find_all(array('order'=>'id'));

$rm = new ResumeMaker(BENSGIGS_EMAILER_FPATH."/templates/resume.haml", $skills);
$email = $rm->create($p, BENSGIGS_EMAILER_FPATH."/templates/cover.haml");
$pdf = $rm->create($p, BENSGIGS_EMAILER_FPATH."/templates/resume.haml");

$pm = new PostManager();
$pm->addFilter(new WordHighlighter(collect($skills,'regex'), 'skill'));
$pm->calc($p);


$html = array(
  'body'=>$p->body,
  'email'=>$email,
  'pdf'=>$pdf,
);


header("Content-Type: text/javascript");
die(json_encode($html));