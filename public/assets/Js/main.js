const body = document.querySelector('.js-body');

if (localStorage.getItem('nightActivated') === 'true') {
    body.classList.add('night-activated');
}

const nightToggleBtn = document.querySelector('.js-night-toggle');

nightToggleBtn.addEventListener('click', function() {

    if (body.classList.contains('night-activated')) {
        body.classList.remove('night-activated');
        localStorage.removeItem('nightActivated');
    } else {
        body.classList.add('night-activated');
        localStorage.setItem('nightActivated', "true");
    }

});