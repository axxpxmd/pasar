@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4>
                        <i class="icon icon-address-card-o mr-2"></i>
                        Show {{ $title }} | {{ $pedagang->nm_pedagang }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li>
                        <a class="nav-link" href="{{ route($route.'index') }}"><i class="icon icon-arrow_back"></i>Semua Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content my-3" id="pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="semua-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h6 class="card-header"><strong>Data Pedagang</strong></h6>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Nama :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pedagang->nm_pedagang }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Alamat :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pedagang->alamat_pedagang }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>No Telp :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pedagang->no_telp }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>No KTP :</strong></label>
                                        <label class="col-md-3 s-12">{{ $pedagang->no_ktp }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>SHGP :</strong></label>
                                        <label class="col-md-3 s-12">
                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ config('app.sftp_src').'pedagang/'.$pedagang->shgp }}"><i class="icon icon-file"></i>Lihat File</a>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>KTP :</strong></label>
                                        <label class="col-md-3 s-12">
                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ config('app.sftp_src').'pedagang/'.$pedagang->ktp }}"><i class="icon icon-file"></i>Lihat File</a>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Kartu Keluarga :</strong></label>
                                        <label class="col-md-3 s-12">
                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ config('app.sftp_src').'pedagang/'.$pedagang->kk }}"><i class="icon icon-file"></i>Lihat File</a>
                                        </label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Foto Pedagang :</strong></label>
                                        <label class="col-md-3 s-12">
                                            <a target="blank" class="btn btn-sm btn-primary" href="{{ config('app.sftp_src').'pedagang/'.$pedagang->foto }}"><i class="icon icon-file"></i>Lihat File</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
