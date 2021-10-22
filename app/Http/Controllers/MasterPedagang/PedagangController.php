<?php

namespace App\Http\Controllers\MasterPedagang;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

// Model
use App\Models\Pedagang;

class PedagangController extends Controller
{
    protected $route = 'master-pedagang.pedagang.';
    protected $view  = 'pages.masterPedagang.pedagang.';
    protected $title = 'Pedagang';

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
        $pedagang = Pedagang::all();
        return DataTables::of($pedagang)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='edit(" . $p->id . ")' title='Edit Role'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Role'><i class='icon-remove'></i></a>";
            })
            ->editColumn('nm_pedagang',  function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->nm_pedagang . "</a>";
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'nm_pedagang'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_telp' => 'required',
            'no_ktp'  => 'required|min:16|unique:tm_pedagangs,no_ktp',
            'email'   => 'required',
            'nm_pedagang'     => 'required',
            'alamat_pedagang' => 'required',
            'ktp'  => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            'kk'   => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            'shgp' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            'foto' => 'required|mimes:png,jpg,jpeg|max:1024'
        ]);

        $path_sftp = 'pedagang/';

        // ktp
        $ktp = $request->file('ktp');
        $file_name_ktp = time() . "." . $ktp->getClientOriginalName();
        $ktp->storeAs($path_sftp, $file_name_ktp, 'sftp', 'public');

        // kk
        $kk = $request->file('kk');
        $file_name_kk = time() . "." . $kk->getClientOriginalName();
        $kk->storeAs($path_sftp, $file_name_kk, 'sftp', 'public');

        // shgp
        $shgp = $request->file('shgp');
        $file_name_shgp = time() . "." . $shgp->getClientOriginalName();
        $shgp->storeAs($path_sftp, $file_name_shgp, 'sftp', 'public');

        // foto
        $foto = $request->file('foto');
        $file_name_foto = time() . "." . $foto->getClientOriginalName();
        $foto->storeAs($path_sftp, $file_name_foto, 'sftp', 'public');

        $pedagang = new Pedagang();
        $pedagang->nm_pedagang     = $request->nm_pedagang;
        $pedagang->alamat_pedagang = $request->alamat_pedagang;
        $pedagang->no_ktp = $request->no_ktp;
        $pedagang->no_telp = $request->no_telp;
        $pedagang->ktp = $file_name_ktp;
        $pedagang->kk = $file_name_kk;
        $pedagang->shgp = $file_name_shgp;
        $pedagang->foto = $file_name_foto;
        $pedagang->email = $request->email;
        $pedagang->save();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil tersimpan.'
        ]);
    }

    public function show($id)
    {
        $title = $this->title;
        $route = $this->route;

        $pedagang = Pedagang::find($id);

        return view($this->view . 'show', compact(
            'route',
            'title',
            'pedagang'
        ));
    }

    public function edit($id)
    {
        $pedagang = Pedagang::findOrFail($id);

        return $pedagang;
    }

    public function update(Request $request, $id)
    {
        $pedagang = Pedagang::find($id);
        $request->validate([
            'nm_pedagang'     => 'required',
            'alamat_pedagang' => 'required',
            'no_ktp'  => 'required|min:16|unique:tm_pedagangs,no_ktp,' . $id,
            'no_telp' => 'required',
            // 'ktp'  => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            // 'kk'   => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            // 'shgp' => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            // 'foto' => 'required|mimes:png,jpg,jpeg|max:1024',
            'email' => 'required',
        ]);

        $path_sftp = 'pedagang/';

        // ktp
        if ($request->ktp != null) {
            $ktp = $request->file('ktp');
            $file_name_ktp = time() . "." . $ktp->getClientOriginalName();
            $ktp->storeAs($path_sftp, $file_name_ktp, 'sftp', 'public');

            $request->validate([
                'ktp'  => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            ]);

            Storage::disk('sftp')->delete($path_sftp . $pedagang->ktp);
        } else {
            $file_name_ktp = $pedagang->ktp;
        }

        // kk
        if ($request->kk != null) {
            $kk = $request->file('kk');
            $file_name_kk = time() . "." . $kk->getClientOriginalName();
            $kk->storeAs($path_sftp, $file_name_kk, 'sftp', 'public');

            $request->validate([
                'kk'   => 'required|mimes:png,jpg,jpeg,pdf|max:1024',
            ]);

            Storage::disk('sftp')->delete($path_sftp . $pedagang->kk);
        } else {
            $file_name_kk = $pedagang->kk;
        }

        // shgp
        if ($request->shgp != null) {
            $shgp = $request->file('shgp');
            $file_name_shgp = time() . "." . $shgp->getClientOriginalName();
            $shgp->storeAs($path_sftp, $file_name_shgp, 'sftp', 'public');

            $request->validate([
                'shgp' => 'required|mimes:png,jpg,jpeg,pdf|max:1024'
            ]);

            Storage::disk('sftp')->delete($path_sftp . $pedagang->shgp);
        } else {
            $file_name_shgp = $pedagang->shgp;
        }

        // foto
        if ($request->foto != null) {
            $foto = $request->file('foto');
            $file_name_foto = time() . "." . $foto->getClientOriginalName();
            $foto->storeAs($path_sftp, $file_name_foto, 'sftp', 'public');

            $request->validate([
                'foto' => 'required|mimes:png,jpg,jpeg|max:1024',
            ]);

            Storage::disk('sftp')->delete($path_sftp . $pedagang->foto);
        } else {
            $file_name_foto = $pedagang->foto;
        }

        $pedagang->update([
            'nm_pedagang'     => $request->nm_pedagang,
            'alamat_pedagang' => $request->alamat_pedagang,
            'no_ktp'  => $request->no_ktp,
            'no_telp' => $request->no_telp,
            'ktp'  => $file_name_ktp,
            'kk'   => $file_name_kk,
            'shgp' => $file_name_shgp,
            'foto' => $file_name_foto,
            'email' => $request->email
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function destroy($id)
    {
        $path_sftp = 'pedagang/';
        $pedagang  = Pedagang::find($id);

        Storage::disk('sftp')->delete($path_sftp . $pedagang->ktp);
        Storage::disk('sftp')->delete($path_sftp . $pedagang->kk);
        Storage::disk('sftp')->delete($path_sftp . $pedagang->shgp);
        Storage::disk('sftp')->delete($path_sftp . $pedagang->foto);

        $pedagang->delete();

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil dihapus.'
        ]);
    }
}
