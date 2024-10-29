<?
$ws = new ClickWebService("http://www.benallfree.com/wp-admin/admin-ajax.php", array('api_key'=>$this_plugin_settings->api_key));

$posts = GigPost::find_all(array(
  'limit'=>10,
  'order'=>'score desc',
));

$skills = collect(Skill::find_all(array('order'=>'id')), 'regex');
$keywords = collect(Keyword::find_all(array('conditions'=>"type='keyword'")),'word');
$killwords = collect(Keyword::find_all(array('conditions'=>"type='killword'")), 'word');

$pm = new PostManager($posts);
$pm->addFilter(new WordHighlighter($skills, 'skill'));
$pm->addFilter(new WordHighlighter($killwords, 'killword'));
$pm->addFilter(new WordHighlighter($keywords, 'keyword'));
$pm->addFilter(new ViewedFilter());
$pm->addFilter(new WordFilter($killwords, 'killword'));
$pm->addFilter(new WordFilter($keywords, 'keyword'));
$res = $pm->calc();

foreach($res['all_posts'] as $p_id)
{
  $p = $posts[$p_id];
  $p->cache();
}

$this_plugin_settings->last_access = time();