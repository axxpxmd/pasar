@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon icon-address-card-o mr-2"></i>
                        List {{ $title }}
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-7">
                <div class="card no-b">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <th width="30">No</th>
                                    <th>Nama Pedagang</th>
                                    <th>Nama Toko</th>
                                    <th>Kode Toko</th>
                                    <th>Alamat Toko</th>
                                    <th width="60"></th>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div id="alert"></div>
                <div class="card no-b">
                    <div class="card-body">
                        <form class="needs-validation" id="form" method="POST"  enctype="multipart/form-data" novalidate>
                            {{ method_field('POST') }}
                            <input type="hidden" id="id" name="id"/>
                            <h4 id="formTitle">Tambah Data</h4><hr>
                            <div class="form-row form-inline">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label s-12 col-md-4">Nama Pedagang</label>
                                        <div class="col-md-8 p-0 bg-light">
                                            <select class="select2 form-control r-0 light s-12" name="tm_pedagang_id" id="tm_pedagang_id" autocomplete="off">
                                                <option value="">Pilih</option>
                                                @foreach ($pedagang as $i)
                                                    <option value="{{ $i->id }}">{{ $i->nm_pedagang }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-5">
                                        <label class="col-form-label s-12 col-md-4">
                                            Alamat Toko
                                            <a class="ml-1 mt-1" data-toggle="popover" title="Info" data-html="true" data-content="Kolom 1 : Nama Pasar<br/>Kolom 2 : Jenis Lapak<br/>Kolom 3 : Ukuran<br/>Kolom 4 : Nama Blok">
                                                <i class="icon icon-information2 s-18 red-text"></i>
                                            </a>
                                        </label>
                                        <div class="col-md-8 p-0 bg-light">
                                            <select class="select2 form-control r-0 light s-12" name="tm_pasar_kategori_id" id="tm_pasar_kategori_id" autocomplete="off">
                                                <option value="">Pilih</option>
                                                @foreach ($alamatToko as $i)
                                                    <option value="{{ $i->id }}">{{ $i->pasar->nm_pasar }}&nbsp; [ {{ $i->jenisLapak->nm_jenis_lapak}} ] &nbsp;[ {{$i->ukuran}} ] &nbsp;[ {{$i->nm_blok}} ]</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-5">
                                        <label class="col-form-label s-12 col-md-4">Jenis Usaha</label>
                                        <div class="col-md-8 p-0 bg-light">
                                            <select class="select2 form-control r-0 light s-12" name="tm_jenis_usaha_id" id="tm_jenis_usaha_id" autocomplete="off">
                                                <option value="">Pilih</option>
                                                @foreach ($jenisUsaha as $i)
                                                    <option value="{{ $i->id }}">{{ $i->nm_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group m-t-5">
                                        <label for="nm_toko" class="col-form-label s-12 col-md-4">Nama Toko</label>
                                        <input type="text" name="nm_toko" id="nm_toko" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required/>
                                    </div>
                                    <div class="form-group m-0">
                                        <label for="tgl_tinggal" class="col-form-label s-12 col-md-4">Tanggal Tinggal</label>
                                        <input type="text" name="tgl_tinggal" id="tgl_tinggal" placeholder="" class="form-control r-0 light s-12 col-md-8" autocomplete="off" required/>
                                    </div>
                                    <div class="form-group m-0">
                                        <label for="" class="col-form-label s-12 col-md-4">Foto Tempat </label>
                                        <input type="file" name="foto_tempat" id="file" class="input-file" onchange="tampilkanPreview(this,'preview')">
                                        <label for="file" class="btn-tertiary js-labelFile col-md-8">
                                            <i class="icon icon-image mr-2 m-b-1"></i>
                                            <span id="changeText" class="js-fileName">Browse Image</span>
                                        </label>
                                    </div>
                                    <div class="form-group m-0">
                                        <label class="col-form-label s-12 col-md-4"></label>
                                        <img width="150" class="rounded img-fluid mt-2" id="preview" alt=""/>
                                    </div>
                                    <div class="form-group" style="margin-top: -10px !important">
                                        <label class="col-form-label s-12 col-md-4">
                                            Status
                                            <a class="ml-1 mt-1" data-toggle="popover" title="Info" data-html="true" data-content="Aktif : Toko Ditempati<br/>Tidak Aktif : Toko Tidak Ditempati">
                                                <i class="icon icon-information2 s-18 red-text"></i>
                                            </a>
                                        </label>
                                        <div class="col-md-8 p-0 bg-light">
                                            <select class="select2 form-control r-0 light s-12" name="status" id="status" autocomplete="off">
                                                <option value="">Pilih</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Tidak Aktif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt-2">
                                        <div class="col-md-4"></div>
                                        <button type="submit" class="btn btn-primary btn-sm" id="action"><i class="icon-save mr-2"></i>Simpan<span id="txtAction"></span></button>
                                        <a class="btn btn-sm" onclick="add()" id="reset">Reset</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    var table = $('#dataTable').dataTable({
        processing: true,
        serverSide: true,
        order: [ 1, 'asc' ],
        ajax: {
            url: "{{ route($route.'api') }}",
            method: 'POST'
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'tm_pedagang_id', name: 'tm_pedagang_id'},
            {data: 'nm_toko', name: 'nm_toko'},
            {data: 'kd_toko', name: 'kd_toko'},
            {data: 'tm_pasar_kategori_id', name: 'tm_pasar_kategori_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    (function () {
        'use strict';
        $('.input-file').each(function () {
            var $input = $(this),
                $label = $input.next('.js-labelFile'),
                labelVal = $label.html();

            $input.on('change', function (element) {
                var fileName = '';
                if (element.target.value) fileName = element.target.value.split('\\').pop();
                fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label
                    .removeClass('has-file').html(labelVal);
            });
        });
    })();

    function tampilkanPreview(gambar, idpreview) {
        var gb = gambar.files;
        for (var i = 0; i < gb.length; i++) {
            var gbPreview = gb[i];
            var imageType = /image.*/;
            var preview = document.getElementById(idpreview);
            var reader = new FileReader();
            if (gbPreview.type.match(imageType)) {
                preview.file = gbPreview;
                reader.onload = (function (element) {
                    return function (e) {
                        element.src = e.target.result;
                    };
                })(preview);
                reader.readAsDataURL(gbPreview);
            } else {
                $.confirm({
                    title: '',
                    content: 'Tipe file tidak boleh! haruf format gambar (png, jpg)',
                    icon: 'icon icon-close',
                    theme: 'modern',
                    closeIcon: true,
                    animation: 'scale',
                    type: 'red',
                    buttons: {
                        ok: {
                            text: "ok!",
                            btnClass: 'btn-primary',
                            keys: ['enter'],
                            action: add()
                        }
                    }
                });
            }
        }
    }

    $('#tgl_tinggal').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){},
        timepicker:false
    });

    function add(){
        save_method = "add";
        $('#form').trigger('reset');
        $('#formTitle').html('Tambah Data');
        $('input[name=_method]').val('POST');
        $('#txtAction').html('');
        $('#reset').show();
        $('#tm_pedagang_id').val("");
        $('#tm_pedagang_id').trigger('change.select2');
        $('#tm_jenis_usaha_id').val("");
        $('#tm_jenis_usaha_id').trigger('change.select2');
        $('#status').val("");
        $('#status').trigger('change.select2');
        $('#tm_pasar_kategori_id').removeAttr('disabled');
        $('#tm_pasar_kategori_id').val("");
        $('#tm_pasar_kategori_id').trigger('change.select2');
        $('#tm_pedagang_id').focus();
        $('#result').attr({ 'src': '-', 'alt': ''});
        $('#preview').attr({ 'src': '-', 'alt': ''});
    }

    add();
    $('#form').on('submit', function (e) {
        if ($(this)[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        else{
            $('#alert').html('');
            // $('#action').attr('disabled', true);
            url = (save_method == 'add') ? "{{ route($route.'store') }}" : "{{ route($route.'update', ':id') }}".replace(':id', $('#id').val());
            $.ajax({
                url : url,
                type : (save_method == 'add') ? 'POST' : 'POST',
                data: new FormData(($(this)[0])),
                contentType: false,
                processData: false,
                success : function(data) {
                    console.log(data);
                    $('#alert').html("<div role='alert' class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Success!</strong> " + data.message + "</div>");
                    table.api().ajax.reload();
                    location.reload();
                    if(save_method == 'add') add();    
                },
                error : function(data){
                    err = '';
                    respon = data.responseJSON;
                    if(respon.errors){
                        $.each(respon.errors, function( index, value ) {
                            err = err + "<li>" + value +"</li>";
                        });
                    }
                    $('#alert').html("<div role='alert' class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button><strong>Error!</strong> " + respon.message + "<ol class='pl-3 m-0'>" + err + "</ol></div>");
                }
            });
            return false;
        }
        $(this).addClass('was-validated');
    });

    function edit(id) {
        save_method = 'edit';
        var id = id;
        $('#alert').html('');
        $('#form').trigger('reset');
        $('#formTitle').html("Edit Data <a href='#' onclick='add()' class='btn btn-outline-danger btn-xs pull-right ml-2'>Batal</a>");
        $('#txtAction').html("Perubahan");
        $('#reset').hide();
        $('input[name=_method]').val('PATCH');
        $.get("{{ route($route.'edit', ':id') }}".replace(':id', id), function(data){
            $('#id').val(data.id);
            $('#nm_toko').val(data.nm_toko).focus();
            $('#kd_toko').val(data.kd_toko);
            $('#nm_blok').val(data.nm_blok);
            $('#tgl_tinggal').val(data.tgl_tinggal);
            $('#tm_pedagang_id').val(data.tm_pedagang_id);
            $('#tm_pedagang_id').trigger('change.select2');
            $('#tm_jenis_usaha_id').val(data.tm_jenis_usaha_id);
            $('#tm_jenis_usaha_id').trigger('change.select2');
            $('#status').val(data.status);
            $('#status').trigger('change.select2');
            $('#tm_pasar_kategori_id').val(data.tm_pasar_kategori_id);
            $('#tm_pasar_kategori_id').trigger('change.select2');
            $('#tm_pasar_kategori_id').prop('disabled', 'disabled');
            $('#alamat_pedagang').val(data.alamat_pedagang);
            var path = "https://dataawan.tangerangselatankota.go.id/pasar/tempat/"+data.foto_tempat;
            $('#preview').attr({'src': path, 'class': 'img-fluid', 'style': 'margin-left: 50%; margin-top: -5px !important; margin-bottom: 15px !important'});
            $('#changeText').html('Change Image')
        }, "JSON").fail(function(){
            reload();
        });
    }

    function remove(id){
        $.confirm({
            title: '',
            content: 'Apakah Anda yakin akan menghapus data ini ?',
            icon: 'icon icon-question amber-text',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'red',
            buttons: {
                ok: {
                    text: "ok!",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        $.post("{{ route($route.'destroy', ':id') }}".replace(':id', id), {'_method' : 'DELETE'}, function(data) {
                           table.api().ajax.reload();
                            if(id == $('#id').val()) add();
                        }, "JSON").fail(function(){
                            reload();
                        });
                    }
                },
                cancel: function(){}
            }
        });
    }

</script>
@endsection
