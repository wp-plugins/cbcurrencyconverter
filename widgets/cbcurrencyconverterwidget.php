<?php

require_once( plugin_dir_path( __FILE__ ) . 'views/cbcurrencyconverter_widget_cal.php' );
require_once( plugin_dir_path( __FILE__ ) . 'views/cbcurrencyconverter_widget_list.php' );

/**
 * Class CbCurrencyConverterwidget
 */
class CbCurrencyConverterWidget extends WP_Widget
{

    /**
     *
     *
     * Unique identifier for  widget.
     *
     *
     * The variable name is used as the text domain when internationalizing strings
     * of text. Its value should match the Text Domain file header in the main
     * widget file.
     *
     * @since    1.0.0
     *
     * @var      string
     */
    protected $widget_slug = 'cbcurrencyconverterwidget';

    /*--------------------------------------------------*/
    /* Constructor
    /*--------------------------------------------------*/

    /**
     * Specifies the classname and description, instantiates the widget,
     * loads localization files, and includes necessary stylesheets and JavaScript.
     */
    public function __construct()
    {
        parent::__construct(
            $this->widget_slug,
            __('Currency Converter', 'cbcurrencyconverter'),
            array(
                'classname' => $this->widget_slug . '-class',
                'description' => __('Currency Converter', 'cbcurrencyconverter')
            )
        );




    } // end constructor




    /**
     * Outputs the content of the widget.
     *
     * @param array args  The array of form elements
     * @param array instance The current instance of the widget
     */
    public function widget($args, $instance)
    {


        extract($args, EXTR_SKIP);


        echo $before_widget;

        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        if (!empty($title)) {
            echo $before_title . $title . $after_title;
        };

//echo '<div class="cbcontainer" ><p class="cbheader">'.$title.'</p>';

        $setting_api = get_option('cbcurrencyconverter_global_settings');
        if (isset($setting_api['cbcurrencyconverter_defaultlayout'])) {

            $widget_style = $setting_api['cbcurrencyconverter_defaultlayout'];

        } else {

            $widget_style = 'cbcurrencyconverter_calwithlistbottom';
        }
        // var_dump($instance);exit;
        if (array_key_exists('cbxccdefaultlayout', $instance) && $instance['cbxccuseglobal'] != 'on') {
            $widget_style = $instance['cbxccdefaultlayout'];
        }

        if ($widget_style == 'cbcurrencyconverter_list') {

            echo codeboxrcurrencyconverterlistview('widget', $instance);
        } elseif ($widget_style == 'cbcurrencyconverter_cal') {

            echo codeboxrcurrencyconvertercalcview('widget', $instance);

        } elseif ($widget_style == 'cbcurrencyconverter_calwithlistbottom') {

            echo codeboxrcurrencyconvertercalcview('widget', $instance);
            echo codeboxrcurrencyconverterlistview('widget', $instance);

        } elseif ($widget_style == 'cbcurrencyconverter_calwithlisttop') {

            echo codeboxrcurrencyconverterlistview('widget', $instance);
            echo codeboxrcurrencyconvertercalcview('widget', $instance);

        }
        // echo '</div>';

        echo $after_widget;

    } // end widget


    /**
     * Processes the widget's options to be saved.
     *
     * @param array new_instance The new instance of values to be generated via the update.
     * @param array old_instance The previous instance of values before the update.
     */
    public function update($new_instance, $old_instance){


        if (!isset($new_instance['submit']))
            return false;
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);

        if (array_key_exists('cbxccdefaultlayout', $new_instance)) {

            $instance['cbxccuseglobal'] = strip_tags($new_instance['cbxccuseglobal']);

            $instance = apply_filters('cbcurrencyconverter_widget_update', $instance, $new_instance);


        }

        return $instance;

    } // end widget

    /**
     * Generates the administration form for the widget.
     *
     * @param array instance The array of keys and values for the widget.
     */
    public function form($instance)
    {

        global $wpdb;
        $instance = wp_parse_args((array)$instance, array(
            'title' => __('Currency Converter', 'cbcurrencyconverter'),

        ));

        $title = esc_attr($instance['title']);

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title:', 'cbcurrencyconverter'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
            </label>
        </p>
        <?php


                do_action('cbcurrencyconverter_widget_form', $instance, $this);
                ?>
                <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>"   name="<?php echo $this->get_field_name('submit'); ?>" value="1"/>
        <?php



    } // end form



} // end class