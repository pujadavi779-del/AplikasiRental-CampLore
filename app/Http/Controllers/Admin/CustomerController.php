<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // ── LIST ──────────────────────────────────────────
    public function index()
    {
        $customers = collect([
            (object)[
                'id'            => 1,
                'name'          => 'Budi Santoso',
                'nik'           => '3201010101010001',
                'phone'         => '081234567890',
                'address'       => 'Jl. Raya Batam Center No. 5, Batam Kota, Kepulauan Riau',
                'type'          => 'member',
                'status'        => 'aktif',
                'total_rentals' => 5,
                'document'      => 'dummy/ktp_budi.jpg',   // ada KTP
            ],
            (object)[
                'id'            => 2,
                'name'          => 'Siti Rahayu',
                'nik'           => '3201010101010002',
                'phone'         => '082345678901',
                'address'       => 'Jl. Sungai Langkai No. 19, Sekupang, Batam',
                'type'          => 'vip',
                'status'        => 'aktif',
                'total_rentals' => 8,
                'document'      => 'dummy/ktp_siti.jpg',   // ada KTP
            ],
            (object)[
                'id'            => 3,
                'name'          => 'Rizky Pratama',
                'nik'           => '3201010101010003',
                'phone'         => '083456789012',
                'address'       => 'Jl. Hang Lekir No. 7, Nongsa, Batam',
                'type'          => 'reguler',
                'status'        => 'aktif',
                'total_rentals' => 2,
                'document'      => null,                   // belum ada KTP
            ],
            (object)[
                'id'            => 4,
                'name'          => 'Dewi Lestari',
                'nik'           => '3201010101010004',
                'phone'         => '084567890123',
                'address'       => 'Jl. Duyung Blok B No. 12, Batu Ampar, Batam',
                'type'          => 'member',
                'status'        => 'nonaktif',
                'total_rentals' => 3,
                'document'      => 'dummy/ktp_dewi.jpg',   // ada KTP
            ],
        ]);

        return view('pages.admin.pengguna', compact('customers'));
    }

    // ── CREATE FORM ───────────────────────────────────
    public function create()
    {
        return view('pages.admin.pengguna.edit');
    }

    // ── STORE ─────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'nik'           => 'required|string|max:20|unique:customers,nik',
            'name'          => 'required|string|max:100',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'customer_type' => 'required|in:Pribadi,Perusahaan,Organisasi',
            'gender'        => 'required|in:L,P',
            'is_member'     => 'required|boolean',
            'discount'      => 'required|numeric|min:0|max:100',
            'document_type' => 'required|string',
            'document'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'agreement'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo'         => 'nullable|image|max:1024',
        ]);

        $data = $request->only([
            'nik', 'name', 'phone', 'address',
            'customer_type', 'gender', 'is_member',
            'discount', 'document_type',
        ]);

        $data['status'] = $request->has('status') ? 'aktif' : 'nonaktif';

        if ($request->hasFile('photo'))
            $data['photo'] = $request->file('photo')->store('customers/photos', 'public');
        if ($request->hasFile('document'))
            $data['document'] = $request->file('document')->store('customers/documents', 'public');
        if ($request->hasFile('agreement'))
            $data['agreement'] = $request->file('agreement')->store('customers/agreements', 'public');

        Customer::create($data);

        return redirect()->route('pages.admin.pelanggan.edit')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    // ── SHOW ──────────────────────────────────────────
    public function show(Customer $customer)
    {
        return view('pages.admin.pengguna.show', compact('customer'));
    }

    // ── EDIT FORM ─────────────────────────────────────
    public function edit(Customer $customer)
    {
        return view('pages.admin.pengguna.edit', compact('customer'));
    }

    // ── UPDATE ────────────────────────────────────────
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nik'           => 'required|string|max:20|unique:customers,nik,' . $customer->id,
            'name'          => 'required|string|max:100',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string',
            'customer_type' => 'required|in:Pribadi,Perusahaan,Organisasi',
            'gender'        => 'required|in:L,P',
            'is_member'     => 'required|boolean',
            'discount'      => 'required|numeric|min:0|max:100',
            'document_type' => 'required|string',
            'photo'         => 'nullable|image|max:1024',
            'document'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'agreement'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'nik', 'name', 'phone', 'address',
            'customer_type', 'gender', 'is_member',
            'discount', 'document_type',
        ]);

        $data['status'] = $request->has('status') ? 'aktif' : 'nonaktif';

        if ($request->hasFile('photo')) {
            if ($customer->photo) Storage::disk('public')->delete($customer->photo);
            $data['photo'] = $request->file('photo')->store('customers/photos', 'public');
        }
        if ($request->hasFile('document')) {
            if ($customer->document) Storage::disk('public')->delete($customer->document);
            $data['document'] = $request->file('document')->store('customers/documents', 'public');
        }
        if ($request->hasFile('agreement')) {
            if ($customer->agreement) Storage::disk('public')->delete($customer->agreement);
            $data['agreement'] = $request->file('agreement')->store('customers/agreements', 'public');
        }

        $customer->update($data);

        return redirect()->route('pages.admin.pelanggan.edit')
            ->with('success', 'Data customer berhasil diperbarui!');
    }

    // ── DESTROY ───────────────────────────────────────
    public function destroy(Customer $customer)
    {
        if ($customer->photo)     Storage::disk('public')->delete($customer->photo);
        if ($customer->document)  Storage::disk('public')->delete($customer->document);
        if ($customer->agreement) Storage::disk('public')->delete($customer->agreement);

        $customer->delete();

        return redirect()->route('pages.admin.pelanggan.edit')
            ->with('success', 'Customer berhasil dihapus!');
    }
}