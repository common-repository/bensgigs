<?

$features = Feature::find_all();

$skills = Skill::find_all(array(
  'order'=>'tag',
));

