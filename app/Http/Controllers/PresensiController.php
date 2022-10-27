<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Presensi;
use App\Organisasi;
use App\Karyawan;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PresensiImport;
use App\Exports\PresensiExport;

class PresensiController extends Controller
{
    public function index(Request $request)
    {
    	$data ['PARENTTAG'] = 'presensi';
        $data ['list_organisasi'] = Organisasi::all();
        $data ['list_karyawan'] = Karyawan::all();

    	return view('pages.presensi',$data);
    }

    public function data(Request $request)
    {
    	$orderBy = 'presensi.tanggal';
        switch($request->input('order.0.column')){
            case "1":
                $orderBy = 'presensi.tanggal';
                break;
            case "2":
                $orderBy = 'presensi.nama';
                break;
            case "2":
                $orderBy = 'presensi.masuk';
                break;
            case "3":
                $orderBy = 'presensi.pulang';
                break;
            case "4":
                $orderBy = 'presensi.organisasi';
                break;
            case "5":
                $orderBy = 'presensi.status';
                break;
        }

        $data = Presensi::select([
            'presensi.*',
            'karyawan.nama as nama_karyawan'
        ])
        ->join('karyawan','karyawan.id','=','presensi.id')
        ;


        if($request->input('search.value')!=null){
            $data = $data->where(function($q)use($request){
                $q->whereRaw('LOWER(presensi.tanggal) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ->orWhereRaw('LOWER(karyawan.nama) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ->orWhereRaw('LOWER(presensi.masuk) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ->orWhereRaw('LOWER(presensi.pulang) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ->orWhereRaw('LOWER(presensi.organisasi) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ->orWhereRaw('LOWER(presensi.status) like ? ',['%'.strtolower($request->input('search.value')).'%'])
                ;
            });
        }

        $recordsFiltered = $data->get()->count();
        if($request->input('length')!=-1) $data = $data->skip($request->input('start'))->take($request->input('length'));
        $data = $data->orderBy($orderBy,$request->input('order.0.dir'))->get();
        $recordsTotal = $data->count();
        return response()->json([
            'draw'=>$request->input('draw'),
            'recordsTotal'=>$recordsTotal,
            'recordsFiltered'=>$recordsFiltered,
            'data'=>$data
        ]);
    }
    
    /*public function getOrganisasi($nama){
        $dataNama = Presensi::join('karyawan', 'karyawan.id', '=', 'presensi.id')
              		->join('organisasi', 'organisasi.id', '=', 'karyawan.organisasi_id')
                    ->where('karyawan.nama','=',$nama)
              		->get(['organisasi.nama']);

        return response()->jsonencode(['dataNama' => $dataNama]);
        
    }*/

    public function getOrg(Request $request) {
        if ($request->org_id) {
            $namas = Karyawan::join('organisasi', 'karyawan.organisasi_id', '=', 'organisasi.id')
            ->where('karyawan.nama',$request->org_id)
            ->get(['organisasi.nama']);
            if ($namas) {
                return response()->json(['status' => 'success', 'data' => $namas], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'Organisasi Tidak Ada'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Silakan Pilih Nama'], 500);
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
    	$request->merge([
    		'created_at'=>date('Y-m-d H:i:s')
    	]);
    	$presensi = $request->except(['_token']);
    	Presensi::create($presensi);
    	return response()->json(true);
    }

    public function edit(Request $request)
    {
    	$presensi = Presensi::where('id',$request->id)->first();
    	$presensi->tanggal = $request->tanggal;
    	$presensi->nama = $request->nama;
        $presensi->masuk = $request->masuk;
    	$presensi->pulang = $request->pulang;
        $presensi->organisasi = $request->organisasi;
    	$presensi->status = $request->status;
    	$presensi->updated_at = date('Y-m-d H:i:s');
    	$presensi->save();
    	return response()->json(true);
    }

    public function hapus($id)
    {
    	//if($id==\Auth::user()->id) return response()->json(false);
    	Presensi::where('id',$id)->delete();
    	return response()->json(true);
    }

    public function hapusBeberapa(Request $request)
    {
    	Presensi::whereIn('id',$request->ids)->delete();
    	return response()->json(true);
    }
}
