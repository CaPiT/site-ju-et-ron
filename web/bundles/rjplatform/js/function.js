// ===================================================================
// Project : Ju & Ron
// Filename: functions.js
// Purpose : Main jquery script
// ===================================================================

(function($) {

	if ($(".description").size() > 0){

		// ===================================================================
		// + Description
		//====================================================================

		/***************** Affix Border *****************/

		var HeaderHeight    = $('.border-link').offset().top;
		var HeaderAffix     = $('.border-link');

		//Border Link height Viewport

		var heightViewport = $( window ).height();
		$( ".border-link" ).after().css( "height", heightViewport+"px" );

		    
		var idTravailJ = $('#travailJustine').offset().top;
		var idTravailR = $('#travailRon').offset().top;
		var idEtudesJ = $('#etudesJustine').offset().top;
		var idEtudesR = $('#etudesRon').offset().top;
		var idDiversJ = $('#diversJustine').offset().top;
		var idDiversR = $('#diversRon').offset().top;

	};
    
    function activeClass(){

	    /****************** Active Link ******************/

		var classTravailJ = $('.travail-justine');
		var classTravailR = $('.travail-ronan');
		var classEtudesJ = $('.etudes-justine');
		var classEtudesR = $('.etudes-ronan');
		var classDiversJ = $('.divers-justine');
		var classDiversR = $('.divers-ronan');

		//Justine

	    if(classTravailJ.offset().top < idTravailJ ){
	        classTravailJ.removeClass('active');
	    }
	    if(classTravailJ.offset().top > idTravailJ){
	        classTravailJ.addClass('active');
	    }

	    if(classEtudesJ.offset().top < idEtudesJ ){
	        classEtudesJ.removeClass('active');
	    }
	    else if(classEtudesJ.offset().top > idEtudesJ){
	    	classTravailJ.removeClass('active');
	        classEtudesJ.addClass('active');
	    }

	    if(classDiversJ.offset().top < idDiversJ ){
	        classDiversJ.removeClass('active');
	    }
	    else if(classDiversJ.offset().top > idDiversJ){
			classEtudesJ.removeClass('active');
	        classDiversJ.addClass('active');
	    }

	    //Ronan
    
	    if(classTravailR.offset().top < idTravailR ){
	        classTravailR.removeClass('active');
	    }
	    if(classTravailR.offset().top > idTravailR){
	        classTravailR.addClass('active');
	    }

	    if(classEtudesR.offset().top < idEtudesR ){
	        classEtudesR.removeClass('active');
	    }
	    else if(classEtudesR.offset().top > idEtudesR){
	    	classTravailR.removeClass('active');
	        classEtudesR.addClass('active');
	    }

	    if(classDiversR.offset().top < idDiversR ){
	        classDiversR.removeClass('active');
	    }
	    else if(classDiversR.offset().top > idDiversR){
			classEtudesR.removeClass('active');
	        classDiversR.addClass('active');
	    }

	}



	//Start On Scroll

	$(window).scroll(function(){
		if ($(".description").size() > 0){
			activeClass();
		}

	    if($(window).scrollTop() < HeaderHeight ){
	        HeaderAffix.removeClass('appear');
	    }
	    else if($(window).scrollTop() > HeaderHeight){
	        HeaderAffix.addClass('appear');
	    }
	});

	$(window).on('resize', function() {
		if ($(".description").size() > 0){
			activeClass();
		}
	})

	$(document).ready(function(){
		$('html, body').animate({
	        scrollTop: 0
	    }, 200);
	})

	$(document).on('click', '.anchor', function(event){
	    event.preventDefault();
		$('html, body').animate({
	        scrollTop: $( $.attr(this, 'href') ).offset().top
	    }, 500);
	});

    $(".menu-mobile").on("click", function(event){
        event.preventDefault();
        if($('.left-menu').hasClass('open')){
            $('.left-menu').removeClass('open');
            $(".menu-mobile").removeClass('active');
        } else {
            $('.left-menu').addClass('open');
            $(".menu-mobile").addClass('active');
        }
    });

    if($("#Glide").size() != 0) {
		$("#Glide").glide({
	        type: "carousel",
			mode: "horizontal",
	        centered: true
	    });
	}
    
    $(".section-forms").submit(function( event ) {
        event.preventDefault();
        var $form = $( this );
        
        var posting = $.post($form.attr( "action" ), { "params": $form.serializeArray() } );
         
        posting.done(function( data ) {
            $( "#save-section-"+$form.attr('data-section-id') ).html(data);
        });
   });
    
   $(".sections-delete").click(function( event ) {
       event.preventDefault();
       console.log($(this).attr('href'));
       id = $(this).attr('data-section-id');
       console.log(id);
       
       var getting = $.get($(this).attr('href'), function(data) {
           if (data == 'OK') {
           	console.log('section-block-'+id);
           	$('.section-block-'+id).hide();
           }
       });
  });

})( jQuery );