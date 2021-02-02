$('a.post_delete').on('click', function(evt) {
    let msg = 'Are you sure? Post will be permanently deleted!';
    if(!confirm(msg)) {
        evt.preventDefault();
    }
});

$('a.user_delete').on('click', function(evt) {
    let msg = 'Are you sure? Your user profile including all posts will be permanently deleted!';
    if(!confirm(msg)) {
        evt.preventDefault();
    }
});
