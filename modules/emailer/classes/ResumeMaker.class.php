<?

class ResumeMaker
{
  function __construct($template_fpath, $skills)
  {
    $this->skills = $skills;
    $this->html = '';
    $this->template_fpath = $template_fpath;
    $this->samples = array();

  }
  
  
  function create($post, $fpath = null)
  {
    if(!$fpath) $fpath = $this->template_fpath;
    $matched_skills = $this->matched_skills($post);
    $list = collect($matched_skills, 'tag');
    if(count($list)>1) $list[count($list)-1] = "and " . $list[count($list)-1];
    $this->skills_list = join(', ',$list);
    $lines = collect($matched_skills, 'short');
    $this->skill_lines = $lines;
    $long = array();
    foreach($matched_skills as $m) $long[$m->tag] = $m->long;
    $this->skill_paragraphs = $long;  
    
    $skills_by_sample = $this->skills_by_sample($matched_skills);
    
    $scores = array();
    $sample_keys = array_keys($skills_by_sample);
    $sample_sets = $this->permute(count($sample_keys), 6);

    // What set offers the most coverage with the best score?
    $skill_coverages = array();
    foreach($sample_sets as $sample_set_idx=>$sample_set)
    {
      $skill_coverage = array();
      foreach($sample_set as $sample_id_idx)
      {
        $sample_key = $sample_keys[$sample_id_idx];
        $skills = $skills_by_sample[$sample_key];
        foreach(array_keys($skills) as $skill_key)
        {
          if(!isset($skill_coverage[$skill_key])) $skill_coverage[$skill_key]=0;
          $skill_coverage[$skill_key]++;
        }
      }
      $skill_coverages[$sample_set_idx] = $skill_coverage;
    }
    
    uasort($skill_coverages,array($this,'sort_by_coverage_and_score'));

    $set_indexes = array_keys($skill_coverages);
    $best_set_idx = $set_indexes[0];
    $sample_key_indexes = $sample_sets[$best_set_idx];
    $best_sample_keys = array();
    foreach($sample_key_indexes as $sample_key_idx)
    {
      $best_sample_keys[] = $sample_keys[$sample_key_idx];
    }
    
    $best_sample_ids = array();
    foreach($best_sample_keys as $key)
    {
      list($sample_id, $sample_tag) = explode(':',$key);
      $best_sample_ids[] = $sample_id;
    }
    $best_sample_ids = join(',',$best_sample_ids);
    $this->samples = Sample::find_all( array(
      'conditions'=>array('id in (!)', $best_sample_ids),
    ));
    
    $matched_skill_ids = collect($matched_skills, 'id');
    foreach($this->samples as $sample)
    {
      $sample->matched_skills = array();
      foreach($sample->skills as $skill)
      {
        if(array_search($skill->id, $matched_skill_ids)===false) continue;
        $sample->matched_skills[] = $skill;
      }
    }
    
    

    $args = array('rm'=>$this, 'post'=>$post);
    $html= eval_haml($fpath, $args, true);
    $this->html = $html;
    
    return $html;
  }
  
  
  function skills_by_sample($matched_skills)
  {
    $skills_by_sample = array();
    foreach($matched_skills as $skill)
    {
      foreach($skill->samples as $sample)
      {
        if($sample->is_adult && $skill->id!=148) continue; // skip adult content
        $sample_key = "{$sample->id}:{$sample->title}";
        if(!isset($skills_by_sample[$sample_key])) $skills_by_sample[$sample_key] = array();
        $skill_key = "{$skill->id}:{$skill->tag}";
        $skills_by_sample[$sample_key][$skill_key] = true;
      }
    }
    return $skills_by_sample;
  }
  
  function matched_skills($post)
  {
    $matched_skills = array();
    foreach($this->skills as $skill)
    {
      $wf = new WordFilter(array($skill->regex), 'skill');
      $res = $wf->filter($post);
      if(!$res) continue;
      $matched_skills[] = $skill;
    }
    return $matched_skills;
  }
  
  function permute($count, $size)
  {
    $sets = array();
    for($i=0;$i<$count-$size+1;$i++)
    {
      for($j=$i+1;$j<=$count-$size+1;$j++)
      {
        $set = array($i);
        $sets[] = array_merge($set, range($j, $j+$size-2));
      }
    }
    return $sets;
  }
    
      
  function sort_by_coverage_and_score($a,$b)
  {
    if(count($a)>count($b)) return -1;
    if(count($b)>count($a)) return 1;
    $sa = array_sum($a);
    $sb = array_sum($b);
    if($sa>$sb) return -1;
    if($sb>$sa) return 1;
    return 0;
  }
  
  
  function pdf($post)
  {
    $html = $this->create($post);
    echo($html);
  }
}
