jQuery(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.ui.dropdown').dropdown();


    $('[data-toggle=popup]').popup();


    $('.ui.accordion').accordion();


    $('.tabular.menu .item').tab();


    $('.ui.checkbox, .ui.radio.checkbox').checkbox();

    $('nav .ui.toggle.button').click(function() {
      $('nav .ui.vertical.menu').toggle(250, 'linear');
    });
    

	$('.image-file .image-preview').click(function(){
        $(this).parent().find('input[type="file"]').click();
    });
    

    $('.image-file input[type="file"]').change(function(event){
        var $this = $(this);
        if( $this == '' ){
        	var default_image = $this.parent().find('.image-preview').data('default');
        	$this.parent().find('.image-preview').css('background-image', 'url(' + default_image + ')');
        }
        var input = $(event.currentTarget);
        var file = input[0].files[0];
        if( file.type.match("image/jpeg") || file.type.match("image/png") ){
            var photosize = $this[0].files[0].size/1000000;
            if( photosize > 5 ){
                alert("Error: Image file too big. Please select image file less than 5MB.");
            }
            else{
                var oFReader = new FileReader();
                oFReader.readAsDataURL(this.files[0]);
                oFReader.onload = function (oFREvent) {
                    $this.parent().find('.image-preview').css('background-image', 'url('+oFREvent.target.result+')');
                }
            }
        }
        
        else{
            alert("Error: Invalid image file!");
            $this.val('');
        }
    });

    $('#mobile-menu').click(function(){
        $(this).toggleClass('toggled');
        $('#cs-sidebar').toggleClass('toggled');
    });

    $('.has-loader').on('submit', function(e){
        if( !$(this).hasClass('submitting') && $(this).form('is valid') ) {
            $(this).addClass('submitting');
            $(this).find('.has-loader-button').addClass('loading');
            $(this).find('.has-loader-button').prop('disabled', true);
            $(this).submit();
        } else {
            e.preventDefault();
            return false;
        }
    });

    $('.pricing-toggle a').click(function(){
        var target = $(this).data('target');
        $('.pricing-toggle a').removeClass('background-blue');
        $(this).addClass('background-blue');

        var pricing_table = $('.pricing-table');
        pricing_table.find('.mobile-only').removeClass('show');
        pricing_table.find('.hide-mobile').removeClass('show');
        pricing_table.find(target).addClass('show');
    });

   /* $('.format-number').on('blur', function(){
        var content = $(this).val().trim();
        var response = $(this).hasClass('optional') ? '' : '0.00';
        if( content ){
            var value = parseF
            var whole = 0;
            var dec = 0;
            var dec_format = '';
            content = content.split('.');
            whole = content[0] ? parseInt(content[0].replace(/\D/g,'')).toString() : '0';
            if( content.length > 1 ){
                for( var i = 1; i < content.length - 1; i++ ){
                    var index_value = content[i].replace(/\D/g,'');
                    whole +=  (parseInt(index_value) > 0) ? index_value: '';
                }
                if( content[content.length-1] ) {
                    dec = '.'+content[content.length-1].replace(/\D/g,'');
                    dec = Math.round( dec * 100 ) / 100;
                    if( dec > 0 ){
                        dec = dec.toString().split('.');
                        dec[1] = (dec[1].length > 1) ? dec[1] : dec[1] + '0';
                        dec_format = '.' + dec[1];
                        dec = parseInt(dec[1]);
                    }
                }
            }
            whole = parseInt(whole);
            if( (whole + dec) > 0 ){
                response = whole.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + dec_format;
            } 
        }
        $(this).val(response);
    });*/


    function formatNumber(value){
        var content = value.trim();
        content = content.replace(/,/g , '');
        var response = $(this).hasClass('optional') ? '' : '0.00';
        if( content ){
            var value = parseFloat(content).toFixed(2);
            if( !isNaN(value) ){
                response = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }
        return response;
    }

    $('.format-number').on('blur', function(){
        var content = formatNumber($(this).val());
        $(this).val(content);
    });







});


