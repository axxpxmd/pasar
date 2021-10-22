<?php

namespace App\Http\Controllers\MasterTransaksi;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Model
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    protected $route = 'master-transaksi.transaksi.';
    protected $view  = 'pages.masterTransaksi.';
    protected $title = 'Transaksi';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    public function api()
    {
        $transaksi = Transaksi::all();
        return DataTables::of($transaksi)
            ->addIndexColumn()
            ->toJson();
    }
}
