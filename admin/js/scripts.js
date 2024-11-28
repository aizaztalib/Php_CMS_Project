$(document).ready(function() {
    $('#summernote').summernote({
        height: 200
    });
  });

  function updateUserCount() {
    $.ajax({
        url: 'index.php?action=get_online_users', // Call the same file with an action
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#online-user-count').text(data.count);
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: ", status, error);
        }
    });
}

// Update user count every 10 seconds
$(document).ready(function() {
    updateUserCount(); // Initial call to set the user count
    setInterval(updateUserCount, 10000);
});
