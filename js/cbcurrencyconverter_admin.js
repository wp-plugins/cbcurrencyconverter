(function ($) {
	"use strict";
	$(function () {
        //alert('hi there');
        // this is added by codeboxr
        var selected_array =[];
        $( "select.multiselect" )
            .change(function () {
                var root = $(this).parents('.text');
                $(root).find(".multi-select").each(function(){
                    $(this).removeAttr('checked','checked');

                });

                $(root).find( "select option:selected" ).each(function() {
                    var str = $( this ).val();

                    selected_array.push(str);
                    $(root).find(".multi-select").each(function(){
                        if($(this).val() ==str ){
                            // console.log($(this).val());
                            $(this).attr('checked','checked');
                        }
                    });
                });
                // $( "div.text" ).text( str );
            })
            .change();


        //initialize chosen plugin option
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }


        $('.wp-color-picker-field').wpColorPicker();
        // end of codeboxr custom code

    });
}(jQuery));