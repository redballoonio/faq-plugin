<?php
// Shortcode.php
function rbd_faqs_shortcode( $atts, $content = null)  {

    wp_enqueue_style('faqs-styles');
    wp_enqueue_script('faqs-scripts');

    extract( shortcode_atts( array(
    			'cat' => '',                 		// Category ID to display cat="1,2"] Defaults to all.
                'exclude' => '',             		// ids of the questions to be excluded from the list
                'title' => 'hide',              	// SHOW/HIDE the Category Title (default is show)
                'show_question' => 'close',		   // show/close/first question (default is closed)
                'show_category' => 'close',	    	// show/close/first category (default is closed)
                'collapsable' => 'question',		// Category, Question, both or none. Sets up the collapsability of the plugin.
                'icon' => 'none',                   // Type of close icon. default none. Types: arrow, plus.
                'iconalt' => ''                    	// Icon for question. Class added to individual faqs. set none to remove icons from questions. Types: arrow, plus.
            ), $atts
        )
    );

	// Variables for the loop
	$count = 1;
	$combinedOutput = '';
	$cat = $cat;
	$exclude = $exclude;
    $collapseTitle = false;
    $collapseQuestion = false;
    if ($collapsable == 'category' ||  $collapsable == 'both') {
        $collapseTitle = true;
    }
    if ($collapsable == 'question' ||  $collapsable == 'both') {
        $collapseQuestion = true;
    }

    $iconClass = '';
    if ($icon != 'none') {
        $iconClass = $icon;
    }
    $combinedOutput .= '<div class="rbd-faq-section '.$iconClass.'">';

	// Get the categories
	$faqs_cats = get_terms('faqs_cat', 'orderby=count&order=ASC&hide_empty=true&include='.$cat.'');
    static $catCount = 0;

    // If there is a target Question GET variable:
    $targetQuestion = 0;
    if ( isset($_GET['targetQuestion']) ) {
        $targetQuestion = intval($_GET['targetQuestion']);
    }


	// For each required category....
	foreach( $faqs_cats as $faqs_cat ) {

        $catCount++ ;
        $catTitle = '';
        $combinedOutput .= '<div class="rbd-faq-category">';

        // Get the posts from this category
		$faqs_cpt_args = array(
			 'posts_per_page' => 200,
			 'post_type' => 'faqs',
			 'taxonomy' => $faqs_cat->taxonomy,
			 'term' => $faqs_cat->slug,
			 'post_status' => 'publish',
             'exclude' => $exclude
		);

        // Output the questions from this category
		$faqs_cpt = get_posts( $faqs_cpt_args );

        $overRideShow = false;
        foreach($faqs_cpt as $faq) {
            if ($faq->ID == $targetQuestion) {
                $overRideShow = true;
            }
        }


        $showCategory = false;
        if ($show_category === 'first' AND $overRideShow === false AND $catCount === 1 OR $show_category === 'show' OR $overRideShow === true) {
            $showCategory = true;
        }

        if ($title != 'hide') {
            $catTitle .= '<div class="rbd-faq-cat-title"><h4>'.$faqs_cat->name.'</h4></div>';
		}


        if ($collapseTitle) {
            $combinedOutput .= '<a class="show-hide ';
            if ($showCategory) {
                $combinedOutput .= 'open';
            }
            $combinedOutput .= '" href="#" rel="#sliding-cat-'.$catCount.'">';
            $combinedOutput .= $catTitle;
            $combinedOutput .= '<div class="close-icon"></div></a>';
            $combinedOutput .= '<div id="sliding-cat-'.$catCount.'" class="sliding-div"';
            if ($showCategory) {
                $combinedOutput .= 'style="display:block;"';
            }
            else {
                $combinedOutput .= 'style="display:none;"';
            }
            $combinedOutput .= '>';


        } else {
            $combinedOutput .= $catTitle;
        }

        $questionCount = 1;
		foreach($faqs_cpt as $faq) {

            $questionOutput 	 = '';
            $closeIcon = '';
            $showQuestion = false;
            if ($questionCount === 1 AND $show_question === 'first' AND $targetQuestion === 0 OR $show_question === 'show' OR $faq->ID === $targetQuestion) {
                $showQuestion = true;
            }
			$questionOutput 	.= '<div class="rbd-faq '.$iconalt.'" id="rbd-faq-question-'.$faq->ID.'">';
			if ($collapseQuestion){
				$questionOutput 	.= '<a class="show-hide';
				if ($showQuestion) {
                    $questionOutput 	.= ' open';
				}
				$questionOutput 	.= '" href="#" rel="#sliding-div-'.$catCount.'-'.$questionCount.'">';
				$closeIcon = '<div class="close-icon"></div><!--close-icon--></a>';
			}
			// Question
			$questionOutput 	.= '<div class="rbd-faq-question">';
			$questionOutput 	.= $faq->post_title;
			$questionOutput 	.= '</div><!--question-->'.$closeIcon.'<!--show_hide-->';
			// Answer
			if ($collapseQuestion){
				$questionOutput 	.= '<div id="rbd-faq-sliding-div-'.$catCount.'-'.$questionCount.'" class="rbd-faq-sliding-div answer"';

				if ($showQuestion) {
					$questionOutput .= ' style="display:block;"> ';
				}

				else{
					$questionOutput .= ' style="display:none;"> ';
				}
			} else {
				$questionOutput     .= '<div class="rbd-faq-answer">';
			}
			$questionOutput 	.= $faq->post_content;
			$questionOutput 	.= '</div><!--rbd-faq-sliding-div--></div><!--faq-->';
            $combinedOutput 	.= $questionOutput;
            $questionCount++;
		}
        if ($collapseTitle) {
            $combinedOutput .= '</div><!--rbd-faq-sliding-cat-'.$catCount.'-->';
        }
        $combinedOutput .= '</div><!--rbd-faq-category-->';
	}
    $combinedOutput .= '</div><!--rbd-faq-faq-section-->';
	return $combinedOutput;
}
?>
