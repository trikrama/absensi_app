<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignatureController extends Controller
{
    //
    public function index()
    {
        $signatures = Signature::all();
        return view('signatures.index', compact('signatures'));
    }

    // Tampilkan form untuk tambah TTD
    public function create()
    {
        return view('signatures.create');
    }

    // Simpan data TTD baru
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'name' => 'required',
    //         'position' => 'nullable',
    //         'image' => 'nullable|image|max:2048', // Maksimal 2MB
    //     ]);

    //     $ttd = null;
    //     if ($request->hasFile('image')) {
    //         $img_signature = $request->file('image');
    //         $folderPath = "public/uploads/ttd/";
    //         $img_signature->storeAs($folderPath, $img_signature->getClientOriginalName());
    //         $ttd = $img_signature->getClientOriginalName();
    //     }


    //     Signature::create([
    //         'name' => $request->name,
    //         'position' => $request->position,
    //         'image' => $ttd,
    //     ]);

    //     return redirect()->route('signatures.index')->with('success', 'TTD berhasil ditambahkan.');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name_1' => 'required',
    //         'position_1' => 'nullable',
    //         'image_1' => 'nullable|image|max:2048',
    //         'name_2' => 'required',
    //         'position_2' => 'nullable',
    //         'image_2' => 'nullable|image|max:2048',
    //     ]);

    //     $signatures = Signature::all();

    //     // Handle TTD 1
    //     $ttd1 = $signatures->get(0) ?? new Signature();
    //     $image1 = $ttd1->image;
    //     if ($request->hasFile('image_1')) {
    //         if ($image1) {
    //             Storage::delete("public/uploads/ttd/" . $image1);
    //         }
    //         $img1 = $request->file('image_1');
    //         $folderPath = "public/uploads/ttd/";
    //         $img1->storeAs($folderPath, $img1->getClientOriginalName());
    //         $image1 = $img1->getClientOriginalName();
    //     }
    //     $ttd1->fill([
    //         'name' => $request->name_1,
    //         'position' => $request->position_1,
    //         'image' => $image1,
    //     ])->save();

    //     // Handle TTD 2
    //     $ttd2 = $signatures->get(1) ?? new Signature();
    //     $image2 = $ttd2->image;
    //     if ($request->hasFile('image_2')) {
    //         if ($image2) {
    //             Storage::delete("public/uploads/ttd/" . $image2);
    //         }
    //         $img2 = $request->file('image_2');
    //         $folderPath = "public/uploads/ttd/";
    //         $img2->storeAs($folderPath, $img2->getClientOriginalName());
    //         $image2 = $img2->getClientOriginalName();
    //     }
    //     $ttd2->fill([
    //         'name' => $request->name_2,
    //         'position' => $request->position_2,
    //         'image' => $image2,
    //     ])->save();

    //     return redirect()->route('signatures.index')->with('success', 'TTD berhasil disimpan.');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name_1' => 'nullable', // Tidak wajib
            'position_1' => 'nullable',
            'image_1' => 'nullable|image|max:10240',
            'name_2' => 'nullable', // Tidak wajib
            'position_2' => 'nullable',
            'image_2' => 'nullable|image|max:10240',
        ]);

        // Handle TTD 1
        if ($request->name_1) {
            $ttd1 = Signature::firstOrNew(['type' => 'TTD1']);
            $image1 = $ttd1->image;
            if ($request->hasFile('image_1')) {
                if ($image1) {
                    Storage::delete("public/uploads/ttd/" . $image1);
                }
                $img1 = $request->file('image_1');
                $folderPath = "public/uploads/ttd/";
                $img1->storeAs($folderPath, $img1->getClientOriginalName());
                $image1 = $img1->getClientOriginalName();
            }
            $ttd1->fill([
                'type' => 'TTD1',
                'name' => $request->name_1,
                'position' => $request->position_1,
                'image' => $image1,
            ])->save();

            // Handle TTD 2 (jika diisi)
            if ($request->name_2) {
                $ttd2 = Signature::firstOrNew(['type' => 'TTD2']);
                $image2 = $ttd2->image;
                if ($request->hasFile('image_2')) {
                    if ($image2) {
                        Storage::delete("public/uploads/ttd/" . $image2);
                    }
                    $img2 = $request->file('image_2');
                    $folderPath = "public/uploads/ttd/";
                    $img2->storeAs($folderPath, $img2->getClientOriginalName());
                    $image2 = $img2->getClientOriginalName();
                }
                $ttd2->fill([
                    'type' => 'TTD2',
                    'name' => $request->name_2,
                    'position' => $request->position_2,
                    'image' => $image2,
                ])->save();
            }

            return redirect()->route('signatures.index')->with('success', 'TTD berhasil disimpan.');
        }
        
    }


    public function edit(Signature $signature)
    {
        return view('signatures.edit', compact('signature'));
    }

    // Update data TTD
    public function update(Request $request, Signature $signature)
    {
        try {
            $request->validate([
                'name' => 'required',
                'position' => 'nullable',
                'image' => 'nullable|image|max:10240', // Maksimal 2MB
            ]);

            $ttd = $signature->image; // Default adalah file lama jika tidak ada file baru

            if ($request->hasFile('image')) {
                // Hapus file lama jika ada
                if ($signature->image) {
                    Storage::delete("public/uploads/ttd/" . $signature->image);
                }

                $img_signature = $request->file('image');
                $folderPath = "public/uploads/ttd/";
                $img_signature->storeAs($folderPath, $img_signature->getClientOriginalName());
                $ttd = $img_signature->getClientOriginalName(); // Update file baru
            }

            // Update data di database
            $signature->update([
                'name' => $request->name,
                'position' => $request->position,
                'image' => $ttd,
            ]);

            return redirect()->route('signatures.index')->with('success', 'TTD berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('signatures.index')->with('error', 'Terjadi kesalahan saat memperbarui TTD: ' . $e->getMessage());
        }
    }


    // Hapus TTD
    public function destroy(Signature $signature)
    {
        if ($signature->image) {
            Storage::delete("public/uploads/ttd/" . $signature->image);
        }
        // if ($signature->image) {
        //     Storage::delete($signature->image);
        // }
        $signature->delete();

        return redirect()->route('signatures.index')->with('success', 'TTD berhasil dihapus.');
    }
}
