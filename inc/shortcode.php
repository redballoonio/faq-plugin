<?php
// Shortcode.php
function rbd_faqs_shortcode( $atts, $content = null)  {
    wp_enqueue_style('rbd-faqs-styles');
    wp_enqueue_script('rbd-faqs-scripts');

    extract( shortcode_atts( array(
    			'cat' => '',                 		// Category slug to display Defaults to all.
                'exclude' => '',             		// ids of the questions to be excluded from the list
                'title' => 'show',              	// SHOW/HIDE the Category Title (default is show)
                'show_question' => 'close',		   // show/close/first question (default is closed)
                'show_category' => 'close',	    	// show/close/first category (default is closed)
                'collapsable' => 'question',		// Category, Question, both or none. Sets up the collapsability of the plugin.
                'icon' => 'none',                   // Type of close icon. default none. Types: arrow, plus.
                'icon_secondary' => ''                    	// Icon for question. Class added to individual faqs. set none to remove icons from questions. Types: arrow, plus.
            ), $atts
        )
    );

	// Variables for the loop
	$count = 1;
	$combined_output = '';
	$cat = $cat;
	$exclude = $exclude;
    $collapse_title = false;
    $collapse_question = false;

    if ($collapsable == 'category' ||  $collapsable == 'both') {
        $collapse_title = true;
    }
    if ($collapsable == 'question' ||  $collapsable == 'both') {
        $collapse_question = true;
    }

    $icon_class = '';
    if ($icon != 'none') {
        $icon_class = $icon;
    }

    $combined_output .= '<div class="rbd-faq-section '.$icon_class.'">';

	// Get the categories
    $cat = preg_replace('/\s+/', '', $cat);
    $cats = explode(',', $cat );

    $faqs_cats = get_terms('faqs_cat');

    static $cat_count = 0;

    // If there is a target Question GET variable:
    $target_question = isset($_GET['targetQuestion']) ? intval($_GET['targetQuestion']) : 0 ;

	// For each category....
    if (count($faqs_cats)>0 && ($title == 'show' OR ($collapsable == 'both' OR $collapsable == 'category'))){
        foreach( $faqs_cats as $faqs_cat ) {
            // If the cat isn't included:
            if ( count($cats) > 0 AND strlen($cats[0]) > 0 AND !in_array($faqs_cat->slug, $cats) ){
                continue;
            }

            $cat_count++ ;
            $cat_title = '';
            $combined_output .= '<div class="rbd-faq-category">';

            // Get the posts from this category
            $faqs_cpt_args = array(
                'posts_per_page' => 200,
                'post_type' => 'faqs',
                'orderby' => 'menu_order',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'faqs_cat',
                        'field' => 'slug',
                        'terms' => array($faqs_cat->slug),
                        'operator' => 'IN'
                    )
                ),
                'post_status' => 'publish',
                'exclude' => $exclude
            );

            // Output the questions from this category
            $faqs_cpt = get_posts( $faqs_cpt_args );

            $over_ride_show = false;

            foreach($faqs_cpt as $faq) {
                if ($faq->ID == $target_question) {
                    $over_ride_show = true;
                }
            }

            $show_category_bool = false;
            
            if (($show_category === 'first' AND $over_ride_show === false AND $cat_count === 1) OR 
                $show_category === 'show' OR 
                $over_ride_show === true) {
                $show_category_bool = true;
            }

            if ($title != 'hide' ) {
                $cat_title .= '<div class="rbd-faq-cat-title"><h4>'.$faqs_cat->name.'</h4></div>';
            }


            if ($collapse_title) {
                $combined_output .= '<a role="button" class="show-hide';
                if ($show_category_bool) {
                    $combined_output .= ' open';
                }
                $combined_output .= '" href="#" rel="#rbd-faq-sliding-cat-'.$cat_count.'">';
                $combined_output .= $cat_title;
                $combined_output .= '<div class="close-icon"></div></a>';
                $combined_output .= '<div id="rbd-faq-sliding-cat-'.$cat_count.'" class="rbd-faq-sliding-div"';
                if ($show_category_bool) {
                    $combined_output .= 'style="display:block;"';
                }
                else {
                    $combined_output .= 'style="display:none;"';
                }
                $combined_output .= '>';

            } else {
                $combined_output .= $cat_title;
            }

            $question_count = 1;

            foreach($faqs_cpt as $faq) {

                $question_output = '';
                $closeIcon = '';
                $showQuestion = false;

                if ($question_count === 1 AND 
                    $show_question === 'first' AND 
                    $target_question === 0 OR 
                    $show_question === 'show' 
                    OR $faq->ID === $target_question) {
                    $showQuestion = true;
                }

                $question_output 	.= '<div class="rbd-faq '.$icon_secondary.'" id="rbd-faq-question-'.$faq->ID.'">';

                if ($collapse_question){
                    $question_output 	.= '<a role="button" class="show-hide';
                    if ($showQuestion) {
                        $question_output 	.= ' open';
                    }
                    $question_output 	.= '" href="#" rel="#rbd-faq-sliding-div-'.$cat_count.'-'.$question_count.'">';
                    $closeIcon = '<div class="close-icon"></div><!--close-icon--></a>';
                }
                // Question
                $question_output 	.= '<div class="rbd-faq-question">';
                $question_output 	.= $faq->post_title;
                $question_output 	.= '</div><!--question-->'.$closeIcon.'<!--show_hide-->';
                // Answer
                if ($collapse_question){
                    $question_output 	.= '<div id="rbd-faq-sliding-div-'.$cat_count.'-'.$question_count.'" class="rbd-faq-sliding-div rbd-faq-answer"';

                    if ($showQuestion) {
                        $question_output .= ' style="display:block;"> ';
                    }

                    else{
                        $question_output .= ' style="display:none;"> ';
                    }
                } else {
                    $question_output     .= '<div class="rbd-faq-answer">';
                }
                $question_output 	.= $faq->post_content;
                $question_output 	.= '</div><!--rbd-faq-sliding-div--></div><!--faq-->';
                $combined_output    .= $question_output;
                $question_count++;
            }

            if ($collapse_title) {
                $combined_output .= '</div><!--rbd-faq-sliding-cat-'.$cat_count.'-->';
            }
            $combined_output .= '</div><!--rbd-faq-category-->';
        }
    } else {
        $faqs_cpt_args = array(
            'posts_per_page' => 200,
            'post_type' => 'faqs',
            'post_status' => 'publish',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'exclude' => $exclude
        );

        $faqs_cpt = get_posts( $faqs_cpt_args );
        $question_count = 1;
        $cat_count = 0;
        
        foreach($faqs_cpt as $faq) {
            $question_output = '';
            $closeIcon = '';
            $showQuestion = false;

            if ($question_count === 1 AND 
                $show_question === 'first' AND 
                $target_question === 0 OR 
                $show_question === 'show' 
                OR $faq->ID === $target_question) {
                $showQuestion = true;
            }

            $question_output 	.= '<div class="rbd-faq '.$icon_secondary.'" id="rbd-faq-question-'.$faq->ID.'">';

            if ($collapse_question){
                $question_output 	.= '<a role="button" class="show-hide';
                if ($showQuestion) {
                    $question_output 	.= ' open';
                }
                $question_output 	.= '" href="#" rel="#rbd-faq-sliding-div-'.$cat_count.'-'.$question_count.'">';
                $closeIcon = '<div class="close-icon"></div><!--close-icon--></a>';
            }
            // Question
            $question_output 	.= '<div class="rbd-faq-question">';
            $question_output 	.= $faq->post_title;
            $question_output 	.= '</div><!--question-->'.$closeIcon.'<!--show_hide-->';
            // Answer
            if ($collapse_question){
                $question_output 	.= '<div id="rbd-faq-sliding-div-'.$cat_count.'-'.$question_count.'" class="rbd-faq-sliding-div rbd-faq-answer"';

                if ($showQuestion) {
                    $question_output .= ' style="display:block;"> ';
                }

                else{
                    $question_output .= ' style="display:none;"> ';
                }
            } else {
                $question_output     .= '<div class="rbd-faq-answer">';
            }
            $question_output 	.= $faq->post_content;
            $question_output 	.= '</div><!--rbd-faq-sliding-div--></div><!--faq-->';
            $combined_output    .= $question_output;
            $question_count++;
        }
        
    };

    $combined_output .= '</div><!--rbd-faq-faq-section-->';

    $combined_output .= rbd_faqs_output_colours();


	return $combined_output;
}


function rbd_faqs_output_colours(){
    $options = array(
        'question_color' => esc_attr( get_option( 'rbd-faq-question-color' ) ),
        'question_bg' => esc_attr( get_option( 'rbd-faq-question-bg' ) ),
        'category_color' => esc_attr( get_option( 'rbd-faq-category-color' ) ),
        'category_bg' => esc_attr( get_option( 'rbd-faq-category-bg' ) ),
        'answer_color' => esc_attr( get_option( 'rbd-faq-answer-color' ) ),
        'answer_bg' => esc_attr( get_option( 'rbd-faq-answer-bg' ) ),
        'icon_color' => esc_attr( get_option( 'rbd-faq-icon-color' ) )
    );
    $inline_css = "
    <style>
        .rbd-faq-answer{ 
            background: ${options['answer_bg']};
            color: ${options['answer_color']};
        }
        .rbd-faq-section .show-hide{ 
            background: ${options['question_bg']};
            color: ${options['question_color']};
        }
        .rbd-faq-section .show-hide:hover,
        .rbd-faq-section .show-hide:focus,
        .rbd-faq-section .show-hide:active{
            color: ${options['question_color']};
        }

        .rbd-faq-category>.show-hide,
        .rbd-faq-cat-title { 
            background: ${options['category_bg']};
            color: ${options['category_color']};
        }

        .rbd-faq-section .close-icon { 
            color: ${options['icon_color']};
        }
    </style>";
    return $inline_css;
};
?>