<?
$p = $gig_post;

$search = array('/&ndash;/');
$replace = array('-');
$s = htmlentities($p->title, null, 'utf-8');
$s = preg_replace($search, $replace, $s);
$p->title = $s;


$p->search = $p->title . ' ' . strip_tags($p->body);

