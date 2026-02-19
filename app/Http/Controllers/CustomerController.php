<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    // 1. GET ALL: Paksa baca dari Azure PT4
    public function index()
    {
        // Pakai ::on('pt4') biar gak nyasar ke connection default
        $customers = Customer::on('pt4')->orderBy('nama_customer', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Master Customer PT 4',
            'data'    => $customers
        ], 200);
    }

    // 2. STORE: Paksa simpan ke Azure PT4
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_customer' => 'required|string|max:255|unique:pt4.customers,nama_customer',
            'kode_sap'      => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Pakai cara manual biar setConnection-nya mantap
        $customer = new Customer();
        $customer->setConnection('pt4'); 
        $customer->nama_customer = $request->nama_customer;
        $customer->kode_sap = $request->kode_sap;
        $customer->save();

        return response()->json([
            'success' => true, 
            'message' => 'Customer baru berhasil ditambahkan!', 
            'data' => $customer
        ], 201);
    }

    // 3. SHOW: Paksa cari di Azure PT4
    public function show($id)
    {
        $customer = Customer::on('pt4')->with('salesOrders')->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $customer], 200);
    }

    // 4. UPDATE: Paksa update di Azure PT4
    public function update(Request $request, $id)
    {
        $customer = Customer::on('pt4')->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_customer' => 'required|string|max:255|unique:pt4.customers,nama_customer,' . $id,
            'kode_sap'      => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $customer->setConnection('pt4');
        $customer->update($request->all());

        return response()->json(['success' => true, 'message' => 'Data Customer berhasil diupdate!', 'data' => $customer], 200);
    }

    // 5. DESTROY: Paksa hapus di Azure PT4
    public function destroy($id)
    {
        $customer = Customer::on('pt4')->find($id);

        if (!$customer) {
            return response()->json(['success' => false, 'message' => 'Customer tidak ditemukan'], 404);
        }

        if ($customer->salesOrders()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Gagal! Customer ini sudah memiliki riwayat Sales Order.'], 400);
        }

        $customer->setConnection('pt4');
        $customer->delete();

        return response()->json(['success' => true, 'message' => 'Customer berhasil dihapus!'], 200);
    }
}