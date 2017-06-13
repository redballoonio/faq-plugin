<?php

/*
Register the settings and setting section.
*/

function rbd_faqs_settings_register($post_id){

    // Admin section:
    add_settings_section( 'rbd-faq-settings-1', 'FAQ Settings', 'rbd_faq_settings_section_1_output', 'rbd-faq-options' );


    // TODO: merge these into one setting, saved as an array.

    // Add settings
    add_settings_field( 'rbd-faq-question-color', 'Question Color', 'rbd_faq_question_color_output', 'rbd-faq-options', 'rbd-faq-settings-1');
    add_settings_field( 'rbd-faq-question-bg', 'Question Background', 'rbd_faq_question_bg_output', 'rbd-faq-options', 'rbd-faq-settings-1');

    add_settings_field( 'rbd-faq-category-color', 'Category Color', 'rbd_faq_category_color_output', 'rbd-faq-options', 'rbd-faq-settings-1');
    add_settings_field( 'rbd-faq-category-bg', 'Category Background', 'rbd_faq_category_bg_output', 'rbd-faq-options', 'rbd-faq-settings-1');

    add_settings_field( 'rbd-faq-answer-color', 'Answer Color', 'rbd_faq_answer_color_output', 'rbd-faq-options', 'rbd-faq-settings-1');
    add_settings_field( 'rbd-faq-answer-bg', 'Answer Background', 'rbd_faq_answer_bg_output', 'rbd-faq-options', 'rbd-faq-settings-1');

    add_settings_field( 'rbd-faq-icon-color', 'Icon color', 'rbd_faq_icon_color_output', 'rbd-faq-options', 'rbd-faq-settings-1');

    // Register setting to be tracked by wordpress:
    register_setting( 'rbd-faq-settings-1', 'rbd-faq-question-color' );
    register_setting( 'rbd-faq-settings-1', 'rbd-faq-question-bg' );

    register_setting( 'rbd-faq-settings-1', 'rbd-faq-category-color' );
    register_setting( 'rbd-faq-settings-1', 'rbd-faq-category-bg' );

    register_setting( 'rbd-faq-settings-1', 'rbd-faq-answer-color' );
    register_setting( 'rbd-faq-settings-1', 'rbd-faq-answer-bg' );

    register_setting( 'rbd-faq-settings-1', 'rbd-faq-icon-color' );
};


function rbd_faq_settings_section_1_output() {
    ?>
    <p>These options can be used to change the style of the outputted FAQs.
    <p><em>These options must be a <a href="https://www.w3schools.com/colors/default.asp" target="_blank">valid css colour</a>.</em></p>
    <?php
};

function rbd_faq_question_color_output(){
    $setting = esc_attr( get_option( 'rbd-faq-question-color' ) );
    echo '<input type="text" name="rbd-faq-question-color" value="' . $setting . '" />';
}
function rbd_faq_question_bg_output(){
    $setting = esc_attr( get_option( 'rbd-faq-question-bg' ) );
    echo '<input type="text" name="rbd-faq-question-bg" value="' . $setting . '" />';
}

function rbd_faq_category_color_output(){
    $setting = esc_attr( get_option( 'rbd-faq-category-color' ) );
    echo '<input type="text" name="rbd-faq-category-color" value="' . $setting . '" />';
}
function rbd_faq_category_bg_output(){
    $setting = esc_attr( get_option( 'rbd-faq-category-bg' ) );
    echo '<input type="text" name="rbd-faq-category-bg" value="' . $setting . '" />';
}

function rbd_faq_answer_color_output(){
    $setting = esc_attr( get_option( 'rbd-faq-answer-color' ) );
    echo '<input type="text" name="rbd-faq-answer-color" value="' . $setting . '" />';
}
function rbd_faq_answer_bg_output(){
    $setting = esc_attr( get_option( 'rbd-faq-answer-bg' ) );
    echo '<input type="text" name="rbd-faq-answer-bg" value="' . $setting . '" />';
}

function rbd_faq_icon_color_output(){
    $setting = esc_attr( get_option( 'rbd-faq-icon-color' ) );
    echo '<input type="text" name="rbd-faq-icon-color" value="' . $setting . '" />';
}

// TODO: add this server side validation
function rbd_faq_validate_html_color($color, $named) {
  /* Validates hex color, adding #-sign if not found. Checks for a Color Name first to prevent error if a name was entered (optional).
  *   $color: the color hex value stirng to Validates
  *   $named: (optional), set to 1 or TRUE to first test if a Named color was passed instead of a Hex value
  */
 
  if ($named) {
 
    $named = array('aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen', 'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 'yellow', 'yellowgreen');
 
    if (in_array(strtolower($color), $named)) {
      /* A color name was entered instead of a Hex Value, so just exit function */
      return $color;
    }
  }
 
  if (preg_match('/^#[a-f0-9]{6}$/i', $color)) {
    // Verified OK
  } else if (preg_match('/^[a-f0-9]{6}$/i', $color)) {
    $color = '#' . $color;
  }
  return $color;
}


add_action( 'admin_init', 'rbd_faqs_settings_register', 10, 1 );


//Add settings to menu
function rbd_faq_options_add_page() {
    add_submenu_page( 'edit.php?post_type=faqs', 'FAQ Options', 'Options', 'manage_options', 'rbd-faq-options', 'rbd_faq_options_page_callback' );
};
add_action( 'admin_menu', 'rbd_faq_options_add_page' );

// FAQ page callback
function rbd_faq_options_page_callback(){
    wp_enqueue_style( 'rbd-faqs-styles', plugins_url( '../admin/faq-admin.css', __FILE__ ), '1.0' );
    wp_enqueue_script( 'rbd-faqs-styles', plugins_url( '../admin/faq-admin.js', __FILE__ ), array('jquery'), '1.0' );
    ?>

    <div class="wrap">
        
        <h2>My Plugin Options</h2>

        <form action="options.php" method="POST" id="options-form">
            <?php settings_fields( 'rbd-faq-settings-1' ); ?>
            <?php do_settings_sections( 'rbd-faq-options' ); ?>
            <?php submit_button(); ?>
        </form>

        <h3>Preview</h3>

        <div id="rbd-faq-preview">
            <div class="inner">
                <iframe src="<?php echo plugins_url( '../admin/preview.html', __FILE__ ); ?>"></iframe>
            </div>
        </div>

    </div>
    <?php
};