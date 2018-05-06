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

});


