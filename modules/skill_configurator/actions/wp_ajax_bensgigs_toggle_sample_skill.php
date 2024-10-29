<?

$sample_id = p('sample_id');
$skill_id = p('skill_id');

$sample_skill = SampleSkill::find( array(
  'conditions'=>array('sample_id = ? and skill_id = ?', $sample_id, $skill_id),
));
if($sample_skill)
{
  $sample_skill->delete();
  dprint('deleted',false);
} else {
  $sample_skill = SampleSkill::create( array(
    'attributes'=>array(
      'sample_id'=>$sample_id,
      'skill_id'=>$skill_id,
    )
  ));
  dprint('added',false);
}
