<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    private function useValidator(Request $request, array $rules)
    {
        return Validator::make($request->all(), $rules);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->where("role_id", "=", '9bf5b9a4-edef-4bbd-a447-3d7c12545908')->get();
        $students = Student::query()->latest()->paginate(5);

        $title = "Hapus Siswa!";
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view("admin.student.index", [
            "users" => $users,
            "students" => $students,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = $this->useValidator($request, [
                "nis" => "required|max:50",
                "jurusan" => "required|max:50",
                "user_id" => "required"
            ]);

            $users = User::query()->where("role_id", "=", '9bf5b9a4-edef-4bbd-a447-3d7c12545908')->get();

            foreach ($users as $user) {
                if ($user->id === $request->user_id) {
                    return redirect()->back()->withInput()->with('errorCreateStudent', "Data siswa {$user->name} sudah ada");
                }
            }

            if ($validator->fails()) throw new Exception();
            // menerima input yang sudah tervalidasi
            $validated = $validator->validated();

            Student::query()->create($validated);

            return redirect()->route("student.index")->with("successCreateStudent", "Berhasil Menambahkan Siswa Baru");
        } catch (QueryException $e) {
            Log::info($e->getMessage());
            return redirect()->back()->withInput()->with('errorCreateStudent', 'Gagal Menambahkan Siswa Baru');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $student = Student::query()->findOrFail($request->student_id);

            $validator = $this->useValidator($request, [
                "email" => "required|email:dns",
                "name" => "required|max:50",
                "nis" => "required|max:50",
                "jurusan" => "required|max:50",
                "status" => "required",
                "user_id" => "required"
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with("errorUpdateStudent", "Gagal memperbarui data siswa");
            }

            // menerima input yang sudah tervalidasi
            $validated = $validator->validated();

            Student::query()->where('id', '=', $student->id)->update($validated);

            return redirect()->route("student.index")->with("successUpdateStudent", "Data Siswa Berhasil Di Update.");
        } catch (QueryException $e) {
            Log::info($e);
            return back()->with("errorUpdateStudent", "Gagal memperbarui data siswa");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Student::query()->where('id', '=', $id)->delete();

            return redirect()->route("student.index")->with("successDeleteStudent", "Data Siswa Berhasil Di Delete.");
        } catch (QueryException $e) {
            Log::info($e->getMessage());
            return back()->with("errorDeleteStudent", "Gagal menghapus data siswa");
        }
    }
}
