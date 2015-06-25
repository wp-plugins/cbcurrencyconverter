(function ( $ ) {
    "use strict";

    $(function () {

        // Place your public-facing JavaScript here
        $('.cbcurrencyconverter_result').hide();
        $('.cbcurrencyconverter_calculate').click(function(e){

            e.preventDefault();
            var cb_button_type          =  $(this).attr('data-id');
            var cb_button_ref           =  $(this).attr('data-ref');
            var cb_button_busy          =  $(this).attr('data-busy');
            var _this                   =  $(this);

            var cb_cur_data             = {};
            // take the value from button params
            cb_cur_data['type']         = cb_button_type;
            cb_cur_data['ref']          = cb_button_ref;
            cb_cur_data['cbcurconvert_error']    = '';
            cb_cur_data['cbcurconvert_amount']   =  $(this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_cal_amount_'+cb_button_ref).val();
            cb_cur_data['cbcurconvert_from']     = $(this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_cal_from_'+cb_button_ref).val();
            cb_cur_data['cbcurconvert_to']       = $(this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_cal_to_'+cb_button_ref).val();
            // validation check
            if(!cb_cur_data['cbcurconvert_to'].match(/^[A-Z]*$/) ){
                cb_cur_data['cbcurconvert_to']    = 'USD';
                cb_cur_data['cbcurconvert_error'] = 'Input in wrong format';
            }
            if(!cb_cur_data['cbcurconvert_from'].match(/^[A-Z]*$/) ){
                cb_cur_data['cbcurconvert_from']  = 'USD';
                cb_cur_data['cbcurconvert_error'] = 'Input in wrong format';
            }
            if(!(/^\+?(0|[1-9]\d*)$/.test(cb_cur_data['cbcurconvert_amount'])) ){
                cb_cur_data['cbcurconvert_amount'] = 1;
                cb_cur_data['cbcurconvert_error'] = 'Input in wrong format';
            }

            //console.log(cb_cur_data);
            if(cb_cur_data['cbcurconvert_error'] == '' && cb_button_busy == '0'){

                $('.cbcurrencyconverter_calculate').attr('data-busy' , '1');
                $(_this).addClass('cbcurrencyconverter_active');

                jQuery.ajax({
                    type        : "post",
                    dataType    : "json",
                    url         : currrency_convert.ajaxurl,
                    data        : {action: "currrency_convert",cb_cur_data:cb_cur_data},
                    success     : function(data, textStatus, XMLHttpRequest){
                        //console.log('success');
                        $(_this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_result_'+cb_button_ref).show();
                        if( cb_cur_data['type']  == 'up'){
                            // console.log('ia m here');
                            $(_this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_result_'+cb_button_ref).html(cb_cur_data['cbcurconvert_amount'] +' '+cb_cur_data['cbcurconvert_to']+ ' = '+  data +' '+  cb_cur_data['cbcurconvert_from']);
                        }
                        else{
                            $(_this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_result_'+cb_button_ref).html(cb_cur_data['cbcurconvert_amount'] +' '+cb_cur_data['cbcurconvert_from']+ ' = '+  data +' '+  cb_cur_data['cbcurconvert_to']);
                        }

                        $('.cbcurrencyconverter_calculate').attr('data-busy' , '0');
                        $(_this).removeClass('cbcurrencyconverter_active');
                    }
                });// end of ajax
            }// end of if error msg null
            else{

                $(_this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_result_'+cb_button_ref).show();
                $(_this).parents('.cbcurrencyconverter_cal_wrapper').find('.cbcurrencyconverter_result_'+cb_button_ref).html(cb_cur_data['cbcurconvert_error']);
            }


        });// end of click

    });// end of function

}(jQuery));