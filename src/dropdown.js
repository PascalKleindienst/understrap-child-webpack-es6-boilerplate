import $ from 'jquery';

// Navigation (mobile)
const toggleDropdownMenu = (el) => {
    if (el.hasClass('dropdown')) {
        el.toggleClass('show').find('.dropdown-menu').stop(true,true).slideToggle(400);
    }
};

// Make link parent dropdown clickable
$('.dropdown-toggle').on('click', (e) => {
    window.location = e.target.href;
});

// Add an indicator to expand child items on mobile devices in lack of hover event
$('.navbar-nav > .menu-item')
    .each((index, element) => {
        const el = $(element);
        if (el.hasClass('menu-item-has-children')) {
            el.append('<span class="collapse-icon collapsed"></span>');
        }
    })
    .on('touchstart', '.collapse-icon', function() {
        const navbar = $(this).closest('.navbar-nav');
        toggleDropdownMenu(
            navbar
                .find('.collapse-icon:not(.collapsed)').toggleClass('collapsed').end()
                .find('li.show')
        );
        toggleDropdownMenu($(this).toggleClass('collapsed').closest('li'));

    })
    .on('mouseenter', function() {
        toggleDropdownMenu($(this));
    })
    .on('mouseleave', function() {
        const el = $(this);

        if (el.hasClass('dropdown')) {
            el.find('.dropdown-menu').stop(true,true).slideToggle(400, () => {
                el.toggleClass('show');
            });
        }
    });