<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
        .border-one {
            border-bottom: 2px dotted #ddd;
            border-top: 2px dotted #ddd;
        }

        .border-two {
            border: solid 4px #ddd;
        }

        .border-three {
            border-top: dotted 3px #ddd;
        }

        .table-bordered th {
            border: 0px solid #dee2e6;
            width: 15%;
        }

        .c-table {
            /* height: 200px; */
        }

    </style>
</head>

<body>
    <div id="print_table">
@yield('main_payment')
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p> টাকা = <span class="border rounded-pill" style="width: 200px; height: 10px">  </span></p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <span class="font-weight-bold border-three"> হিসাব রক্ষক </span>
                </div>
                <div class="col-md-3 text-center">
                    <span class="font-weight-bold border-three"> সুপার ভাইজার </span>
                </div>
                <div class="col-md-3 text-center">
                    <span class="font-weight-bold border-three"> ম্যানেজার </span>
                </div>
                <div class="col-md-3 text-right">
                    <span class="font-weight-bold border-three"> প্রোপাইটার </span>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mb-3">


        @php
        $print_table = 'print_table';
    
        @endphp
    
        <a class="text-light btn-primary btn d-print-none" onclick="printContent('{{ $print_table }}')" name="print"
            id="print_receipt">
            <i class="fa fa-print" aria-hidden="true"></i>
            Print Report
    
        </a>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>

<script>
    function printContent(el) {
        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        return window.location.reload(true);

    }
</script>
</body>

</html>
