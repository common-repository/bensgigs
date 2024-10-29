<?

$p = GigPost::find_by_id(p('id'));
$skills = Skill::find_all();

$skills = Skill::find_all(array(
  'order'=>'id'
));

$rm = new ResumeMaker(BENSGIGS_EMAILER_FPATH."/templates/resume.haml", $skills);
$html = $rm->create($p);

//die($html);
require_once($this_module_fpath."/lib/dompdf/dompdf_config.inc.php");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_base_path(ROOT_FPATH);
$dompdf->render();

$dompdf->stream("sample.pdf", array('attachment'=>false));
die;

