@extends('errors::minimal')

@section('title', __('Akses Ditolak'))
@section('code', '403')

{{-- VVV GANTI DENGAN PESAN BARU INI VVV --}}
@section('message', __('AKSES DITOLAK. Anda tidak memiliki hak akses untuk membuka halaman ini.'))