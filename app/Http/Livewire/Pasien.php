<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PasienModel;

class Pasien extends Component
{

    use WithPagination;

    // Public property id, nama, umur, alamat
    public $selectedPasienId, $nama, $umur, $alamat;

    // Listeners
    protected $listeners = ['deletePasien'];

    // Theme untuk bootstrap pagination
    protected $paginationTheme = 'bootstrap';

    // Init search livewire laravel
    public $search = '';

    public function render()
    {

        // Mengambil semua data pasien dan pencarian berdasarkan nama, umur, alamat
        $pasien = PasienModel::where(function ($query) {
            $query->orWhere('nama', 'like', '%' . $this->search . '%')
                ->orWhere('umur', 'like', '%' . $this->search . '%')
                ->orWhere('alamat', 'like', '%' . $this->search . '%');
        })->paginate(5);

        return view('livewire.pasien', ['pasien' => $pasien]);
    }

    // Method close() untuk membersihkan kolom inputan bidang nama, umur, alamat jika menekan tombol cancel atau silang
    public function close()
    {
        $this->nama = '';
        $this->umur = '';
        $this->alamat = '';
    }

    // Method storeData() digunakan untuk menyimpan data pasien baru ke dalam tabel
    public function storeData()
    {
        // Menyimpan data pasien ke dalam tabel
        $insertTable = PasienModel::create([
            'nama' => Str::lower($this->nama),
            'umur' => $this->umur,
            'alamat' => Str::lower($this->alamat)
        ]);

        // Jika penyimpanan berhasil
        if ($insertTable) {

            // Menampilkan flash message store
            session()->flash('store', 'Data pasien berhasil ditambahkan.');

            // Mengosongkan input nama, umur, alamat
            $this->nama = '';
            $this->umur = '';
            $this->alamat = '';

            // Tampilkan pesan dan menutup modal dengan menggunakan browser event
            $this->dispatchBrowserEvent('swal:store', [
                'title' => 'Berhasil',
                'icon' => 'success'
            ]);
        }
    }

    // Method initEditData() digunakan untuk menginisialisasi data yang akan diubah berdasarkan ID
    public function initEditData($selectedPasienId)
    {
        // Menginisialisasi data yang akan diubah berdasarkan ID
        $editPasien = PasienModel::where('id', $selectedPasienId)->first();

        // Menetapkan nilai pada property id, nama, umur, alamat untuk field form edit pasien
        $this->selectedPasienId = $editPasien->id;
        $this->nama = $editPasien->nama;
        $this->umur = $editPasien->umur;
        $this->alamat = $editPasien->alamat;
    }

    // Method editData() digunakan untuk mengubah data pasien
    public function editData()
    {

        // Mengambil data pasien yang akan diubah berdasarkan ID
        $editDataPasien = PasienModel::find($this->selectedPasienId);

        // Jika ID pasien ditemukan
        if ($editDataPasien) {

            // Mengubah nilai pada property nama, umur, dan alamat
            $editDataPasien->nama = Str::lower($this->nama);
            $editDataPasien->umur = $this->umur;
            $editDataPasien->alamat = Str::lower($this->alamat);

            // Jika perubahan berhasil disimpan
            if ($editDataPasien->save()) {

                // Menampilkan flash message edit
                session()->flash('edit', 'Data pasien berhasil di ubah.');

                // Mengosongkan input nama, umur, alamat
                $this->nama = '';
                $this->umur = '';
                $this->alamat = '';

                // Tampilkan pesan dan menutup modal dengan menggunakan browser event
                $this->dispatchBrowserEvent('swal:edit', [
                    'title' => 'Berhasil',
                    'icon' => 'success'
                ]);
            }
        }
    }

    // Method initDeleteData() digunakan untuk menginisialisasi data yang akan dihapus berdasarkan ID
    public function initDeleteData($selectedPasienId)
    {

        // Konfirmasi jika ingin di hapus berdasarkan ID
        $this->dispatchBrowserEvent('swal:confirm', [
            'title' => 'Apakah Anda yakin?',
            'text' => 'Data tidak bisa di kembalikan.',
            'icon' => 'warning',
            'selectedPasienId' => $selectedPasienId
        ]);
    }

    // Method deletePasien() digunakan untuk menghapus data pasien berdasarkan ID
    public function deletePasien($selectedPasienId)
    {
        // Data pasien yang akan dihapus berdasarkan ID
        PasienModel::where('id', $selectedPasienId)->delete();
    }
}
