<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Pelanggan::with('alamat_pengiriman')->get();
        return view('pages.admin.pengguna', compact('customers'));
    }

    // Ini fungsi show milik Admin untuk melihat detail Pengguna/Customer
    public function show($id)
    {
        $customer = Pelanggan::with('shippingAddress')->findOrFail($id);
        return view('pages.admin.pengguna.pengguna_detail', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Pelanggan::findOrFail($id);
        $customer->ktp_status = $request->ktp_status; 
        $customer->ktp_note   = $request->ktp_note;
        $customer->save();

        return redirect()->back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }

    public function create()
    {
        return view('pages.admin.pengguna.edit');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $customer = Pelanggan::findOrFail($id);
        return view('pages.pelanggan.pengguna.edit', compact('customer'));
    }

    public function destroy($id)
    {
        Pelanggan::findOrFail($id)->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
    
    
}