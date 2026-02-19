<?php

namespace App\Http\Controllers;

use App\Models\QcInspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class QcInspectionController extends Controller
{
    // 1. GET ALL DATA (Untuk List di Admin Dashboard / History di Tablet)
    public function index()
    {
        // Ambil data beserta relasi customer & user biar lengkap
        $data = QcInspection::with(['customer', 'user', 'salesOrder'])
                ->orderBy('created_at', 'desc')
                ->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data QC Inspections',
            'data'    => $data
        ], 200);
    }

    // 2. STORE (Untuk Submit Data dari Tablet Flutter)
    public function store(Request $request)
    {
            // A. Validasi Input
        $validator = Validator::make($request->all(), [
        'no_lbts'        => 'required|unique:pt4.qc_inspections,no_lbts', 
        'tgl_lbts'       => 'required|date',
        'tablet_user_id' => 'required|exists:pt4.tablet_users,id',        
        'sales_order_id' => 'required|exists:pt4.sales_orders,id',        
        'customer_id'    => 'required|exists:pt4.customers,id',           
        'jenis_produk'   => 'required|string',
        'qty_check'      => 'required|integer',
        'status'         => 'required|in:Pass,Reject,Hold', 
        'foto_produk'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
    ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $pathFoto = null;
            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $filename = time() . '_' . $file->getClientOriginalName();
                $pathFoto = $file->storeAs('qc_images', $filename, 'public');
            }

            $qc = QcInspection::create([
                'no_lbts'          => $request->no_lbts,
                'tgl_lbts'         => $request->tgl_lbts,
                'tablet_user_id'   => $request->tablet_user_id,
                'sales_order_id'   => $request->sales_order_id,
                'customer_id'      => $request->customer_id,
                'no_pengganti'     => $request->no_pengganti, 
                'jenis_produk'     => $request->jenis_produk,
                'qty_check'        => $request->qty_check,
                'status'           => $request->status,
                'divisi_reject'    => $request->divisi_reject, 
                'remark'           => $request->remark,        
                'foto_produk_path' => $pathFoto,              
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data QC Berhasil Disimpan ke Azure!',
                'data'    => $qc
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menyimpan Data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

   
    public function show($id)
    {
        $qc = QcInspection::with(['customer', 'user', 'salesOrder'])->find($id);

        if (!$qc) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }
        return response()->json(['success' => true, 'data' => $qc], 200);
    }
}