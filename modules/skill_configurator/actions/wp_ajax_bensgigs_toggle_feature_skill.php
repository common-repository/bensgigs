<?

$feature_id = p('feature_id');
$skill_id = p('skill_id');

$feature_skill = FeatureSkill::find( array(
  'conditions'=>array('feature_id = ? and skill_id = ?', $feature_id, $skill_id),
));
if($feature_skill)
{
  $feature_skill->delete();
  dprint('deleted',false);
} else {
  $feature_skill = FeatureSkill::create( array(
    'attributes'=>array(
      'feature_id'=>$feature_id,
      'skill_id'=>$skill_id,
    )
  ));
  dprint('added',false);
}
