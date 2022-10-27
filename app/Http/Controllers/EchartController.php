<?php

namespace App\Http\Controllers;
use App\Presensi;
use App\Karyawan;
use Illuminate\Http\Request;

class EchartController extends Controller
{

    public function index(Request $request)
    {
        $status_masuk = Presensi::where('status','masuk')->get();
    	$status_belum_masuk = Presensi::where('status','belum masuk')->get();
    	$status_pulang = Presensi::where('status','pulang')->get();
    	$status_alpha = Presensi::where('status','alpha')->get();	
    	$status_telat = Presensi::where('status','telat')->get();
    	$masuk_count = count($status_masuk);
        $belum_masuk_count = count($status_belum_masuk);
        $pulang_count = count($status_pulang);
        $alpha_count = count($status_alpha);
        $telat_count = count($status_telat);

        $org_produksi = Karyawan::where('status','aktif')
                        ->where('organisasi_id', 2)->get();
    	$org_ketertiban = Karyawan::where('status','aktif')
                        ->where('organisasi_id', 3)->get();
    	$org_it = Karyawan::where('status','aktif')
                        ->where('organisasi_id', 5)->get();
    	$produksi_count = count($org_produksi);
        $ketertiban_count = count($org_ketertiban);
        $it_count = count($org_it);

        $data ['masuk_count'] = $masuk_count;
        $data ['belum_masuk_count'] = $belum_masuk_count;
        $data ['pulang_count'] = $pulang_count;
        $data ['alpha_count'] = $alpha_count;
        $data ['telat_count'] = $telat_count;

        $data ['produksi_count'] = $produksi_count;
        $data ['ketertiban_count'] = $ketertiban_count;
        $data ['it_count'] = $it_count;

        $data ['PARENTTAG'] = 'echart';

    	return view('pages.echart', $data);
    }
    
    public function echart(Request $request)
    {
    	$status_masuk = Presensi::where('status','masuk')->get();
    	$status_belum_masuk = Presensi::where('status','belum masuk')->get();
    	$status_pulang = Presensi::where('status','pulang')->get();
    	$status_alpha = Presensi::where('status','alpha')->get();	
    	$status_telat = Presensi::where('status','telat')->get();
    	$masuk_count = count($status_masuk);
        $belum_masuk_count = count($status_belum_masuk);
        $pulang_count = count($status_pulang);
        $alpha_count = count($status_alpha);
        $telat_count = count($status_telat);
    	return view('pages.echart',compact('masuk_count','belum_masuk_count','pulang_count','alpha_count','telat_count'));
    }
}