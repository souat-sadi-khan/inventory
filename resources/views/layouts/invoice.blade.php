<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awosome.min.css') }}">
    <title>{{ isset($title) ? $title : '' }} | {{get_option('site_titlee') && get_option('site_titlee') != '' ? get_option('site_titlee') : 'Sadik'}}</title>

<style>
    .border-one{
        border-bottom: 2px dotted #ddd;
        border-top: 2px dotted #ddd;
    }
    
    .border-two{
        border: solid 4px #ddd;
    }
    
    .border-three{
        border-top: dotted 3px #ddd;
    }
    
  .table-bordered th {
        border: 0px solid #dee2e6;
    width: 15%;
    }
    
    .c-table{
        height: 200px;
    }
        
      
</style>
  </head>
  <body>
<div id="printarea">
    @yield('main_invoice')
   
   <div class="container">
      <div class="row py-2 mx-5">
          <div class="col-md-12 text-center">
              <p> পন্যের  গুনগত মান ও ওজন দেখে নিন । </p>
          </div>
      </div>
       <div class="row mx-5 mb-5">
           <div class="col-md-4">
           <span class="font-weight-bold border-three"> ক্রেতার সাক্ষর </span>
           </div>
           <div class="col-md-4 text-center">
           <span class="font-weight-bold border-"> <i> ধন্যবাদ আবার আসবেন </i>  </span>
           </div>
           <div class="col-md-4 text-right">
           <span class="font-weight-bold border-three"> বিক্রেতার সাক্ষর  </span>
           </div>
       </div>
   </div>

</div>
       <div class="text-center mb-3">

        @if (isset($url))
           <a href="{{ $url }}" class="text-light btn-info btn d-print-none">
            <i class="fa fa-fast-backward" aria-hidden="true"></i>
            Back
    
        </a>
        @endif
        <a class="text-light btn-danger btn d-print-none" onclick="printContent('printarea')" name="print"
            id="print_receipt">
            <i class="fa fa-print" aria-hidden="true"></i>
            Print
    
        </a>
    </div>
   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
    function printContent(el) {
        console.log('print clicked');

        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;

        // return window.location.reload(true);

    }
</script>
  </body>
</html>