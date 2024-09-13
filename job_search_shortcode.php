<?php

function get_template_option_khu_vuc() {
  $specifications_group_id = 'group_66e1259f5d395';// group khu vuc

  $location = 'all';
  if (isset($_GET['location'])) {
    $location = $_GET['location'];
  }
   $selected = $location == 'all'?'selected':'';
   $result ='<option value="all" '.$selected.'>Tất cả</option>';

  $fields = acf_get_fields( $specifications_group_id );

  foreach ( $fields as $field ) {
    if ($field['name'] =='khu_vuc') {
      // var_dump($field['choices']); exit(0);
      $choices = $field['choices'];
      foreach ( $choices as $choice )
      {
        $selected = $location == $choice?'selected':'';
        $result = $result.'<option value="'.$choice.'" '.$selected.'>'.$choice.'</option>';
      }
    }

  }
  return $result;

}

function get_template_job_tag()
{
  $template_tag = '<div class="row" id="tags-box-container">
            <div class="col medium-12 small-12 large-12">                              
            {list_tags}
            </div>
        </div>';


  $terms = get_terms(array(
    'taxonomy' => 'job-tag',
    'hide_empty' => false, // Show terms even if they have no posts
  ));
  $list_tags = '';

  // Check if there are any terms
  if ($terms) {
    foreach ($terms as $term) {
      $term_link = get_term_link($term);
      $list_tags = $list_tags . '<div class="tag"><a href ="' . $term_link . '" >' . $term->name . '</a></div>';
    }
  }

  $template_tag = str_replace('{list_tags}', $list_tags, $template_tag);
  return $template_tag;
}

function job_search_shortcode_function($atts, $content = null, $tag = '')
{
  $search = '';
  if (isset($_GET['search'])) {
    $search = $_GET['search'];
  }

  $template_form = '<div id="search-box-container"> <form action ="" method ="get">
                         <div class="row" >                                 
                            <div class="col medium-3 small-12 large-3">
                                <div class="col-inner">
                                <div class="">
                                    <div class="search-dropdown">       
                                    <div class="select">
                                            <select name="location" id="location">                              
                                                {option_khu_vuc}
                                            </select>
                                        </div>
                                    </div>       
                                    
                                </div>
                                </div>
                            </div>
                            <div class="col medium-9 small-12 large-9">
                                <div class="col-inner">
                                <div class="">
                                    <div class="text-search-box">       
                                        <input type="text" id="search" name="search" placeholder="Vị trí công việc, chức danh..." value="'.$search.'">
                                        <button type="submit">Tìm kiếm nhanh</button>
                                    </div>       
                                </div>
                                </div>
                            </div>
                        </div> 
                    </form></div>';


  $list_options = get_template_option_khu_vuc();
  $template_form = str_replace('{option_khu_vuc}', $list_options, $template_form);


  echo $template_form . get_template_job_tag();
}