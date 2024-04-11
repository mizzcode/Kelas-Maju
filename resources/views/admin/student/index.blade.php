@extends('layouts.main')

@section('title', "Student | KelasMaju")

@section('content-header')
<h1>Siswa</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="{{route("dashboard")}}">Dashboard</a></div>
    <div class="breadcrumb-item">Siswa</div>
</div>
@endsection

@section('content-body') 
    <div class="col-md-6 col-lg-12">
        <div class="card">
        <div class="card-header">
            <h4>Seluruh Data Siswa</h4>
        </div>
        <div class="card-body p-0">
            <p class="px-4">Berikut adalah daftar seluruh siswa.</p>
            {{-- id add akan di tangkap jqeury untuk membuat modal
                cek di bootstrap-modal.js --}}
            <div class="m-3 d-flex align-items-center justify-content-end">
                <button class="btn btn-success" data-toggle="modal" data-target="#add">Add Student</button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-md">
                <tr>
                <th>#</th>
                <th>NAME</th>
                <th>NIS</th>
                <th>JURUSAN</th>
                <th>STATUS</th>
                <th>ACTION</th>
                </tr>
                @foreach ($students as $student)
                <tr>
                    <td>{{ ($students->currentpage() - 1) * $students->perpage() + $loop->index + 1 }}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->nis}}</td>
                    <td>{{$student->jurusan}}</td>
                    @if ($student->user->status == "Active")
                    <td><div class="badge badge-success">Active</div></td>
                    @else
                    <td><div class="badge badge-danger">Not Active</div></td>
                    @endif
                    <td>
                        <a href="{{ route('student.destroy', $student->id) }}" class="btn btn-danger" 
                            data-confirm-delete="true">Delete</a>
                        <button class="btn btn-info" 
                            data-id="{{$student->id}}"
                            data-email="{{$student->user->name}}"
                            data-name="{{$student->name}}" 
                            data-nis="{{$student->nis}}" 
                            data-jurusan="{{$student->jurusan}}" 
                            data-status="{{$student->user->status}}" 
                            data-user_id="{{$student->user->id}}" 
                            data-created_at="{{$student->created_at}}" 
                            data-updated_at="{{$student->updated_at}}" 
                            data-toggle="modal" 
                            data-target="#detailModel">Detail
                        </button>
                    </td>
                    </tr>
                @endforeach
            </table>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center">
            {{$students->links()}}
        </div>
        </div>
    </div>
@endsection

@section("modal")
    {{-- modal create student --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="add">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create a New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route("student.store")}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="user">USER</label>
                                        <select class="form-control" name="user_id">
                                            <option readonly>PILIH STUDENT</option>
                                            @foreach ($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">EMAIL</label>
                                        <input type="email" class="form-control @error("email") is-invalid @enderror" name="email" value="{{old("email")}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">NAME</label>
                                        <input type="text" class="form-control @error("name") is-invalid @enderror" name="name" value="{{old("name")}}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nis">NIS</label>
                                        <input type="number" class="form-control @error("nis") is-invalid @enderror" name="nis" value="{{old("nis")}}">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="jurusan">JURUSAN</label>
                                        <select class="form-control" name="jurusan">
                                            <option value="Pendidikan Agama">Pendidikan Agama</option>
                                            <option value="IPA">IPA</option>
                                            <option value="IPS">IPS</option>
                                            <option value="Bahasa Inggris">Bahasa Inggris</option>
                                            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                            <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                                            <option value="Pertanian">Pertanian</option>
                                            <option value="Tata Boga">Tata Boga</option>
                                            <option value="Desain Grafis">Desain Grafis</option>
                                            <option value="Akuntansi">Akuntansi</option>
                                            <option value="Keperawatan">Keperawatan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal detail student--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="detailModel">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Siswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            {{-- form untuk update --}}
            {{-- param ke 2 dari route itu cuma data fake agar method update di controller tidak eror, 
                karena kita kirim id nya dari input hidden id dan value id ini di ambil lewat javascript--}}
            <form action="{{route("student.update", "fake")}}" method="POST">
            @csrf
            @method("PUT")
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="id">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                <label for="email">EMAIL</label>
                                <input type="text" class="form-control @error("email") is-invalid @enderror" name="email" id="email">
                                </div>
                            </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                            <label for="name">NAME</label>
                            <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nis">NIS</label>
                                <input type="number" class="form-control" id="nis" name="nis">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="jurusan">JURUSAN</label>
                                <select class="form-control" name="jurusan">
                                    <option value="Pendidikan Agama">Pendidikan Agama</option>
                                    <option value="IPA">IPA</option>
                                    <option value="IPS">IPS</option>
                                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                                    <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                                    <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                                    <option value="Pertanian">Pertanian</option>
                                    <option value="Tata Boga">Tata Boga</option>
                                    <option value="Desain Grafis">Desain Grafis</option>
                                    <option value="Akuntansi">Akuntansi</option>
                                    <option value="Keperawatan">Keperawatan</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="user">USER</label>
                                <select class="form-control" name="user_id">
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="created_at">DI BUAT</label>
                            <input type="datetime-local" class="form-control" id="created_at" name="created_at" readonly>
                        </div>
                        <div class="form-group">
                            <label for="updated_at">DI UPDATE</label>
                            <input type="datetime-local" class="form-control" id="updated_at" name="updated_at" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection

{{-- jQuery untuk ambil data siswa dan mengirim ke class modal-body --}}
@section("js")
<script src="{{asset("assets/js/page/bootstrap-modal.js")}}"></script>
@endsection