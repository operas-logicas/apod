// Confirm delete post
$('a.post_delete').on('click', function(evt) {
    let msg = 'Are you sure? Post will be permanently deleted!';
    if(!confirm(msg)) {
        evt.preventDefault();
    }
});

// Confirm delete user
$('a.user_delete').on('click', function(evt) {
    let msg = 'Are you sure? Your user profile including all posts will be permanently deleted!';
    if(!confirm(msg)) {
        evt.preventDefault();
    }
});

// Get APOD from NASA using ajax
$('#get_nasa_apod').on('click', function(evt) {
    evt.preventDefault();

    let url = 'https://api.nasa.gov/planetary/apod';
    let date = $('#nasa_apod_url').prop('value');

    $.getJSON(url,
        {
            thumbs: 'true',
            date: date,
            api_key: 'DEMO_KEY'
        },

        function(result) {
            $('#img_url').attr('value', result.thumbnail_url ? result.thumbnail_url : result.url);
            $('#title').attr('value', result.title);
            $('#copyright').attr('value', result.copyright ? result.copyright : null);
            $('#original_date').attr('value', result.date);
            $('#explanation').html(result.explanation);
        }
    );
});
