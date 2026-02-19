<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{
    /**
     * ==========================================
     * 📱 FUNGSI KHUSUS TABLET: SEARCHING (DROPDOWN)
     * ==========================================
     * GET /api/pt4/sales-orders/search?keyword=SO20
     */
    public function searchBySo(Request $request)
    {
        // Tangkap ketikan dari form search di Flutter
        $keyword = $request->query('keyword');

        // Bikin query pencarian, tarik sekalian nama customernya
        $query = SalesOrder::with('customer')->orderBy('created_at', 'desc');

        // Kalau staf ngetik sesuatu, filter pakai LIKE (Partial Match)
        if ($keyword) {
            $query->where('no_so', 'LIKE', '%' . $keyword . '%');
        }

        // Ambil datanya jadi List/Array (Maksimal 50 baris biar tablet gak lemot)
        $sos = $query->limit(50)->get();

        if ($sos->isEmpty()) {
            return response()->json([
                'success' => false, 
                'message' => 'Data Sales Order tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data SO ditemukan',
            'data'    => $sos // Ingat: Ini sekarang bentuknya List [ {..}, {..} ]
        ], 200);
    }

    /**
     * ==========================================
     * 💻 FUNGSI KHUSUS DESKTOP (ADMIN FULL CRUD)
     * ==========================================
     */

    // 1. GET ALL (Buat isi tabel list SO di Desktop)
    public function index()
    {
        $orders = SalesOrder::with('customer')->orderBy('created_at', 'desc')->get();
        return response()->json(['success' => true, 'data' => $orders], 200);
    }

    // 2. STORE (Admin Desktop bikin/nambahin SO baru)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_so'       => 'required|string|max:20|unique:pt4.sales_orders,no_so',
            'customer_id' => 'required|exists:pt4.customers,id',
            'tanggal_so'  => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $so = SalesOrder::create([
            'no_so'       => $request->no_so,
            'customer_id' => $request->customer_id,
            'tanggal_so'  => $request->tanggal_so,
        ]);

        return response()->json(['success' => true, 'message' => 'SO Berhasil dibuat!', 'data' => $so], 201);
    }

    // 3. SHOW (Admin lihat detail 1 SO)
    public function show($id)
    {
        $so = SalesOrder::with('customer')->find($id);

        if (!$so) {
            return response()->json(['success' => false, 'message' => 'Data SO tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $so], 200);
    }

    // 4. UPDATE (Admin Desktop ngedit kalau salah ketik)
    public function update(Request $request, $id)
    {
        $so = SalesOrder::find($id);

        if (!$so) {
            return response()->json(['success' => false, 'message' => 'Data SO tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'no_so'       => 'required|string|max:20|unique:pt4.sales_orders,no_so,' . $id,
            'customer_id' => 'required|exists:pt4.customers,id',
            'tanggal_so'  => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $so->update([
            'no_so'       => $request->no_so,
            'customer_id' => $request->customer_id,
            'tanggal_so'  => $request->tanggal_so,
        ]);

        return response()->json(['success' => true, 'message' => 'Data SO berhasil diupdate!', 'data' => $so], 200);
    }

    // 5. DESTROY (Admin Desktop hapus SO yang dibatalkan)
    public function destroy($id)
    {
        $so = SalesOrder::find($id);

        if (!$so) {
            return response()->json(['success' => false, 'message' => 'Data SO tidak ditemukan'], 404);
        }

        // Proteksi anti-error: Kalau SO udah ada laporan QC-nya, tolak hapus!
        if ($so->qcInspections()->count() > 0) {
            return response()->json([
                'success' => false, 
                'message' => 'Gagal! SO ini sudah memiliki riwayat inspeksi QC (LBTS).'
            ], 400);
        }

        $so->delete();

        return response()->json(['success' => true, 'message' => 'Sales Order berhasil dihapus!'], 200);
    }
}