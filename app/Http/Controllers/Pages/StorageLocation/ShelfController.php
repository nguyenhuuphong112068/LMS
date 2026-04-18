<?php

namespace App\Http\Controllers\Pages\StorageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShelfController extends Controller
{
    public function index()
    {
        $datas = DB::table('shelves')
            ->where('shelves.department_id', session('user')['selected_department_id'])
            ->leftJoin('deparments', 'shelves.department_id', '=', 'deparments.id')
            ->leftJoin('warehouses', 'shelves.warehouse_id', '=', 'warehouses.id')
            ->leftJoin('rooms', 'shelves.room_id', '=', 'rooms.id')
            ->select('shelves.*', 'deparments.name as department_name', 'warehouses.name as warehouse_name', 'rooms.name as room_name')
            ->orderBy('shelves.name', 'asc')
            ->get();

        $departments = DB::table('deparments')->where('active', true)->get();
        $warehouses = DB::table('warehouses')->where('department_id', session('user')['department_id'])->where('active', true)->get();
        $rooms = DB::table('rooms')->where('department_id', session('user')['department_id'])->where('active', true)->get();

        session()->put(['title' => 'VỊ TRÍ LƯU TRỮ - KỆ']);
        return view('pages.StorageLocation.Shelf.list', [
            'datas' => $datas,
            'departments' => $departments,
            'warehouses' => $warehouses,
            'rooms' => $rooms
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:shelves,code',
            'name' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'createErrors')->withInput();
        }

        DB::table('shelves')->insert([
            'code' => $request->code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'warehouse_id' => $request->warehouse_id,
            'room_id' => $request->room_id,
            'status_id' => 1,
            'created_by' => session('user')['fullName'],
            'created_at' => now(),

        ]);
        return redirect()->back()->with('success', 'Đã thêm kệ thành công!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:shelves,code,' . $request->id,
            'name' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateErrors')->withInput();
        }

        DB::table('shelves')->where('id', $request->id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'warehouse_id' => $request->warehouse_id,
            'room_id' => $request->room_id,
            'updated_at' => now(),
            'updated_by' => session('user')['fullName']
        ]);

        return redirect()->back()->with('success', 'Cập nhật kệ thành công!');
    }

    public function deActive(Request $request)
    {
        $id = $request->id;
        $status_id = $request->status_id;

        DB::table('shelves')->where('id', $id)->update([
            'status_id' => ($status_id == 1 ? 0 : 1),
            'updated_at' => now(),
            'updated_by' => session('user')['fullName']
        ]);

        return redirect()->back()->with('success', 'Đã thay đổi trạng thái thành công!');
    }
}
