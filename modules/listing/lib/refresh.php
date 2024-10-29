<?

function refresh_posts($api_key)
{
  $res = query_assoc("select post_id from bensgigs_gig_posts");
  $ids = collect($res,'post_id');
  $ws = new ClickWebService("http://www.benallfree.com/wp-admin/admin-ajax.php", array('api_key'=>$api_key));

  $arr = json_decode($ws->load('listings'),false);
  
  foreach($arr as $p)
  {
    if(!$p->title) continue;
    if(!$p->body) continue;
    if(!array_search($p->id,$ids)===false) continue;
  
    $g = GigPost::create(array(
      'attributes'=>array(
        'title'=>$p->title,
        'body'=>$p->body,
        'post_id'=>$p->id,
        'email'=>$p->email,
        'posted_at'=>strtotime($p->posted_on),
        'url'=>$p->url,
      )
    ));
  }
  
  score_posts();
}
