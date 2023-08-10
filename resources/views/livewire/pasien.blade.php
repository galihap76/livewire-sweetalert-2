{{-- Root element --}}
<div>

    {{-- Title --}}
    @section('title', 'Livewire SweetAlert 2')


    <!-- Modal tambah-->
    <div wire:ignore.self class="modal fade" id="tambahPasien" tabindex="-1" aria-labelledby="tambahPasien"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahPasien">Tambah Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="close()"></button>
                </div>

                <div class="modal-body">

                    <!-- Form tambah pasien -->
                    <form wire:submit.prevent='storeData'>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pasien</label>
                            <input wire:model.defer="nama" type="text" class="form-control" id="nama" name="nama"
                                maxlength="50" autocomplete='off' required />
                        </div>

                        <div class="mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input wire:model.defer="umur" type="number" class="form-control" id="umur" name="umur"
                                autocomplete='off' required />
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input wire:model.defer="alamat" type="text" class="form-control" id="alamat" name="alamat"
                                autocomplete='off' required />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                wire:click="close()">Tutup</button>
                            <button type="submit" class="btn btn-success">Tambah</button>
                        </div>
                    </form>
                    <!-- Akhir form tambah pasien-->

                </div>
            </div>
        </div>
    </div>
    <!-- </Akhir modal tambah -->

    <!-- Modal edit-->
    <div wire:ignore.self class="modal fade" id="editPasien" tabindex="-1" aria-labelledby="editPasien"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editPasien">Edit Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="close()"></button>
                </div>

                <div class="modal-body">

                    <!-- Form edit pasien -->
                    <form wire:submit.prevent='editData'>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pasien</label>
                            <input wire:model.defer="nama" type="text" class="form-control" id="nama" name="nama"
                                maxlength="50" autocomplete='off' required />
                        </div>

                        <div class="mb-3">
                            <label for="umur" class="form-label">Umur</label>
                            <input wire:model.defer="umur" type="number" class="form-control" id="umur" name="umur"
                                autocomplete='off' required />
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input wire:model.defer="alamat" type="text" class="form-control" id="alamat" name="alamat"
                                autocomplete='off' required />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                                wire:click="close()">Tutup</button>
                            <button type="submit" class="btn btn-warning">Edit</button>
                        </div>
                    </form>
                    <!-- Akhir form edit pasien-->

                </div>
            </div>
        </div>
    </div>
    <!-- </Akhir modal edit -->


    <!-- Content tabel pasien -->
    <div class="container mb-4">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p><i class="bi bi-table me-1"></i> Datatable Pasien</p>

                        <div class="mt-4">
                            <input type="search" wire:model.debounce.300ms="search" class="form-control float-end mx-2"
                                placeholder="Search..." style="width: 230px" />
                            <button type="button" class="btn btn-success float-start" data-bs-toggle="modal"
                                wire:click="close()" data-bs-target="#tambahPasien">
                                Tambah Pasien
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Umur</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="table-group-divider">
                                @php
                                $no = 1;
                                @endphp

                                @forelse ($pasien as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->umur }}</td>
                                    <td>{{ $data->alamat }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-danger mb-1 mr-1 me-2 mt-3"
                                                wire:click="initDeleteData({{$data->id}})"><i
                                                    class="bi bi-trash"></i></button>

                                            <button type="button" class="btn btn-warning text-white mb-1 mt-3"
                                                data-bs-toggle="modal" data-bs-target="#editPasien"
                                                wire:click="initEditData({{$data->id}})"><i
                                                    class="bi bi-pencil"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">Data Tidak Di Temukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div>
                            {{ $pasien->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </Akhir content tabel pasien -->

    {{-- Session store --}}
    @if (session()->has('store'))

    <script>
        window.addEventListener('swal:store', event => { 
          
            Swal.fire({
                title: event.detail.title,
                text: "{{ session('store') }}",
                icon: event.detail.icon
            });

            let myModalElTambah = document.getElementById('tambahPasien');
            let modalTambah = bootstrap.Modal.getInstance(myModalElTambah)
            modalTambah.hide();
           
        });
    </script>

    @elseif (session()->has('edit'))

    <script>
        window.addEventListener('swal:edit', event => { 
          
            Swal.fire({
                title: event.detail.title,
                text: "{{ session('edit') }}",
                icon: event.detail.icon
            });

            let myModalElEdit = document.getElementById('editPasien');
            let modalEdit = bootstrap.Modal.getInstance(myModalElEdit)
            modalEdit.hide();
           
        });
    </script>

    @endif

    <script>
        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail.title,
                text: event.detail.text,
                icon: event.detail.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then(result => {
                if (result.isConfirmed) {
                    Livewire.emit('deletePasien', event.detail.selectedPasienId);
                    Swal.fire(
                        'Berhasil',
                        'Data pasien berhasil di hapus.',
                        'success'
                    );
                }
            });
        });

    </script>
</div>
{{-- Akhir root element --}}