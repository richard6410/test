<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理システム</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- TableSorter CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.bootstrap.min.css" integrity="正確なintegrityハッシュ" crossorigin="anonymous">

    <!-- TableSorter JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/js/jquery.tablesorter.min.js" integrity="sha384-oCzDl2l5CVox5cMh6KrCe5b6sWh0MYiTf4Yi7o2ekW0zsdSktFVQQwGPhWWi1DAZ" crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">

</head>
<body>
    <div class="container">
        <h1 style="font-size: 1.25rem;">管理システム</h1>
        @yield('content')
    </div>

    <!-- Bootstrap Bundle JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Check if #productTable exists before initializing tablesorter
        if ($('#productTable').length) {
            // Initialize TableSorter
            initializeTableSorter();

            // Handle Form Submission
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('action'),
                    data: {
                        syouhinmei: $('input[name="syouhinmei"]').val(),
                        company_name: $('select[name="company_name"]').val(),
                        price_min: $('input[name="price_min"]').val(),
                        price_max: $('input[name="price_max"]').val(),
                        stock_min: $('input[name="stock_min"]').val(),
                        stock_max: $('input[name="stock_max"]').val(),
                    },
                    success: function(response) {
                        $('#searchResults').html(response);
                        // Re-initialize TableSorter after updating the table
                        initializeTableSorter();
                    }
                });
            });
        }
        initializeTableSorter();

        function initializeTableSorter() {
            $('#productTable').tablesorter();
        }
    });

  </script>
</body>
</html>
