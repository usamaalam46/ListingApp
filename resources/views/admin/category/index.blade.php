@extends('layouts.app')
@section('css')
<style>
  .container-fluid {
    margin-right: 10% !important;
  }
</style>
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<button class="btn btn-default" data-toggle="modal" data-target="#create-category">
  Add Category
</button>


<div id="create-category" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Category</h3>
      </div>
      <div class="modal-body">
        <form action="{{ route('category.store') }}" method="post">
          @csrf
          <div class="form-group mb-20">
            <input type="text" name="title" id="title" class="form-control" placeholder="Title in English" required>
          </div>
          <div class="form-group mb-20">
            <input type="text" name="title_arabic" id="title_arabic" class="form-control" placeholder="Title in Arabic" required>
          </div>
          <div class="form-group mb-20">
            <textarea name="description" class="form-control" id="" cols="30" rows="3" placeholder="Description"></textarea>
          </div>
          <div class="form-group mb-20">
            <textarea name="description_arabic" class="form-control" id="" cols="30" rows="3" placeholder="Description Arabic"></textarea>
          </div>
          <div class="form-group mb-20">
            <select name="is_featured" id="is_featured" class="form-control">
              <option value="1">Featured</option>
              <option value="0">Non Featured</option>
            </select>
          </div>
          <div class="form-group mb-20">
            <select name="active" id="active" class="form-control">
              <option value="1">Active</option>
              <option value="0">Non Active</option>
            </select>
          </div>
          <div class="form-group mb-20">
            <select name="show_menu" id="show_menu" class="form-control">
              <option value="1">Show in Menu</option>
              <option value="0">Non Show</option>
            </select>
          </div>
          <div class="button-group d-flex pt-25">
            <button class="btn btn-primary btn-default btn-squared text-capitalize">
              add new category
            </button>
            <!-- <button data-dismiss="modal"class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">cancel</button> -->
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@if(isset($categories) && count($categories) !=0)
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Category</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Categories</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Title Arabic</th>
                    <th>Description</th>
                    <th>Description Arabic</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($categories as $category)
                  <tr>

                    <td>{{isset($category->title)? $category->title : ''}}</td>
                    <td>{{isset($category->title_arabic)? $category->title_arabic : ''}}</td>
                    <td>{{$category->description}}</td>
                    <td>{{$category->description_arabic}}</td>
                    @if(isset($category->is_featured))
                    <td><span class="badge badge-secondary">Featured</span></td>
                    @else
                    <td><span class="badge badge-secondary">Non Featured </span></td>
                    @endif
                    @if(isset($category->active))
                    <td><span class="badge badge-secondary">Active</span></td>
                    @else
                    <td><span class="badge badge-secondary">Un Active</span></td>
                    @endif
                  </tr>
                  <td>
                    <div>
          
                        
                      <button class="btn btn-app" data-toggle="modal" data-target="#update-category-{{$category->id}}"><i class="fas fa-edit"></i></button>
                      <div id="update-category-{{$category->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Update Category</h3>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('category.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" id="{{$category->id}}" value="{{$category->id}}">
                                <div class="form-group mb-20">
                                  <input type="text" name="title" id="title" value="{{$category->title}}" class="form-control"  placeholder="Title in English" required>
                                </div>
                                <div class="form-group mb-20">
                                  <input type="text" name="title_arabic" value="{{$category->title_arabic}}" id="title_arabic" class="form-control" placeholder="Title in Arabic" required>
                                </div>
                                <div class="form-group mb-20">
                                  <textarea name="description"  class="form-control" id="" cols="30" rows="3" placeholder="Description">{{$category->description}}</textarea>
                                </div>
                                <div class="form-group mb-20">
                                  <textarea name="description_arabic" class="form-control" id="" cols="30" rows="3" placeholder="Description Arabic">{{$category->description_arabic}}</textarea>
                                </div>
                                <div class="form-group mb-20">
                                  <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="1" @if(isset($category->is_featured) == 1 ) selected="selected" @endif>Featured</option>
                                    <option value="0" @if(isset($category->is_featured) == 0 ) selected="selected" @endif>Non Featured</option>
                                  </select>
                                </div>
                                <div class="form-group mb-20">
                                  <select name="active" id="is_featured" class="form-control">
                                    <option value="1" @if(isset($category->active) == 1 ) selected="selected" @endif>Active</option>
                                    <option value="0" @if(isset($category->active) != 1 ) selected="selected" @endif>Non Active</option>
                                  </select>
                                </div>
                                <div class="form-group mb-20">
                                  <select name="show_menu" id="is_featured" class="form-control">
                                    <option value="1" @if(isset($category->show_in_menu) == 1 ) selected="selected" @endif>Show in Menu</option>
                                    <option value="0" @if(isset($category->show_in_menu) != 1 ) selected="selected" @endif>Non Show</option>
                                  </select>
                                </div>
                                <div class="button-group d-flex pt-25">
                                  <button class="btn btn-primary btn-default btn-squared text-capitalize">
                                    Update Category
                                  </button>
                                  <!-- <button data-dismiss="modal"class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">cancel</button> -->
                                </div>
                              </form>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div>
                    <button class="btn btn-app" data-toggle="modal" data-target="#delete-category-{{$category->id}}"><i class="fas fa-trash"></i></button>
                    <div id="delete-category-{{$category->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Delete Category</h3>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('category.destroy') }}" method="post">
                                @csrf
                                <div class="form-group mb-20">
                                <h3 class="card-title">Are You sure want to delete {{$category->title}}</h3>
                                </div>
                                
                                <input type="hidden" name="id" id="{{$category->id}}" value="{{$category->id}}">
                                <div class="form-group mb-20">
                                <div class="button-group d-flex pt-25 mt-5">
                                  <button class="btn btn-primary btn-default btn-squared text-capitalize">
                                    Delete Category
                                </button>
                                </div>
                                
                                  <!-- <button data-dismiss="modal"class="btn btn-light btn-default btn-squared fw-400 text-capitalize b-light color-light">cancel</button> -->
                                </div>
                              </form>
                    </div>

                  </td>
                  @endforeach
                </tbody>
              </table>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- /.content -->

</div>
@else
<h3 class="card-title">yet not added Category</h3>
@endif
@endsection

@section('js')
<script type="text/javascript">
  $(function() {
    $("#example2").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "responsive": true,
    });
  });
</script>
@endsection