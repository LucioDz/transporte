
//// codigo não nativo do desenvolvedor , 
// oBS : pesquise por magnific popup


$(document).ready(function() {

$('.galleria-001').magnificPopup({

    delegate: 'a', // child item selector , by clicking on it Popup will open 
    type: 'image',
    gallery:{enabled:true}

        // other options
})

});

/*

$(document).ready(function() {

    $('.image-link').magnificPopup({type: 'image'});
   
   });

   */