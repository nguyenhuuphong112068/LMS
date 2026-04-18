<?php

namespace App\Http\Controllers\Pages\MaterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DocumentTypeController extends Controller
{
    public function index()
    {
        $datas = DB::table('document_types')->orderBy('name', 'asc')->get();
        session()->put(['title' => 'DỮ LIỆU GỐC - LOẠI TÀI LIỆU']);
        return view('pages.materData.DocumentType.list', ['datas' => $datas]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:document_types,name',
        ], [
            'name.required' => 'Vui lòng nhập Tên Loại Tài Liệu',
            'name.unique' => 'Tên Loại Tài Liệu đã tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'createErrors')->withInput();
        }

        DB::table('document_types')->insert([
            'name' => $request->name,
            'active' => true,
            'prepareBy' => session('user')['fullName'] ?? 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->back()->with('success', 'Đã thêm thành công!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:document_types,name,' . $request->id,
        ], [
            'name.required' => 'Vui lòng nhập Tên Loại Tài Liệu',
            'name.unique' => 'Tên Loại Tài Liệu đã tồn tại.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateErrors')->withInput();
        }

        DB::table('document_types')->where('id', $request->id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Cập nhật thành công!');
    }

    public function deActive(Request $request)
    {
        $id = $request->id;
        $active = $request->active;

        DB::table('document_types')->where('id', $id)->update([
            'active' => !$active,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Đã thay đổi trạng thái thành công!');
    }
}
