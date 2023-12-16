@extends('layouts.main', ['title' => ('Product Filter'), 'modal' => 'xl',])

@push('admin.css')
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatable/css/buttons.bootstrap4.min.css') }}">
@endpush

@section('header')
  <div class="btn-group btn-group-justified ml-3">
    <a href="{{ route('admin.general.settings') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cog fa-spin" aria-hidden="true"></i>@lang('Setting')</a>
    <a href="{{ route('today') }}" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-cc-diners-club" aria-hidden="true"></i>@lang('Today')</a>
    <a href="https://www.youtube.com/channel/UC02AhNHwgb5C3FGvzo9U0Wg" target="_blank" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-youtube-play" aria-hidden="true"></i>@lang('Tutorial')</a>
    <a href="https://sattit.com/" class="btn btn-light border-right ml-2 py-0"><i class="fa fa-question-circle" aria-hidden="true"></i>@lang('Help')</a>
  </div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-4">
                    <label for="product_category_id">Product Category</label>
                        <select name="category_id" id="category_id" class="form-control select" >
                            <option value="">All</option>
                         @foreach ($categories as $element)
                           <option value="{{ $element->id }}">{{ $element->category_name }}</option>
                         @endforeach
                        
                        </select>
                </div>

                <div class="col-md-4">
                    <label for="product_category_id">Product Brand</label>
                        <select name="brand_id" id="brand_id" class="form-control select" >
                            <option value="">All</option>
                         @foreach ($brands as $element)
                           <option value="{{ $element->id }}">{{ $element->brand_name }}</option>
                         @endforeach
                        
                        </select>
                </div>

                <div class="col-md-4 form-group">
                    <label for="product_code">Product Code <span class="text-danger"></span></label>
                    <input type="text" name="product_code" id="product_code" class="form-control" required placeholder="Enter Product Code">
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="accordion">


                <div class="card card-primary">
                    <a class="bg-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Product List
                            </h4>
                        </div>
                    </a>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered content_managment_table" data-url="{{ route('admin.products.products.datatable') }}">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Supplier</th>
                                            <th>Stock</th>
                                            <th>P. Cost</th>
                                            <th>P. Price</th>
                                            <th>Opening.S</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Supplier</th>
                                            <th>Stock</th>
                                            <th>P. Cost</th>
                                            <th>P. Price</th>
                                            <th>Opening.S</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

@endsection

@push('admin.scripts')
<script src="{{ asset('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/datatable/js/buttons.html5.min.js') }}"></script>

<script>
    var emran = "";
            $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            responsive: true,
            dom: '<"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            }
        });
        emran = $('.content_managment_table').DataTable({
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'copyHtml5',
                    text: '<i class="fa fa-clipboard" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="fa fa-table" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print" aria-hidden="true"></i>',
                    className: 'btn btn-sm btn-outline-info',
                    footer: true
                },
            ],

            columnDefs: [{
                width: "80px",
                targets: [0]
            }, {
                orderable: false,
                targets: [9]
            }],

            order: [0, 'desc'],
            processing: true,
            serverSide: true,
           ajax: { 
            url: $('.content_managment_table').data('url'),
            data: function(d) {
                d.brand_id = $('select#brand_id').val();
                d.category_id = $('select#category_id').val();
                d.product_code = $('input#product_code').val();
            },
          },
            columns: [
                // { data: 'checkbox', name: 'checkbox' },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                }, {
                    data: 'image',
                    name: 'image'
                }, {
                    data: 'product_code',
                    name: 'product_code'
                }, {
                    data: 'product_name',
                    name: 'product_name'
                }, {
                    data: 'supplier',
                    name: 'supplier'
                }, {
                    data: 'stock',
                    name: 'stock'
                }, {
                    data: 'cost',
                    name: 'cost'
                }, {
                    data: 'price',
                    name: 'price'
                }, {
                    data: 'opening',
                    name: 'opening'
                }, {
                    data: 'action',
                    name: 'action'
                }
            ]

        });

    $('select#brand_id, select#category_id').on(
        'change',
        function() {
            emran.ajax.reload();
        }
    );
      $('input#product_code').on('blur',function(){
          emran.ajax.reload();
      })
 _componentSelect2Normal();
</script>
@endpush
