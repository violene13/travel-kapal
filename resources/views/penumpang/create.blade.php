@extends('layouts.app') 
@section('title', 'Tambah Penumpang') 
@section('content') 
<div class="container"> 
    <h1 class="mb-4 text-purple">Tambah Penumpang</h1> 
    <div class="card shadow-sm p-4"> 
        <form action="{{ route('penumpang.store') }}" method="POST"> 
            @csrf 
            <div class="row"> 
                
            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-end gap-2 mt-4"> 
                <a href="{{ route('penumpang.index') }}" class="btn btn-secondary px-4">Kembali</a> 
                <button type="submit" class="btn btn-success px-4">💾 Simpan</button> 
            </div> 
        </form> 
    </div> 
</div> 
@endsection
