<?php
/**
 * Created by PhpStorm.
 * User: codeboxr
 * Date: 6/29/14
 * Time: 4:34 PM
 */
/**
 * @param $cbcur_reference
 *
 * @return string
 * function to make a list of converted currency
 * ref - widget/shortcode
 * check if default value given in global settings and validate else take USD and amount 1
 */

if(!function_exists('codeboxrcurrencyconverterlistview')):
function codeboxrcurrencyconverterlistview($cbcur_reference , $instance = array()){
    global $CbCurrencyConverter;

    $setting_api_list = get_option( 'cbcurrencyconverter_list_settings');
    // if default currency to convert given and its all upper case
    $cbcur_list_of_currencys           = ( isset( $setting_api_list['cbcurrencyconverter_tocurrency_list'] ) ) ? $setting_api_list['cbcurrencyconverter_tocurrency_list'] :  array() ;
    $cbcur_default_currency            = ( isset( $setting_api_list['cbcurrencyconverter_defaultcurrency_list'] ) ) ? $setting_api_list['cbcurrencyconverter_defaultcurrency_list'] :  'USD' ;
    $cbcur_default_amount              = ( isset( $setting_api_list['cbcurrencyconverter_defaultamount_forlist'] ) ) ? $setting_api_list['cbcurrencyconverter_defaultamount_forlist'] :  1 ;
    $cbcur_default_heading             = ( isset( $setting_api_list['cbcurrencyconverter_title_list'] ) ) ? $setting_api_list['cbcurrencyconverter_title_list'] :  __('List of Converted Currency','cbcurrencyconverter') ;

   $setting_api_global = get_option( 'cbcurrencyconverter_global_settings');


    // out put list
    if( array_key_exists( 'cbxccdefaultlayout' , $instance )  && $instance['cbxccuseglobal'] != 'on' ){


        $cbcur_default_currency     = $instance['cbxlistfromcurrency'];
        $cbcur_list_of_currencys    = $instance['cbxlisttocurrency'];
        //default to currency
        $cbcur_default_amount       = $instance['cbxlistdefaultamount'];
        //////////////////title//////////
        $cbcur_default_heading      = $instance['cbxlisttitle'];

    }
   // var_dump($cbcur_list_of_currencys);
    $cbcur_list_view = '<div  class="cbcurrencyconverter_list_wrapper cbcurrencyconverter_list_wrapper_'.$cbcur_reference.'">';
    $cbcur_list_view .= '<h3 class = "cbcurrencyconverter_heading">'.$cbcur_default_heading.'</h3>';
    // if not empty array
    if(!empty($cbcur_list_of_currencys)){

       $cbcur_list_view .=   '<ul class="cbcurrencyconverter_list_to cbcurrencyconverter_list_to_'.$cbcur_reference.'">';
        $cbcur_list_view .=   '<li style = "margin-bottom:5px;list-style-type:none;" class="cbcurrencyconverter_list_from cbcurrencyconverter_list_from_'.$cbcur_reference.'">'.$cbcur_default_amount .' '. $cbcur_default_currency .'<span class ="cbcur_list_custom_text">'.__('equals','cbcurrencyconverter').'</span></li>';
        foreach($cbcur_list_of_currencys as $list_of_currency){
            //check if upper case

            if( ctype_upper($list_of_currency)){

                $cb_cur_converted = $CbCurrencyConverter::codeboxrconvertcurrency($cbcur_default_amount,$cbcur_default_currency,$list_of_currency);

                if($cb_cur_converted != ''){

                    $cbcur_list_view .= '<li style = "list-style-type:none;"><span class ="cbcur_list_to_cur">'.$cb_cur_converted;
                    $cbcur_list_view .= '</span><span class ="cbcur_list_to_country">'.$list_of_currency.'<span></li>';
                }// end of not null
            }

       }// end of foreach
       $cbcur_list_view .=  '</ul>';
   }

    $cbcur_list_view .= '</div>';
    // return in shortcode echo in widget
    return $cbcur_list_view ;
}
endif;
