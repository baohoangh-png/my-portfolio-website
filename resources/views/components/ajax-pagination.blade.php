<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();
        let page = $(this).attr('href');
        $.ajax({
            url: page,
            type: "GET",
            success: function(response) {
                $('#list').html(response);
            }
        });
    });

    $(document).on('change', '.page-perpage', function(event) {
        event.preventDefault();
        let page = $(this).val();
        $.ajax({
            url: page,
            type: "GET",
            success: function(response) {
                $('#list').html(response);
            }
        });
    });
</script>
