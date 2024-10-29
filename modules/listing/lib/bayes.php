<?

function score_posts()
{
  $training_posts = GigPost::find_all( array(
    'conditions'=>'type is not null',
  ));
  $b = new Bayes();
  foreach($training_posts as $p)
  {
    $b->train($p->search, $p->type, $p->id);
  }
  
  $unscored_posts = GigPost::find_all( array(
    'conditions'=>'score is null',
  ));
  foreach($unscored_posts as $p)
  {
    $p->score = $b->score($p->search);
    $p->save();
  }
}
