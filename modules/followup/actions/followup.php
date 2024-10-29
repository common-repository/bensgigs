<?
$ws = new ClickWebService("http://www.benallfree.com/wp-admin/admin-ajax.php", array('api_key'=>$this_plugin_settings->api_key));

//score_posts();

$posts = GigPost::find_all(array(
  'conditions'=>array('type = ?', 'ham'),
  'order'=>'posted_at desc',
));


$pm = new PostManager($posts, $b);
$pm->addFilter(new WordHighlighter(collect($this_plugin_settings->options->skills,'regex'), 'skill'));
$pm->addFilter(new WordHighlighter($this_plugin_settings->options->killwords, 'killword'));
$pm->addFilter(new WordHighlighter($this_plugin_settings->options->keywords, 'keyword'));
$res = $pm->calc();
$this_plugin_settings->last_access = time();