<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Pelanggan::all();
        return view('pages.admin.pengguna', compact('customers'));
    }

    public function show($id_pelanggan) // ← UPDATE parameter name
    {
        $customer = Pelanggan::with('alamat_pengiriman')->findOrFail($id_pelanggan);
        return view('pages.admin.pengguna.pengguna_detail', compact('customer'));
    }

    public function update(Request $request, $id_pelanggan) // ← UPDATE parameter name
    {
        $customer = Pelanggan::findOrFail($id_pelanggan);
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

    public function edit($id_pelanggan) // ← UPDATE parameter name
    {
        $customer = Pelanggan::findOrFail($id_pelanggan);
        return view('pages.pelanggan.pengguna.edit', compact('customer'));
    }

    public function destroy($id_pelanggan) // ← UPDATE parameter name
    {
        Pelanggan::findOrFail($id_pelanggan)->delete();
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}
