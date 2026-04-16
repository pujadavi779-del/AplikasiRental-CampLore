<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // ── LIST ──────────────────────────────────────────
    public function index(Request $request)
    {
        $customers = Customer::query()
            ->withCount('rentals')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%")
                ->orWhere('nik', 'like', "%$s%")
                ->orWhere('phone', 'like', "%$s%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('admin.customers.index', compact('customers'));
    }

    // ── CREATE FORM ───────────────────────────────────
    public function create()
    {
        return view('admin.customers.create');
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

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('customers/photos', 'public');
        }
        if ($request->hasFile('document')) {
            $data['document'] = $request->file('document')->store('customers/documents', 'public');
        }
        if ($request->hasFile('agreement')) {
            $data['agreement'] = $request->file('agreement')->store('customers/agreements', 'public');
        }

        Customer::create($data);

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    // ── SHOW ──────────────────────────────────────────
    public function show(Customer $customer)
    {
        $customer->loadCount('rentals');
        return view('admin.customers.show', compact('customer'));
    }

    // ── EDIT FORM ─────────────────────────────────────
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    // ── UPDATE ────────────────────────────────────────
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'nik'           => 'required|string|max:20|unique:customers,nik,'.$customer->id,
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

        return redirect()->route('admin.customers.index')
            ->with('success', 'Data customer berhasil diperbarui!');
    }

    // ── DESTROY ───────────────────────────────────────
    public function destroy(Customer $customer)
    {
        if ($customer->photo)     Storage::disk('public')->delete($customer->photo);
        if ($customer->document)  Storage::disk('public')->delete($customer->document);
        if ($customer->agreement) Storage::disk('public')->delete($customer->agreement);

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}