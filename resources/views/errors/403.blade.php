@extends('errors.layout')

@section('title', 'Tidak Memiliki Hak Akses')
@section('code', '403')
@section('message.title', 'Anda tidak memiliki hak akses!')
@section('message.color', 'danger')
@section('message.body', 'Sepertinya Anda mencoba mengakses sesuatu yang diluar otoritas Anda. Maka dari itu Anda bisa kembali ke halaman dashboard dengan menekan tombol dibawah ini.')
