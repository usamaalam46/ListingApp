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
<button class="btn btn-default" data-toggle="modal" data-target="#create-translation">
  Add Translation
</button>


<div id="create-translation" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Notification</h3>
      </div>
      <div class="modal-body">
        <form action="{{ route('translation.store') }}" method="post">
          @csrf
          <div class="form-group mb-20">
            <input type="text" name="translation_group" id="translation_group" class="form-control" placeholder="Translation Group" required>
          </div>
          <div class="form-group mb-20">
            <input type="text" name="translation_key" id="translation_key" class="form-control" placeholder="Translation Key" required>
          </div>
          <div class="form-group mb-20">
            <input type="text" name="translation_english" id="translation_english" class="form-control" placeholder="Translation English" required>
          </div>
          <div class="form-group mb-20">
            <input type="text" name="translation_arabic" id="translation_arabic" class="form-control" placeholder="Translation Arabic" required>
          </div>
          <div class="button-group d-flex pt-25">
            <button class="btn btn-primary btn-default btn-squared text-capitalize">
              add new Translation
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

@if(isset($translations) && count($translations) !=0)
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Translation</h1>
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
              <h3 class="card-title">Translations</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Translation Group</th>
                    <th>Translation Key</th>
                    <th>Translation English</th>
                    <th>Translation Arabic</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($translations as $translation)
                  <tr>

                    <td>{{$translation->translation_group}}</td>
                    <td>{{$translation->translation_key}}</td>
                    <td>{{$translation->translation_english}}</td>
                    <td>{{$translation->translation_arabic}}</td>
                  </tr>
                  <td>
                    <div>


                      <button class="btn btn-app" data-toggle="modal" data-target="#update-translation-{{$translation->id}}"><i class="fas fa-edit"></i></button>
                      <div id="update-translation-{{$translation->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Update Product {{$translation->id}}</h3>
                            </div>

                            <div class="modal-body">
                              <form action="{{ route('translation.update') }}" method="post">
                                @csrf
                                <div class="form-group mb-20">
                                  <input type="text" name="translation_group" id="translation_group" value="{{$translation->translation_group}}" class="form-control" placeholder="Translation Group" required>
                                </div>
                                <div class="form-group mb-20">
                                  <input type="text" name="translation_key" id="translation_key" class="form-control" value="{{$translation->translation_key}}" placeholder="Translation Key" required>
                                </div>
                                <div class="form-group mb-20">
                                  <input type="text" name="translation_english" id="translation_english" class="form-control" value="{{$translation->translatio_english}}" placeholder="Translation English" required>
                                </div>
                                <div class="form-group mb-20">
                                  <input type="text" name="translation_arabic" id="translation_arabic" class="form-control" value="{{$translation->translation_arabic}}" placeholder="Translation Arabic" required>
                                </div>
                                <div class="button-group d-flex pt-25">
                                  <button class="btn btn-primary btn-default btn-squared text-capitalize">
                                    add new Translation
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
                      <button class="btn btn-app" data-toggle="modal" data-target="#delete-translation-{{$translation->id}}"><i class="fas fa-trash"></i></button>
                      <div id="delete-translation-{{$translation->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title">Delete Product</h3>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('translation.destory') }}" method="post">
                                @csrf
                                <div class="form-group mb-20">
                                  <h3 class="card-title">Are You sure want to delete {{$translation->title}} ?</h3>
                                </div>

                                <input type="hidden" name="id" id="{{$translation->id}}" value="{{$translation->id}}">
                                <div class="form-group mb-20">
                                  <div class="button-group d-flex pt-25 mt-5">
                                    <button class="btn btn-primary btn-default btn-squared text-capitalize">
                                      Delete Translation
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
<h3 class="card-title">yet not added Product</h3>
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