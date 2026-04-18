<?php

namespace App\Http\Controllers\Pages\StorageLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
{
    public function index()
    {
        $datas = DB::table('locations')
            ->where('locations.department_id', session('user')['selected_department_id'])
            ->leftJoin('deparments', 'locations.department_id', '=', 'deparments.id')
            ->leftJoin('warehouses', 'locations.warehouse_id', '=', 'warehouses.id')
            ->leftJoin('rooms', 'locations.room_id', '=', 'rooms.id')
            ->leftJoin('shelves', 'locations.shelf_id', '=', 'shelves.id')
            ->select('locations.*', 'deparments.name as department_name', 'warehouses.name as warehouse_name', 'rooms.name as room_name', 'shelves.name as shelf_name')
            ->orderBy('locations.name', 'asc')
            ->get();

        $departments = DB::table('deparments')->where('active', true)->get();
        $warehouses = DB::table('warehouses')->where('department_id', session('user')['department_id'])->where('active', true)->get();
        $rooms = DB::table('rooms')->where('department_id', session('user')['department_id'])->where('active', true)->get();
        $shelves = DB::table('shelves')->where('department_id', session('user')['department_id'])->where('active', true)->get();

        session()->put(['title' => 'VỊ TRÍ LƯU TRỮ - VỊ TRÍ']);
        return view('pages.StorageLocation.Location.list', [
            'datas' => $datas,
            'departments' => $departments,
            'warehouses' => $warehouses,
            'rooms' => $rooms,
            'shelves' => $shelves
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:locations,code',
            'name' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'createErrors')->withInput();
        }

        DB::table('locations')->insert([
            'code' => $request->code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'warehouse_id' => $request->warehouse_id,
            'room_id' => $request->room_id,
            'shelf_id' => $request->shelf_id,
            'status_id' => 1,
            'created_by' => session('user')['fullName'],
            'created_at' => now()

        ]);
        return redirect()->back()->with('success', 'Đã thêm vị trí thành công!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:locations,code,' . $request->id,
            'name' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateErrors')->withInput();
        }

        DB::table('locations')->where('id', $request->id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'warehouse_id' => $request->warehouse_id,
            'room_id' => $request->room_id,
            'shelf_id' => $request->shelf_id,
            'updated_at' => now(),
            'updated_by' => session('user')['fullName'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật vị trí thành công!');
    }

    public function deActive(Request $request)
    {
        $id = $request->id;
        $status_id = $request->status_id;

        DB::table('locations')->where('id', $id)->update([
            'status_id' => ($status_id == 1 ? 0 : 1),
            'updated_at' => now(),
            'updated_by' => session('user')['fullName']
        ]);

        return redirect()->back()->with('success', 'Đã thay đổi trạng thái thành công!');
    }
}
