<script>
  $(document).ready(function () {
    // ✅ Sidebar CLOSED on page load
    $('#sidebar').removeClass('active'); // or just don't addClass at all

    // Handle sidebar collapse toggle
    $('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
    });

    // Update the icon when collapsing/expanding
    $('[data-bs-toggle="collapse"]').on('click', function () {
      var target = $(this).find('.toggle-icon');
      if ($(this).attr('aria-expanded') === 'true') {
        target.removeClass('fa-plus').addClass('fa-minus');
      } else {
        target.removeClass('fa-minus').addClass('fa-plus');
      }
    });
  });
</script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search box
                // More options can be added as needed
            });
        });
    </script>
    <!-- Search -->
    <script>
        $(document).ready(function () {
            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })

            }(jQuery));
        });
    </script>








