<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Helpers\ApiFormatter;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siswa = Siswa::all();

        if($siswa) {
            return ApiFormatter::createApi(200, 'success', $siswa);
        }else{
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $siswa = Siswa::create([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $getDataSaved = Siswa::where('id', $siswa->id)->first();

            if($getDataSaved) {
                return ApiFormatter::createApi(200, 'success', $getDataSaved);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $siswaDetail = Siswa::where('id', $id)->first();
            
            if ($siswaDetail) {
                return ApiFormatter::createApi(200, 'success', $siswaDetail);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nis' => 'required|min:8',
                'nama' => 'required|min:3',
                'rombel' => 'required',
                'rayon' => 'required',
            ]);

            $siswa = Siswa::findOrFail($id);

            $siswa->update([
                'nis' => $request->nis,
                'nama' => $request->nama,
                'rombel' => $request->rombel,
                'rayon' => $request->rayon,
            ]);

            $updatedSiswa = Siswa::where('id', $siswa->id)->first();

            if ($updatedSiswa) {
                return ApiFormatter::createApi(200, 'success', $updatedSiswa);
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
            
        }catch(Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $proses = $siswa->delete();

            if ($proses) {
                return ApiFormatter::createApi(200, 'success delete data!');
            }else{
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed', $error);
        }
    }


    public function createToken()
    {
        return csrf_token();
    }
}
