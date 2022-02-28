// import 'jquery';
// import '../plugins/isotope.pkgd.min'
jQuery(document).ready(function($) {

    $('ul li a').click(function(event) {
        // var type = $(this).attr('data-type');
        var type = $(this).data('filter');
        console.log(type);
        //var ten_loai = $(this).text();
        // $('.title').text(ten_loai);
        // type = '.'+type;
        $('.item-filter').isotope({
            itemSelector: '.isotop'
        });
        $('.item-filter').isotope({
            filter:type
        });
    });

    $('.content').isotope({
        itemSelector: 'img'
    });
    // $('ul li').click(function(event) {
    //     // var type = $(this).attr('data-type');
    //     var type = $(this).data('type');
    //     // console.log(type);
    //     var ten_loai = $(this).text();
    //     $('.title').text(ten_loai);
    //     type = '.'+type;
    //     $('.content').isotope({
    //         filter:type
    //     });
    // });


    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
});



