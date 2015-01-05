<?php
/**
 * Created by PhpStorm.
 * User: codeboxr
 * Date: 6/29/14
 * Time: 12:43 PM
 */
/**
 * @return string
 * function to show calculator view
 */

if(!function_exists('codeboxrcurrencyconvertercalcview')):
function codeboxrcurrencyconvertercalcview($cbcur_reference , $instance = array()){

    global $CbCurrencyConverter;



    $setting_api     = get_option( 'cbcurrencyconverter_global_settings');
    $setting_api_cal = get_option( 'cbcurrencyconverter_calculator_settings');

    $cbcurrencyconverter_currency_list = $CbCurrencyConverter::$cbcurrencyconverter_currency_list;
    // take the background color


    // default amount
    $cbcur_from_currency        =  ( isset( $setting_api_cal['cbcurrencyconverter_fromcurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_fromcurrency'] : 'USD';
    $cbcur_to_currencys         =  ( isset( $setting_api_cal['cbcurrencyconverter_tocurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_tocurrency'] : 'USD';
    //default to currency
    $cbcur_calc_default_amount  =  ( isset( $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] ) ) ? $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] : 1;
     //////////////////title//////////
    $cbcur_calc_default_title   =  ( isset( $setting_api_cal['cbcurrencyconverter_title_cal'] ) ) ? $setting_api_cal['cbcurrencyconverter_title_cal'] : __('Convert Currency','cbcurrencyconverter');
    /////////////////////result border
    //$cbcur_cal_bordercolor      =  ( isset( $setting_api['cbcurrencyconverter_bordercolor'] ) ) ? $setting_api['cbcurrencyconverter_bordercolor'] : '#ffffff';
       // result
    if( array_key_exists( 'cbxccdefaultlayout' , $instance )  && $instance['cbxccuseglobal'] != 'on' ){

        // default amount
        $cbcur_from_currency        = $instance['cbxcalfromcurrency'];
        $cbcur_to_currencys         = $instance['cbxcaltocurrency'];
        //default to currency
        $cbcur_calc_default_amount  = $instance['cbxcaldefaultamount'];

        $cbcur_calc_default_title   = $instance['cbxcaltitle'];


        // result
    }

    $cbcurrency_output          = '';

    $cbcurrency_output .= '<div  class="cbcurrencyconverter_cal_wrapper cbcurrencyconverter_cal_wrapper'.$cbcur_reference.'">';


                $cbcurrency_output .= '<h3 class = "cbcurrencyconverter_heading">'.$cbcur_calc_default_title.'</h3>';
                $cbcurrency_output .= '<div  class = "cbcurrencyconverter_result cbcurrencyconverter_result_'.$cbcur_reference.'"></div>';
                // amount input fields
                $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span  class="cbcurrencyconverter_label">'.__('Amount','cbcurrencyconverter').'</span>';
                       $cbcurrency_output .= '<input type = "text" class = "cbcurrencyconverter_cal_amount cbcurrencyconverter_cal_amount_'.$cbcur_reference.'" value ="'.$cbcur_calc_default_amount.'"/>
                                       </div>';

                $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span  class="cbcurrencyconverter_label">From :</span>';

                                          $cbcurrency_output .= '<select class = "cbcurrencyconverter_cal_from cbcurrencyconverter_cal_from_'.$cbcur_reference.'">';
                                                $cbcurrency_output .= '<option value="'.$cbcur_from_currency.'">'.__('Select a currency','cbcurrencyconverter').'</option>';

                                                foreach($cbcurrencyconverter_currency_list as $index=>$currency){

                                                    $cbcurrency_output .= '<option '.selected($cbcur_from_currency , $index , false).' value="'.$index.'">'.$currency.'('.$index.')'.'</option>';
                                                }

                                            $cbcurrency_output .= '</select>
                                    </div>';

                // to input from fields

                $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">
                                            <span class="cbcurrencyconverter_label">To :</span>';

                                            $cbcurrency_output .= '<select class = "cbcurrencyconverter_cal_to cbcurrencyconverter_cal_to_'.$cbcur_reference.'">';

                                                    $cbcurrency_output .= '<option value="'.$cbcur_to_currencys.'">'.__('Select a currency','cbcurrencyconverter').'</option>';

                                                    foreach($cbcurrencyconverter_currency_list as $index=>$currency){

                                                        $cbcurrency_output .= '<option '.selected($cbcur_to_currencys , $index , false).'  value="'.$index.'">'.$currency.'('.$index.')'.'</option>';
                                                    }

                                             $cbcurrency_output .= '</select>
                                        </div>';

                //up and down button
                $cbcurrency_output .= '<div class = "cbconverter_result_wrapper_'.$cbcur_reference.'">
                                            <button style = "" class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_'.$cbcur_reference.'" data-busy = "0" data-ref = "'.$cbcur_reference.'" data-id = "up" >Up</button>
                                            <button style = "" class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_'.$cbcur_reference.'" data-busy = "0" data-ref = "'.$cbcur_reference.'" data-id = "down">Down</button>
                                      </div>';

    $cbcurrency_output .= '</div>';// end of wrapper div

    return $cbcurrency_output;
}
endif;

/**
 * @param       $cbcur_reference
 * @param array $instance
 *
 * @return string
 */
if(!function_exists('codeboxrcurrencyconvertercalcinline')):
function codeboxrcurrencyconvertercalcinline($cbcur_reference , $instance = array()){

    // var_dump($instance);
    global $CbCurrencyConverter;

    $setting_api     = get_option( 'cbcurrencyconverter_global_settings');
    $setting_api_cal = get_option( 'cbcurrencyconverter_calculator_settings');

    $cbcurrencyconverter_currency_list = $CbCurrencyConverter::$cbcurrencyconverter_currency_list;
    // take the background color
    // $cbcur_cal_backcolor        = ( isset( $setting_api['cbcurrencyconverter_backgroundcolor'] ) ) ? $setting_api['cbcurrencyconverter_backgroundcolor'] :  '#ffffff' ;
    //text color
    //$cbcur_cal_textcolor        =  ( isset( $setting_api['cbcurrencyconverter_textcolor'] ) ) ? $setting_api['cbcurrencyconverter_textcolor'] : '#000000';
    // default amount
    $cbcur_from_currency        =  ( isset( $setting_api_cal['cbcurrencyconverter_fromcurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_fromcurrency'] : 'USD';
    $cbcur_to_currencys         =  ( isset( $setting_api_cal['cbcurrencyconverter_tocurrency'] ) ) ? $setting_api_cal['cbcurrencyconverter_tocurrency'] : 'USD';
    //default to currency
    $cbcur_calc_default_amount  =  ( isset( $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] ) ) ? $setting_api_cal['cbcurrencyconverter_defaultamount_for_calculator'] : 1;
    //////////////////title//////////
    $cbcur_calc_default_title   =  ( isset( $setting_api_cal['cbcurrencyconverter_title_cal'] ) ) ? $setting_api_cal['cbcurrencyconverter_title_cal'] : __('Convert Currency','cbcurrencyconverter');
    /////////////////////result border
    $cbcur_cal_bordercolor      =  ( isset( $setting_api['cbcurrencyconverter_bordercolor'] ) ) ? $setting_api['cbcurrencyconverter_bordercolor'] : '#ffffff';
    // result
    if( array_key_exists( 'cbxccdefaultlayout' , $instance )  && $instance['cbxccuseglobal'] != 'on' ){


        $cbcur_from_currency        = $instance['cbxcalfromcurrency'];
        $cbcur_to_currencys         = $instance['cbxcaltocurrency'];

        $cbcur_calc_default_amount  = $instance['cbxcaldefaultamount'];

        $cbcur_calc_default_title   = $instance['cbxcaltitle'];


        // result
    }
    // var_dump($cbcur_calc_default_title);
    $cbcurrency_output          = '';

    $cbcurrency_output .= '<div class="cbcurrencyconverter_cal_wrapper cbcurrencyconverter_cal_wrapper'.$cbcur_reference.'">';
    // title
    $cbcurrency_output .= '<h4 class = "cbcurrencyconverter_heading">'.$cbcur_calc_default_title.'</h4>';
    $cbcurrency_output .= '<div class = "cbcurrencyconverter_result cbcurrencyconverter_result_'.$cbcur_reference.'"></div>';

    // amount input fields
    $cbcurrency_output .= '';
    $cbcurrency_output .= '<input  type = "hidden" class = "cbcurrencyconverter_cal_amount cbcurrencyconverter_cal_amount_'.$cbcur_reference.'" value ="'.$cbcur_calc_default_amount.'"/> ';

    //$cbcurrency_output .= '<input type="hidden" name="" value="">';

    $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields" style="display: none;">';
        $cbcurrency_output .= '<select  class = "cbcurrencyconverter_cal_from cbcurrencyconverter_cal_from_'.$cbcur_reference.'">';
        $cbcurrency_output .= '<option value="'.$cbcur_from_currency.'">'.__('Select a currency','cbcurrencyconverter').'</option>';

        foreach($cbcurrencyconverter_currency_list as $index => $currency){

            $cbcurrency_output .= '<option '.selected($cbcur_from_currency , $index , false).' value="'.$index.'">'.$currency.'('.$index.')'.'</option>';
        }

        $cbcurrency_output .= '</select>';
    $cbcurrency_output .= '</div>';



    $cbcurrency_output .= '<div class="cbcurrencyconverter_form_fields">';
        $cbcurrency_output .= '<select  class = "cbcurrencyconverter_cal_to cbcurrencyconverter_cal_to_'.$cbcur_reference.'">';

        $cbcurrency_output .= '<option value="'.$cbcur_to_currencys.'">'.__('Select a currency','cbcurrencyconverter').'</option>';

        foreach($cbcurrencyconverter_currency_list as $index=>$currency){

            $cbcurrency_output .= '<option '.selected($cbcur_to_currencys , $index , false).'  value="'.$index.'">'.$currency.'('.$index.')'.'</option>';
        }

        $cbcurrency_output .= '</select>';
    $cbcurrency_output .= '</div>';

    //up and down button
    $cbcurrency_output .= '<button  class="button button-primary cbcurrencyconverter_calculate cbcurrencyconverter_calculate_'.$cbcur_reference.'" data-busy = "0" data-ref = "'.$cbcur_reference.'" data-id = "down">'.__('Convert','cbcurrencyconverter').'</button> ';

    $cbcurrency_output .= '</div>';// end of wrapper div

    return $cbcurrency_output;
}
endif;