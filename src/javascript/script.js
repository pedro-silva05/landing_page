window.addEventListener('scroll', function() {
    var header = document.getElementById('header');
    if (window.scrollY > 0) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

$(document).ready(function(){

    const sections = $('section');
    const navItens = $('.itens');

    $(window).on('scroll', function(){
        const headerScroll = $('header');
        const scrollPosition = $(window).scrollTop() - headerScroll.outerHeight();

        console.log(scrollPosition);

        let activeSectionIndex = 0;

        if (scrollPosition <= 0){
            headerScroll.css('box-shadow', 'none');
        } else {
            headerScroll.css('box-shadow', '5px 1px 5px rgba(0, 0, 0, 0.1)');
        }

        sections.each(function(i){
            const section = $(this);
            const sectionTop = section.offset().top - 96;
            const sectionBottom = sectionTop + section.outerHeight();

            if (scrollPosition >= sectionTop && scrollPosition < sectionBottom){
                activeSectionIndex = i;
                return false;
            }
        })
        navItens.removeClass('active');
        $(navItens[activeSectionIndex]).addClass('active');
    });
});