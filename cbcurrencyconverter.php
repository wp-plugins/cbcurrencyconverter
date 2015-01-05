<?php
/**

 * @package   cbcurrencyconverter
 * @author    codeboxr
 * @license   GPL-2.0+
 * @link      http://codeboxr.com
 * @copyright 2014-20115 codeboxr
 * Plugin Name:       Codeboxr Currency Converter
 * Plugin URI:        http://codeboxr.com/product/universal-currency-converter-and-live-exchange-rate-display-for-wordpress
 * Description:       Currency Converter widget and shortcode by codeboxr
 * Version:           1.0.10
 * Author:            codeboxr
 * Author URI:        http://codeboxr.com
 * Text Domain:       cbcurrencyconverter
 * License:           GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define('CODEBOXR_CURRENCYCONVERTER_PLUGIN_VERSION', '1.0.10');

//on activation took
register_activation_hook( __FILE__, array( 'CbCurrencyConverter', 'cbcurrencyconvert_activation' ) );

//plugin deactivation hook
//register_deactivation_hook( __FILE__, array( 'CbCurrencyConverter', 'cbcurrencyconvert_deactivation' ) ); //we are not using it still now

//plugin uninstall/delete hook
register_uninstall_hook( __FILE__, array( 'CbCurrencyConverter', 'cbcurrencyconvert_uninstall' ) );




/**
 *
 *
 * Class CbCurrencyConverter
 */
class CbCurrencyConverter{
    protected $plugin_slug      = 'cbcurrencyconverter';
    protected $plugin_setting;
    protected $plugin_screen_hook_suffix = 'settings_page_cbcurrencyconverter'; //we know it at least
    //protected $plugin_screen_hook_suffix = 'cbcurrencyconverter'; //we know it at least


    public  static $cbcurrencyconverter_currency_list = array (

        'ALL' => 'Albania Lek',
        'AFN' => 'Afghanistan Afghani',
        'ARS' => 'Argentina Peso',
        'AWG' => 'Aruba Guilder',
        'AUD' => 'Australia Dollar',
        'AZN' => 'Azerbaijan New Manat',
        'BSD' => 'Bahamas Dollar',
        'BBD' => 'Barbados Dollar',
        'BDT' => 'Bangladeshi Taka',
        'BYR' => 'Belarus Ruble',
        'BZD' => 'Belize Dollar',
        'BMD' => 'Bermuda Dollar',
        'BOB' => 'Bolivia Boliviano',
        'BAM' => 'Bosnia and Herzegovina Convertible Marka',
        'BWP' => 'Botswana Pula',
        'BGN' => 'Bulgaria Lev',
        'BRL' => 'Brazil Real',
        'BND' => 'Brunei Darussalam Dollar',
        'KHR' => 'Cambodia Riel',
        'CAD' => 'Canada Dollar',
        'KYD' => 'Cayman Islands Dollar',
        'CLP' => 'Chile Peso',
        'CNY' => 'China Yuan Renminbi',
        'COP' => 'Colombia Peso',
        'CRC' => 'Costa Rica Colon',
        'HRK' => 'Croatia Kuna',
        'CUP' => 'Cuba Peso',
        'CZK' => 'Czech Republic Koruna',
        'DKK' => 'Denmark Krone',
        'DOP' => 'Dominican Republic Peso',
        'XCD' => 'East Caribbean Dollar',
        'EGP' => 'Egypt Pound',
        'SVC' => 'El Salvador Colon',
        'EEK' => 'Estonia Kroon',
        'EUR' => 'Euro Member Countries',
        'FKP' => 'Falkland Islands (Malvinas) Pound',
        'FJD' => 'Fiji Dollar',
        'GHC' => 'Ghana Cedis',
        'GIP' => 'Gibraltar Pound',
        'GTQ' => 'Guatemala Quetzal',
        'GGP' => 'Guernsey Pound',
        'GYD' => 'Guyana Dollar',
        'HNL' => 'Honduras Lempira',
        'HKD' => 'Hong Kong Dollar',
        'HUF' => 'Hungary Forint',
        'ISK' => 'Iceland Krona',
        'INR' => 'India Rupee',
        'IDR' => 'Indonesia Rupiah',
        'IRR' => 'Iran Rial',
        'IMP' => 'Isle of Man Pound',
        'ILS' => 'Israel Shekel',
        'JMD' => 'Jamaica Dollar',
        'JPY' => 'Japan Yen',
        'JEP' => 'Jersey Pound',
        'KZT' => 'Kazakhstan Tenge',
        'KPW' => 'Korea (North) Won',
        'KRW' => 'Korea (South) Won',
        'KGS' => 'Kyrgyzstan Som',
        'LAK' => 'Laos Kip',
        'LVL' => 'Latvia Lat',
        'LBP' => 'Lebanon Pound',
        'LRD' => 'Liberia Dollar',
        'LTL' => 'Lithuania Litas',
        'MKD' => 'Macedonia Denar',
        'MYR' => 'Malaysia Ringgit',
        'MUR' => 'Mauritius Rupee',
        'MXN' => 'Mexico Peso',
        'MNT' => 'Mongolia Tughrik',
        'MZN' => 'Mozambique Metical',
        'NAD' => 'Namibia Dollar',
        'NPR' => 'Nepal Rupee',
        'ANG' => 'Netherlands Antilles Guilder',
        'NZD' => 'New Zealand Dollar',
        'NIO' => 'Nicaragua Cordoba',
        'NGN' => 'Nigeria Naira',
        'NOK' => 'Norway Krone',
        'OMR' => 'Oman Rial',
        'PKR' => 'Pakistan Rupee',
        'PAB' => 'Panama Balboa',
        'PYG' => 'Paraguay Guarani',
        'PEN' => 'Peru Nuevo Sol',
        'PHP' => 'Philippines Peso',
        'PLN' => 'Poland Zloty',
        'QAR' => 'Qatar Riyal',
        'RON' => 'Romania New Leu',
        'RUB' => 'Russia Ruble',
        'SHP' => 'Saint Helena Pound',
        'SAR' => 'Saudi Arabia Riyal',
        'RSD' => 'Serbia Dinar',
        'SCR' => 'Seychelles Rupee',
        'SGD' => 'Singapore Dollar',
        'SBD' => 'Solomon Islands Dollar',
        'SOS' => 'Somalia Shilling',
        'ZAR' => 'South Africa Rand',
        'LKR' => 'Sri Lanka Rupee',
        'SEK' => 'Sweden Krona',
        'CHF' => 'Switzerland Franc',
        'SRD' => 'Suriname Dollar',
        'SYP' => 'Syria Pound',
        'TWD' => 'Taiwan New Dollar',
        'THB' => 'Thailand Baht',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TRY' => 'Turkey Lira',
        'TRL' => 'Turkey Lira',
        'TVD' => 'Tuvalu Dollar',
        'UAH' => 'Ukraine Hryvna',
        'GBP' => 'United Kingdom Pound',
        'USD' => 'United States Dollar',
        'UYU' => 'Uruguay Peso',
        'UZS' => 'Uzbekistan Som',
        'VEF' => 'Venezuela Bolivar',
        'VND' => 'Viet Nam Dong',
        'YER' => 'Yemen Rial',
        'ZWD' => 'Zimbabwe Dollar'
    );

    /**
     *  Constructor, all initialize
     */
    public  function  __construct(){
        global $hook_suffix;



        load_plugin_textdomain( $this->plugin_slug, false, plugin_dir_path( __FILE__ ) . 'lang/' );

        //load setting api
        add_action( 'admin_init', array($this,'cbcurrencyconverter_admin_init'));
        add_action( 'admin_menu', array( $this, 'cbcurrencyconverter_admin_menu' ) );




        if ( is_admin() ) {
            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),  array($this,'cbcurrencyconverteradd_action_links' ), 10, 4 );
        }


        //var_dump($this->plugin_screen_hook_suffix);
        //add style and scripts in admin
        //add_action( 'admin_enqueue_scripts', array( $this, 'cbcurrencyconvert_register_admin_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'cbcurrencyconvert_register_admin_scripts' ) );

        // Register styles and scripts  for frontend
        add_action( 'wp_enqueue_scripts', array( $this, 'cbcurrencyconvert_register_widget_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'cbcurrencyconvert_register_widget_scripts' ) );

        //init widgets

        // init widget
        add_action( 'widgets_init', array($this, 'register_widgets'));

        //ajax call from widget frontend
        //as this can be called from shortcode, so we set these in main plugin class
        add_shortcode('cbcurrencyconverter', array( $this, 'codeboxrcurrencyconverter_shortcode' ));

        add_action("wp_ajax_currrency_convert", array( 'CbCurrencyConverter',"cbcurrencyconverter_ajax_cur_convert"));
        add_action("wp_ajax_nopriv_currrency_convert", array( 'CbCurrencyConverter',"cbcurrencyconverter_ajax_cur_convert"));


    }//end  of method constructor


    public  function cbcurrencyconverter_admin_menu(){
        //add_submenu_page('options-general.php', 'wpautop-control', 'wpautop control', 'manage_options',  $this->plugin_slug, array( $this, 'cbcurrencyconverter_display_plugin_admin_page' ));
        $this->plugin_screen_hook_suffix = add_submenu_page('options-general.php',
            __('Currency Converter','cbcurrencyconverter'),
            __('Currency Converter','cbcurrencyconverter'),
            'manage_options',
            'cbcurrencyconverter',
            array( $this, 'cbcurrencyconverter_display_plugin_admin_page' )
        );

        //var_dump($this->plugin_screen_hook_suffix);
        // Register admin styles and scripts

    }

    public function  cbcurrencyconverter_admin_init(){

        // loding global settings api
        require_once(plugin_dir_path( __FILE__ ). "class.settings-api.php");

        $sections = array(
            array(
                'id'    => 'cbcurrencyconverter_global_settings',
                'title' => __( 'Currency Converter Settings', 'cbcurrencyconverter' )
            ),
            array(
                'id'    => 'cbcurrencyconverter_calculator_settings',
                'title' => __( 'Calculator Settings', 'cbcurrencyconverter' )
            )
        ,
            array(
                'id'    => 'cbcurrencyconverter_list_settings',
                'title' => __( 'List Settings', 'cbcurrencyconverter' )
            ),
            array(
                'id'    => 'cbcurrencyconverter_tools',
                'title' => __( 'Tools', 'cbcurrencyconverter' )
            ),
            array(
                'id'    => 'cbcurrencyconverter_integration',
                'title' => __( 'Integration ', 'cbcurrencyconverter' )
            )
        );

        //$sections  =

        $fields = array(
            'cbcurrencyconverter_global_settings' => array(),
            'cbcurrencyconverter_calculator_settings' => array(),
            'cbcurrencyconverter_list_settings' => array( ),
            'cbcurrencyconverter_tools' => array(),
            'cbcurrencyconverter_integration' => array()

        );


        $this->plugin_setting = new cbcurrencyconverter_settings_api($this->plugin_screen_hook_suffix);
        $this->plugin_setting->set_sections( $sections );
        $this->plugin_setting->set_fields( $fields );
        //initialize them
        $this->plugin_setting->admin_init();
    }


    /**
     * set default values when plugin loaded
     */
    public static function cbcurrencyconvert_activation(){
        $check_cbcurrencyconvert_options_ = (array());
        $check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_global_settings'));
        // var_dump($check_cbcurrencyconvert_options);exit;

        if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){
            $check_cbcurrencyconvert_options_['cbcurrencyconverter_defaultlayout']   = 'cbcurrencyconverter_cal';
        }

        update_option('cbcurrencyconverter_global_settings',$check_cbcurrencyconvert_options_);

        $check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_calculator_settings'));

        if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){

            $check_cbcurrencyconvert_options['cbcurrencyconverter_fromcurrency']                 = 'USD';
            $check_cbcurrencyconvert_options['cbcurrencyconverter_tocurrency']                   = 'USD';
            $check_cbcurrencyconvert_options['cbcurrencyconverter_defaultamount_for_calculator'] = 1;
            $check_cbcurrencyconvert_options['cbcurrencyconverter_title_cal']                    = __('Calculator', 'cbcurrencyconverter');
        }
        update_option('cbcurrencyconverter_calculator_settings',$check_cbcurrencyconvert_options);

        $check_cbcurrencyconvert_options = (get_option('cbcurrencyconverter_list_settings'));

        if(is_string($check_cbcurrencyconvert_options) && $check_cbcurrencyconvert_options == ''){

            $check_cbcurrencyconvert_options['cbcurrencyconverter_defaultcurrency_list']                 = 'USD';
            $check_cbcurrencyconvert_options['cbcurrencyconverter_tocurrency_list']                      =  array( 'ALL'=>'ALL');
            $check_cbcurrencyconvert_options['cbcurrencyconverter_defaultamount_forlist']                = 1;
            $check_cbcurrencyconvert_options['cbcurrencyconverter_title_list']                           = __('List', 'cbcurrencyconverter');
        }
        update_option('cbcurrencyconverter_list_settings',$check_cbcurrencyconvert_options);
    }

    public static function cbcurrencyconvert_deactivation()
    {
        if ( ! current_user_can( 'activate_plugins' ) )
            return;
        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        check_admin_referer( "deactivate-plugin_{$plugin}" );

        # Uncomment the following line to see the function in action
        # exit( var_dump( $_GET ) );
    }

    /**
     * called when plugin uninstalled/delete
     * delete all options if delete all saved from tools page
     */

    public static function cbcurrencyconvert_uninstall() {


        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        check_admin_referer( 'bulk-plugins' );

        // Important: Check if the file is the one
        // that was registered during the uninstall hook.
        if ( __FILE__ != WP_UNINSTALL_PLUGIN )
            return;

        $cbcurrencyconverter_tools = get_option('cbcurrencyconverter_tools');

        if(isset($cbcurrencyconverter_tools['cbcurrencyconverter_delete_options']) && $cbcurrencyconverter_tools['cbcurrencyconverter_delete_options'] == 'on' ){

            //delete all option entries created by this plugin
            delete_option('cbcurrencyconverter_global_settings');
            delete_option('cbcurrencyconverter_calculator_settings');
            delete_option('cbcurrencyconverter_list_settings');
            delete_option('cbcurrencyconverter_tools');
            delete_option('cbcurrencyconverter_integration');
        }


    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function cbcurrencyconverteradd_action_links( $links ) {
        //var_dump($links);
        return array_merge(
            array(
                'settings' => '<a href="' . admin_url( 'options-general.php?page=cbcurrencyconverter' ) . '">' . __( 'Settings', 'cbcurrencyconverter' ) . '</a>'
            ),
            $links
        );

    }//end of function add_action_links

    /**
     * Registers and enqueues admin-specific JavaScript.
     */
    public function cbcurrencyconvert_register_admin_scripts($hook) {

        //var_dump($this->plugin_screen_hook_suffix);
        if($this->plugin_screen_hook_suffix != $hook) return;



        wp_enqueue_style( $this->plugin_slug .'-chosen', plugin_dir_url(__FILE__). 'css/chosen.min.css', array() );
        wp_enqueue_style( $this->plugin_slug.'-admin-styles', plugin_dir_url(__FILE__).'css/cbcurrencyconverter_admin.css' );

        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( $this->plugin_slug. '-choosen-script', plugin_dir_url(__FILE__). 'js/chosen.jquery.min.js', array( 'jquery' ) );
        wp_enqueue_script( $this->plugin_slug.'-admin-script', plugin_dir_url(__FILE__). 'js/cbcurrencyconverter_admin.js', array('jquery') );


    } // end register_admin_scripts


    /**
     * Registers and enqueues widget-specific styles.
     */
    public function cbcurrencyconvert_register_widget_styles()
    {

        wp_enqueue_style($this->plugin_slug . '-widget-styles', plugins_url('css/cbcurrencyconverter_widget.css', __FILE__));

    } // end register_widget_styles

    /**
     * Registers and enqueues widget-specific scripts.
     */
    public function cbcurrencyconvert_register_widget_scripts()
    {

        wp_enqueue_script($this->plugin_slug . '-script', plugins_url('js/cbcurrencyconverter_widget.js', __FILE__), array('jquery'));
        wp_localize_script($this->plugin_slug . '-script', 'currrency_convert', array('ajaxurl' => admin_url('admin-ajax.php')));

    } // end register_widget_scripts



    public function register_widgets(){
        require_once( plugin_dir_path( __FILE__ ) . 'widgets/cbcurrencyconverterwidget.php' );
        register_widget( 'CbCurrencyConverterWidget' );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function cbcurrencyconverter_display_plugin_admin_page() {

        $cbcurrencyconverter_currency_list = self::$cbcurrencyconverter_currency_list;
        global $wp_roles;
        $roles          = $wp_roles->get_names();
        $roles          = array_merge($roles,array('guest'=>'Guest'));
        $editor_roles   = $wp_roles->get_names();

        $sections = array(
            array(
                'id'    => 'cbcurrencyconverter_global_settings',
                'title' => __( 'General Settings', 'cbcurrencyconverter' )
            ),
            array(
                'id'    => 'cbcurrencyconverter_calculator_settings',
                'title' => __( 'Calculator Settings', 'cbcurrencyconverter' ),

            ),
            array(
                'id'    => 'cbcurrencyconverter_list_settings',
                'title' => __( 'List Settings', 'cbcurrencyconverter' ),

            ),
            array(
                'id'    => 'cbcurrencyconverter_tools',
                'title' => __( 'Tools', 'cbcurrencyconverter' )
            ),
            array(
                'id'    => 'cbcurrencyconverter_integration',
                'title' => __( 'Integration ', 'cbcurrencyconverter' )
            )
        );


        //$sections = apply_filters('cbcurrencyconverter_setting_sections', $sections);

        $cbcurrencyconverter_global_settings = array(

            array(
                'name'      => 'cbcurrencyconverter_defaultlayout',
                'label'     => __( 'Layout', 'cbcurrencyconverter' ),
                'desc'      => __( '', 'cbcurrencyconverter' ),
                'type'      => 'select',
                'default'   => 'cbcurrencyconverter_cal',
                'options'       => array(
                    'cbcurrencyconverter_cal'               => __('Calculator','cbcurrencyconverter'),
                    'cbcurrencyconverter_list'              => __('List','cbcurrencyconverter'),
                    'cbcurrencyconverter_calwithlistbottom' => __('Calculator with List at bottom', 'cbcurrencyconverter'),
                    'cbcurrencyconverter_calwithlisttop'    => __('Calculator with List at top','cbcurrencyconverter')
                )
            ),
        );

        //$cbcurrencyconverter_global_settings = apply_filters('cbcurrencyconverter_global_settings', $cbcurrencyconverter_global_settings);

        $cbcurrencyconverter_calculator_settings = array(
            array(
                'name'  => 'cbcurrencyconverter_fromcurrency',
                'label' => __( 'From', 'cbcurrencyconverter' ),
                'desc'  => __( 'What Will Be Your Default  Currency To Convert From', 'cbcurrencyconverter' ),
                'type'  => 'select',
                'default' => 'USD',
                'options' => $cbcurrencyconverter_currency_list
            ),
            array(
                'name'  => 'cbcurrencyconverter_tocurrency',
                'label' => __( 'To ', 'cbcurrencyconverter' ),
                'desc'  => __( 'What Will Be Your Default To  Currency', 'cbcurrencyconverter' ),
                'type'  => 'select',
                'default' => 'USD',
                'options' => $cbcurrencyconverter_currency_list
            ),
            array(
                'name'  => 'cbcurrencyconverter_defaultamount_for_calculator',
                'label' => __( 'Default Amount', 'cbcurrencyconverter' ),
                'desc'  => __( 'What Will Be Your Default Amount of Currency For Calculating', 'cbcurrencyconverter' ),
                'type'  => 'number',
                'default' => '1'

            ),array(
                'name'  => 'cbcurrencyconverter_title_cal',
                'label' => __( 'Title', 'cbcurrencyconverter' ),
                'desc'  => __( 'Title to  show in calculator ', 'cbcurrencyconverter' ),
                'type'  => 'text',
                'default' => 'Calculator Title',
            ),
        );

       // $cbcurrencyconverter_calculator_settings = apply_filters('cbcurrencyconverter_calculator_settings', $cbcurrencyconverter_calculator_settings);


        $cbcurrencyconverter_tools = array(
            array(
                'name'  => 'cbcurrencyconverter_delete_options',
                'label' => __( 'Remove Data on Uninstall?', 'cbcurrencyconverter' ),
                'desc'  => __( 'Check this box if you would like <strong>Codeboxr Currency Converter</strong> to completely remove all of its data when the plugin is deleted.', 'cbcurrencyconverter' ),
                'type'  => 'checkbox'

            )
        );



        $cbcurrencyconverter_list_settings       = array(
            array(
                'name'  => 'cbcurrencyconverter_defaultcurrency_list',
                'label' => __( 'Currency  To Convert From', 'cbcurrencyconverter' ),
                'desc'  => __( 'What Will Be Your Default Currency For Listing', 'cbcurrencyconverter' ),
                'type'  => 'select',
                'default' => 'USD',
                'options' => $cbcurrencyconverter_currency_list
            ),
            array(
                'name'  => 'cbcurrencyconverter_tocurrency_list',
                'label' => __( 'To Currency', 'cbcurrencyconverter' ),
                'desc'  => __( 'Currency list to convert and show in listing ', 'cbcurrencyconverter' ),
                'type'  => 'postselectbox',
                'default' => 'USD',
                'options' => $cbcurrencyconverter_currency_list
            ),
            array(
                'name'      => 'cbcurrencyconverter_defaultamount_forlist',
                'label'     => __( 'Default Amount', 'cbcurrencyconverter' ),
                'desc'      => __( 'Default amount for listing', 'cbcurrencyconverter' ),
                'type'      => 'number',
                'default'   => '1',

            ),array(
                'name'  => 'cbcurrencyconverter_title_list',
                'label' => __( 'Title', 'cbcurrencyconverter' ),
                'desc'  => __( 'Title to  show in listing ', 'cbcurrencyconverter' ),
                'type'  => 'text',
                'default' => __('List of Currency','cbcurrencyconverter'),
            ),
        );

        //$cbcurrencyconverter_list_settings = apply_filters('cbcurrencyconverter_list_settings', $cbcurrencyconverter_list_settings);

        $cbcurrencyconverter_integration = array();
        $cbcurrencyconverter_integration = apply_filters('cbcurrencyconverter_integration', $cbcurrencyconverter_integration);

        $fields = array(
            'cbcurrencyconverter_global_settings'       => $cbcurrencyconverter_global_settings,
            'cbcurrencyconverter_calculator_settings'   => $cbcurrencyconverter_calculator_settings,
            'cbcurrencyconverter_list_settings'         => $cbcurrencyconverter_list_settings,
            'cbcurrencyconverter_tools'                 => $cbcurrencyconverter_tools,
            'cbcurrencyconverter_integration'          => $cbcurrencyconverter_integration
        );

        $settings_api = new cbcurrencyconverter_settings_api();

        ?>
        <style type="text/css">
            #poststuff h2.nav-tab-wrapper{
                margin-bottom: 0px !important;
                padding-bottom: 0px !important;
            }
            .nav-tab-active{
                background-color: #fff;
            }

            #wpbody-content .metabox-holder.cbcurrencyconverter-metabox-holder{
                padding-top: 0px !important;
            }

        </style>

        <?php
        echo '<div class="wrap columns-2">';

        $output  = '';
        //$output = '<div class="icon32 icon32_cbrp_admin icon32-cbrp-edit" id="icon32-cbrp-edit"><br></div>';
        $output .= '<h2>' . __( 'Codeboxr Currency Converter', 'cbcurrencyconverter' ) . '</h2>';

        $output .= '<div class="cbcurrencyconverter_wrapper metabox-holder cbcurrencyconverter-metabox-holder has-right-sidebar" id="poststuff" style="padding-top: 0px !important;">';

//        if(isset($_GET['settings-updated'])):
//            $output .= '<div id="message" class="updated">' . __( 'Setting has been saved successfully', 'cbcurrencyconverter' ) . '</div>';
//        endif;

        echo $output;
        echo '<div id="post-body"><div id="post-body-content">';

        $settings_api->set_sections( $sections );
        $settings_api->set_fields( $fields );

        //initialize them
        $settings_api->admin_init();
        $settings_api->show_navigation();
        $settings_api->show_forms();
        echo '</div></div>';
        ?>
        <div id="side-info-column" class="inner-sidebar">

            <div class="postbox">
                <h3>Plugin Info</h3>

                <div class="inside">
                    <p>Name : Codeboxr Currency Converter <?php echo 'v' . CODEBOXR_CURRENCYCONVERTER_PLUGIN_VERSION; ?></p>

                    <p>Author : Codeboxr Team</p>

                    <p>Plugin URL :
                        <a href="http://codeboxr.com/product/cbcurrencyconverter" target="_blank">Codeboxr.com</a>
                    </p>

                    <p>Email : <a href="mailto:info@codeboxr.com" target="_blank">info@codeboxr.com</a></p>

                    <p>Contact : <a href="http://codeboxr.com/contact-us.html" target="_blank">Contact Us</a></p>
                </div>
            </div>
            <div class="postbox">
                <h3>Help & Supports</h3>
                <div class="inside">
                    <p>Support: <a href="http://codeboxr.com/contact-us.html" target="_blank">Contact Us</a></p>
                    <p><i class="icon-envelope"></i> <a href="mailto:info@codeboxr.com">info@codeboxr.com</a></p>
                    <p><i class="icon-phone"></i> <a href="tel:008801717308615">+8801717308615</a> (CEO: Sabuj Kundu)</p>
                    <!--p><i class="icon-building"></i>  Address: Flat-11B1, 252 Elephant Road (Near Kataban Crossing), Dhaka 1205, Bangladesh.<br-->
                </div>
            </div>
            <div class="postbox">
                <h3>Codeboxr Updates</h3>
                <div class="inside">
                    <?php
                    include_once(ABSPATH . WPINC . '/feed.php');
                    if(function_exists('fetch_feed')) {
                        $feed = fetch_feed('http://codeboxr.com/feed');
                        // $feed = fetch_feed('http://feeds.feedburner.com/codeboxr'); // this is the external website's RSS feed URL
                        if (!is_wp_error($feed)) : $feed->init();
                            $feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                            $feed->handle_content_type(); // this double-checks the encoding type
                            $feed->set_cache_duration(21600); // 21,600 seconds is six hours
                            $limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
                            $items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

                            $blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here
                            echo '<ul>';
                            foreach ($blocks as $block) {
                                $url = $block->get_permalink();
                                echo '<li><a target="_blank" href="'.$url.'">';
                                echo '<strong>'.$block->get_title().'</strong></a>';
                                echo '</li>';

                            }//end foreach
                            echo '</ul>';
                        endif;
                    }
                    ?>
                </div>
            </div>

            <div class="postbox">
                <h3>Codeboxr on facebook</h3>
                <div class="inside">
                    <iframe scrolling="no" frameborder="0" allowtransparency="true" style="border:none; overflow:hidden; width:260px; height:258px;" src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fcodeboxr&amp;width=260&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=558248797526834"></iframe>
                </div>
            </div>

        </div>
        <?php
        echo '</div>';
        echo '</div>';

    }


    /**
     * @param $price
     * @param $convertfrom
     * @param $convertto
     *
     * @return mixed
     */
    public static   function codeboxrconvertcurrency($price,$convertfrom,$convertto)
    {
        // 1. initialize
        $ch = curl_init();
        // 2. set the options, including the url
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/finance/converter?a=".$price."&from=".$convertfrom."&to=".$convertto." ");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 3. execute and fetch the resulting HTML output
        $output = curl_exec($ch);
        // 4. free up the curl handle
        curl_close($ch);

        $data = explode('<div id=currency_converter_result>',$output);

        $data2 = explode('<div id=currency_converter_result>',$data['1']);

        $data3=explode('<span class=bld>',$data2['0']);
        if(array_key_exists('1',$data3)){

            $data4=explode('</span>',$data3['1']);
            $data5=explode(' ',$data4['0']);
            return $data5[0];
        }
        else{
            return '';
        }

    }

    /**
     * cbcurrencyconverter_ajax_cur_convert
     */
    /*
    public static function cbcurrencyconverter_ajax_cur_convert(){

        $cbcurrencyconverter_cur_data = $_POST['cb_cur_data'];

        if($cbcurrencyconverter_cur_data['cbcurconvert_error'] == ''){

            if($cbcurrencyconverter_cur_data['type'] == 'up'){

                $cbcurrencyconverter_result_cur = self::codeboxrconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'],$cbcurrencyconverter_cur_data['cbcurconvert_to'],$cbcurrencyconverter_cur_data['cbcurconvert_from']);
            }
            else{

                $cbcurrencyconverter_result_cur = self::codeboxrconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'],$cbcurrencyconverter_cur_data['cbcurconvert_from'],$cbcurrencyconverter_cur_data['cbcurconvert_to']);
            }
        }
        else{

            $cbcurrencyconverter_result_cur = $cbcurrencyconverter_cur_data['cbcurconvert_error'];
        }
        echo(json_encode($cbcurrencyconverter_result_cur));
        die();
    }
    */

    /**
     * @return string
     */
    public function codeboxrcurrencyconverter_shortcode(  $atts ){

        $instance               = array();
        $setting_api            = get_option( 'cbcurrencyconverter_global_settings');


        $setting_api_list = get_option( 'cbcurrencyconverter_list_settings');
        // if default currency to convert given and its all upper case

        $widget_style                      = ( isset( $setting_api_list['cbcurrencyconverter_defaultlayout'] ) ) ? $setting_api_list['cbcurrencyconverter_defaultlayout'] :  'cbcurrencyconverter_calwithlistbottom' ;
        $cbcur_list_of_currencys           = ( isset( $setting_api_list['cbcurrencyconverter_tocurrency_list'] ) ) ? $setting_api_list['cbcurrencyconverter_tocurrency_list'] :  array() ;
        $cbcur_default_currency            = ( isset( $setting_api_list['cbcurrencyconverter_defaultcurrency_list'] ) ) ? $setting_api_list['cbcurrencyconverter_defaultcurrency_list'] :  'USD' ;
        $cbcur_default_amount              = ( isset( $setting_api_list['cbcurrencyconverter_defaultamount_forlist'] ) ) ? $setting_api_list['cbcurrencyconverter_defaultamount_forlist'] :  1 ;
        $cbcur_default_heading             = ( isset( $setting_api_list['cbcurrencyconverter_title_list'] ) ) ? $setting_api_list['cbcurrencyconverter_title_list'] :  __('List of Converted Currency','cbcurrencyconverter') ;

        $setting_api_cal            = get_option( 'cbcurrencyconverter_calculator_settings');
        // default amount
        $cbcur_from_currency        =  ( isset( $setting_api_cal['cbcurrencyconverter_fromcurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_fromcurrency'] : 'USD';
        $cbcur_to_currencys         =  ( isset( $setting_api_cal['cbcurrencyconverter_tocurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_tocurrency'] : 'USD';
        //default to currency
        $cbcur_calc_default_amount  =  ( isset( $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] ) ) ? $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] : 1;
        //////////////////title//////////
        $cbcur_calc_default_title   =  ( isset( $setting_api_cal['cbcurrencyconverter_title_cal'] ) ) ? $setting_api_cal['cbcurrencyconverter_title_cal'] : __('Convert Currency','cbcurrencyconverter');
        ///
        $cbcur_options= shortcode_atts( array(

            'use_global'           => 'on',
            'layout'               => $widget_style,
            'calc_title'           => $cbcur_calc_default_title,
            'calc_to_currency'     => $cbcur_to_currencys,
            'calc_from_currency'   => $cbcur_from_currency,
            'calc_default_amount'  => $cbcur_calc_default_amount,
            'list_title'           => $cbcur_default_heading,
            'list_from_currency'   => $cbcur_default_currency,
            'list_to_currency'     => $cbcur_list_of_currencys,
            'list_default_amount'  => $cbcur_default_amount,

        ), $atts );


        // var_dump(is_plugin_active('cbcurrencyconverteraddon/cbcurrencyconverteraddon.php'));
        /*
        if( $cbcur_options['use_global'] != 'on' && file_exists( CODEBOXR_CURRENCYCONVERTER_INCLUDE ) && is_plugin_active('cbcurrencyconverteraddon/cbcurrencyconverteraddon.php')){

            $layout_options        = array('cbcurrencyconverter_list' , 'cbcurrencyconverter_cal' , 'cbcurrencyconverter_calwithlistbottom' , 'cbcurrencyconverter_calwithlisttop');
            $filter_layout         = explode(",", $cbcur_options['layout']);
            $check_currencylayout  = array_intersect($layout_options , $filter_layout);

            if(empty($check_currencylayout)){
                if(count($filter_layout) == 1){
                    if( $filter_layout[0] == 'calc'){
                        $widget_style = 'cbcurrencyconverter_cal';
                    }
                    else{
                        $widget_style = 'cbcurrencyconverter_list';
                    }
                }
                else{
                    if( $filter_layout[0] == 'calc'){
                        $widget_style = 'cbcurrencyconverter_calwithlistbottom';
                    }
                    else{
                        $widget_style = 'cbcurrencyconverter_calwithlisttop';
                    }
                }
                //  $widget_style = (count($filter_layout) == 1 )?( $filter_layout[0] == 'calc' )? 'cbcurrencyconverter_cal' : 'cbcurrencyconverter_list' : ($filter_layout[0] == 'calc') ? 'cbcurrencyconverter_calwithlistbottom' : 'cbcurrencyconverter_calwithlisttop';
            }

            $instance['cbxccuseglobal']          = $cbcur_options['use_global'];
            //$instance['cbxccbackgroundcolor']    = $cbcur_options['background_color'];
            //$instance['cbxcctextcolor']          = $cbcur_options['text_color'];
            //$instance['cbxccbordercolor']        = $cbcur_options['border'];
            $instance['cbxccdefaultlayout']      = $widget_style;
            $instance['cbxcalfromcurrency']      = $cbcur_options['calc_from_currency'];
            $instance['cbxcaltocurrency']        = $cbcur_options['calc_to_currency'];
            $instance['cbxcaldefaultamount']     = $cbcur_options['calc_default_amount'];
            $instance['cbxcaltitle']             = $cbcur_options['calc_title'];
            $instance['cbxlistfromcurrency']     = $cbcur_options['list_from_currency'];

            $instance['cbxlisttitle']            = $cbcur_options['list_title'];
            $instance['cbxlistdefaultamount']    = $cbcur_options['list_default_amount'];
            if(!is_array($cbcur_options['list_to_currency'])){
                $instance['cbxlisttocurrency']       = explode(",", $cbcur_options['list_to_currency']);
            }
            else{
                $instance['cbxlisttocurrency']       = $cbcur_options['list_to_currency'];
            }

        }

        */



        $instance  = $cbcur_options;

        if($widget_style == 'cbcurrencyconverter_list'){

            return codeboxrcurrencyconverterlistview('shortcode' , $instance);
        }
        elseif($widget_style == 'cbcurrencyconverter_cal'){

            return codeboxrcurrencyconvertercalcview('shortcode' ,$instance);

        }
        elseif($widget_style == 'cbcurrencyconverter_calwithlistbottom' ){

            return codeboxrcurrencyconvertercalcview('shortcode' , $instance).codeboxrcurrencyconverterlistview('shortcode' ,$instance);

        }
        elseif($widget_style == 'cbcurrencyconverter_calwithlisttop' ){

            return codeboxrcurrencyconverterlistview('shortcode' , $instance). codeboxrcurrencyconvertercalcview('shortcode' , $instance);

        }

    }//end method codeboxrcurrencyconverter_shortcode

    /**
     * cbcurrencyconverter_ajax_cur_convert
     */
    public static function cbcurrencyconverter_ajax_cur_convert(){

        $cbcurrencyconverter_cur_data = $_POST['cb_cur_data'];

        if($cbcurrencyconverter_cur_data['cbcurconvert_error'] == ''){

            if($cbcurrencyconverter_cur_data['type'] == 'up'){

                $cbcurrencyconverter_result_cur = self::codeboxrconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'],$cbcurrencyconverter_cur_data['cbcurconvert_to'],$cbcurrencyconverter_cur_data['cbcurconvert_from']);
            }
            else{

                $cbcurrencyconverter_result_cur = self::codeboxrconvertcurrency($cbcurrencyconverter_cur_data['cbcurconvert_amount'],$cbcurrencyconverter_cur_data['cbcurconvert_from'],$cbcurrencyconverter_cur_data['cbcurconvert_to']);
            }
        }
        else{

            $cbcurrencyconverter_result_cur = $cbcurrencyconverter_cur_data['cbcurconvert_error'];
        }
        echo(json_encode($cbcurrencyconverter_result_cur));
        die();
    }


}//end of class CbCurrencyConverter


$CbCurrencyConverter = new CbCurrencyConverter();


//require_once( plugin_dir_path( __FILE__ ) . 'views/cbcurrencyconverter_widget_cal.php' );
//require_once( plugin_dir_path( __FILE__ ) . 'views/cbcurrencyconverter_widget_list.php' );
//require_once(plugin_dir_path( __FILE__ ). "cbcurrencyconverter_functions.php");

// create an instance of functions class
//new cbcurrencyconverter_functions();

// init ajax
//add_action( 'widgets_init', create_function( '', 'register_widget("cbcurrencyconverter");' ) );

