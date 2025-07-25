@extends('layouts.petugas_layout')
@section('content')
    <div class="p-4">
        <div class="d-flex flex-row justify-content-between mb-4 px-2">
            <h1>Ubah Perawatan</h1>
            <a href="{{ route('petugas.perawatan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
        <div class="d-flex flex-column">
            <form method="POST" action="{{ route('petugas.perawatan.update', $perawatan->id) }}">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="form-group col-6">
                        <label for="id_petugas">Nama Petugas</label>
                        <select name="id_petugas" class="form-control" required>
                            @foreach ($petugas as $p)
                                <option value="{{ $p->id }}" <?php $p->id == $perawatan->id_petugas ? "{{selected}}" : null ?> >{{ $p->nama_petugas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label for="id_hewan">Nama Hewan</label>
                        <select name="id_hewan" class="form-control" required>
                            @foreach ($hewans as $hewan)
                                <option value="{{ $hewan->id }}" <?php $hewan->id == $perawatan->id_petugas ? "{{selected}}" : null ?>>{{ $hewan->nama_hewan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-6">
                        <label for="jenis_perawatan">Jenis Perawatan</label>
                        <input type="text" class="form-control" name="jenis_perawatan" id="jenis_perawatan" value="{{$perawatan->jenis_perawatan}}"
                            placeholder="Jenis Perawatan" required>
                    </div>
                    <div class="form-group col-6">
                        <label for="jadwal_perawatan">Jadwal Perawatan</label>
                        <input type="datetime-local" class="form-control" name="jadwal_perawatan" id="jadwal_perawatan" value="{{$perawatan->jadwal_perawatan}}"
                            placeholder="Jadwal Perawatan" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning">Edit</button>
            </form>
        </div>
    </div>
@endsection

