<?

$p = GigPost::find_by_id(p('id'));
$p->type = p('type');
$p->save();