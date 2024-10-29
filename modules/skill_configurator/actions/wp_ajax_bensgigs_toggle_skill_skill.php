<?

$master_skill_id = p('master_skill_id');
$sub_skill_id = p('sub_skill_id');

$skill_skill = SkillSkill::find( array(
  'conditions'=>array('master_skill_id = ? and sub_skill_id = ?', $master_skill_id, $sub_skill_id),
));
if($skill_skill)
{
  $skill_skill->delete();
  dprint('deleted',false);
} else {
  $skill_skill = SkillSkill::create( array(
    'attributes'=>array(
      'master_skill_id'=>$master_skill_id,
      'sub_skill_id'=>$sub_skill_id,
    )
  ));
  dprint('added',false);
}
