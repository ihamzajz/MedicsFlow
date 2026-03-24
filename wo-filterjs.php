
<!-- Workorder Rp -->
<script>
        $(document).ready(function () {
            // Function to handle change in filters
            function applyFilters() {
                var priceRange = $('#priceRange').val();
                var finalStatus = $('#finalStatusFilter').val();
                var department = $('#departmentFilter').val(); // Get selected department
                var fromDate = $('#fromDate').val(); // Get selected "From" date
                var toDate = $('#toDate').val(); // Get selected "To" date
                filterTableData(priceRange, finalStatus, department, fromDate, toDate);
            }
            // Function to filter table data based on filters
            function filterTableData(priceRange, finalStatus, department, fromDate, toDate) {
                var minPrice, maxPrice;
                // Parse the price range
                if (priceRange === "all") {
                    minPrice = 0;
                    maxPrice = Number.POSITIVE_INFINITY;
                } else if (priceRange === "10000") {
                    minPrice = 10000;
                    maxPrice = Number.POSITIVE_INFINITY;
                } else {
                    var rangeParts = priceRange.split('-');
                    minPrice = parseInt(rangeParts[0]);
                    maxPrice = parseInt(rangeParts[1]);
                }
                $('#myTable tbody tr').each(function () {
                    var amount = parseInt($(this).find('td:nth-child(7)').text());
                    var rowFinalStatus = $(this).find('td[data-final-status]').data('final-status');
                    var rowDepartment = $(this).find('td:nth-child(3)').text().trim(); // Get department from third column
                    var rowDate = $(this).find('td:nth-child(4)').text().trim(); // Get date from fourth column

                    // Parse the row date and selected date
                    var rowDateObj = new Date(rowDate);
                    var selectedFromDate = new Date(fromDate);
                    var selectedToDate = new Date(toDate);

                    // Compare selected dates with row date
                    var dateMatch = (fromDate === "" || rowDateObj >= selectedFromDate) && (toDate === "" || rowDateObj <= selectedToDate);

                    if ((amount >= minPrice && amount <= maxPrice) && (finalStatus === 'All' || rowFinalStatus === finalStatus) && (department === 'All' || rowDepartment === department) && dateMatch) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
            $('#priceRange, #finalStatusFilter, #departmentFilter, #fromDate, #toDate').change(applyFilters);
        });
    </script>





<!-- Staff Allocation -->
 <script>
    $(document).ready(function () {
        $('#productFilter, #dateFromFilter, #dateToFilter').change(function () {
            var product = $('#productFilter').val();
            var dateFrom = $('#dateFromFilter').val();
            var dateTo = $('#dateToFilter').val();
            filterTable(product, dateFrom, dateTo);
        });
    });

    function filterTable(product, dateFrom, dateTo) {
        $('#myTable tbody tr').each(function () {
            var row = $(this);
            var rowProduct = row.find('td').eq(3).text();
            var rowDate = row.find('td').eq(8).text();

            var matchProduct = true;
            var matchDate = true;

            if (product !== "" && rowProduct !== product) {
                matchProduct = false;
            }

            if (dateFrom !== "" && new Date(rowDate) < new Date(dateFrom)) {
                matchDate = false;
            }
            if (dateTo !== "" && new Date(rowDate) > new Date(dateTo)) {
                matchDate = false;
            }

            if (matchProduct && matchDate) {
                row.show();
            } else {
                row.hide();
            }
        });
    }
</script>