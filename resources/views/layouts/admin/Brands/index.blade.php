@extends('admin')
@section('content')
    @if($errors->any())
        <script type="module"> 
            var myModal = new bootstrap.Modal(document.getElementById('addBrandsModal'), {
            keyboard: false
            })
            myModal.toggle();
            myModal.show();
        </script> 
    @endif
    
    @isset($brand)
    <script type="module"> 
            var myModal = new bootstrap.Modal(document.getElementById('addBrandsModal'), {
            keyboard: false
            })
            myModal.toggle();
            myModal.show();
    </script>
    @endisset
   <!-- Sale & Revenue Start -->
   <div class="container-fluid pt-4 px-4">
       <div class="row g-4">
           <div class="col-sm-6 col-xl-3">
               <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                   <i class="fa fa-chart-line fa-3x text-primary"></i>
                   <div class="ms-3">
                       <p class="mb-2">Today Sale</p>
                       <h6 class="mb-0">$1234</h6>
                   </div>
               </div>
           </div>
           <div class="col-sm-6 col-xl-3">
               <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                   <i class="fa fa-chart-bar fa-3x text-primary"></i>
                   <div class="ms-3">
                       <p class="mb-2">Total Sale</p>
                       <h6 class="mb-0">$1234</h6>
                   </div>
               </div>
           </div>
           <div class="col-sm-6 col-xl-3">
               <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                   <i class="fa fa-chart-area fa-3x text-primary"></i>
                   <div class="ms-3">
                       <p class="mb-2">Today Revenue</p>
                       <h6 class="mb-0">$1234</h6>
                   </div>
               </div>
           </div>
           <div class="col-sm-6 col-xl-3">
               <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                   <i class="fa fa-chart-pie fa-3x text-primary"></i>
                   <div class="ms-3">
                       <p class="mb-2">Total Revenue</p>
                       <h6 class="mb-0">$1234</h6>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Sale & Revenue End -->

   <!-- Recent Sales Start -->
   <div class="container-fluid pt-4 px-4">
       <div class="bg-light text-center rounded p-4">
           <div class="d-flex align-items-center justify-content-between mb-4">
               <h4 class="mb-0">Tất cả thương hiệu</h4>
               <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandsModal">
                    Thêm thương hiệu
                </button>
           </div>
           <div style="min-height: 75vh">
               <table class="table text-start align-middle table-bordered table-hover display mb-0" id="table-items">
                   <thead>
                       <tr class="text-dark">
                           <th scope="col">Action</th>
                           <th scope="col">Tên thương hiệu</th>
                           <th scope="col">Quốc gia</th>
                           <th scope="col">Thứ tự</th>
                           <th scope="col">Ngày tạo</th>
                           <th scope="col">Trạng thái</th>
                       </tr>
                   </thead>
                   <tbody>
                    @foreach ($brands as $bra)
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <a 
                                    class="btn btn-sm btn-primary me-2" href="{{ route('brand.edit', ['id' => $bra->id]) }}" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('brand.delete', ['id' => $bra->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button 
                                        class="btn btn-sm btn-danger" type="submit" title="Edit"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                            <td>{{$bra->name}}</td>
                            <td>{{$bra->country}}</td>
                            <td><span class="badge bg-primary">{{$bra->position}}</span></td>
                            <td><span class="badge bg-primary">{{$bra->created_at->format('d/m/Y')}}</span></td>
                            <td><span class="badge bg-primary">{{$bra->show_hide ? 'Hiện':'Ẩn'}}</span></td>
                        </tr>
                    @endforeach                      
                   </tbody>
               </table>
            </div>
       </div>
   </div>
   <!-- Recent Sales End -->
@endsection
@section('modal')
    <!-- Modal -->
    @include('layouts.admin.components.brandModal')
    <!--End Modal -->
@endsection
@section('css')
    <style rel="stylesheet">
        div.dt-button-collection {
            width: 400px;
        }
        
        div.dt-button-collection button.dt-button {
            display: inline-block;
            width: 32%;
        }
        div.dt-button-collection button.buttons-colvis {
            display: inline-block;
            width: 49%;
        }
        div.dt-button-collection h3 {
            margin-top: 5px;
            margin-bottom: 5px;
            font-weight: 100;
            border-bottom: 1px solid rgba(181, 181, 181, 0.5);
            font-size: 1em;
            padding: 0 1em;
        }
        div.dt-button-collection h3.not-top-heading {
            margin-top: 10px;
        }
    </style>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('#table-items').DataTable({
                columnDefs: [
                    {
                        targets: 1,
                        className: 'noVis'
                    }
                ],
                layout: {
                    topStart: {
                        buttons: [
                            'pageLength',
                            'spacer',
                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: [0, ':visible']
                                },
                            },
                            'spacer',
                            {
                                text: 'Setting',
                                extend: 'collection',
                                className: 'custom-html-collection',
                                buttons: [
                                    '<h3>Export</h3>',
                                    'pdf','excel','csv','print',
                                    '<h3 class="not-top-heading">Column Visibility</h3>',
                                    'colvisRestore',
                                    'columnsToggle',
                                ],
                            },
                          
                        ]
                    }
                }
            });
     
        });
     
    </script>
@endsection