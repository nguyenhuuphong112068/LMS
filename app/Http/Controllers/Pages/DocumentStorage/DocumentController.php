<?php

namespace App\Http\Controllers\Pages\DocumentStorage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    public function index()
    {
        $datas = DB::table('documents')
            ->where('documents.department_id', session('user')['selected_department_id'])
            ->leftJoin('deparments', 'documents.department_id', '=', 'deparments.id')
            ->leftJoin('locations', 'documents.location_id', '=', 'locations.id')
            ->leftJoin('warehouses', 'locations.warehouse_id', '=', 'warehouses.id')
            ->leftJoin('rooms', 'locations.room_id', '=', 'rooms.id')
            ->leftJoin('shelves', 'locations.shelf_id', '=', 'shelves.id')
            ->select(
                'documents.*', 
                'deparments.name as department_name', 
                'locations.name as location_name',
                'warehouses.name as warehouse_name',
                'rooms.name as room_name',
                'shelves.name as shelf_name'
            )
            ->orderBy('documents.name', 'asc')
            ->get();

        // Get document types from pivot table for each document
        $docIds = $datas->pluck('id');
        $typesMap = DB::table('document_has_types')
            ->whereIn('document_id', $docIds)
            ->get()
            ->groupBy('document_id');

        foreach ($datas as $data) {
            $data->document_types_id = isset($typesMap[$data->id])
                ? $typesMap[$data->id]->pluck('document_type_id')->toJson()
                : json_encode([]);
        }

        $departments = DB::table('deparments')->where('active', true)->get();
        $document_types = DB::table('document_types')->get();
        
        // Fetch storage hierarchy for filters
        $warehouses = DB::table('warehouses')->where('active', true)->get();
        $rooms = DB::table('rooms')->where('active', true)->get();
        $shelves = DB::table('shelves')->where('active', true)->get();
        $locations = DB::table('locations')
            ->where('department_id', session('user')['department_id'])
            ->where('status_id', 1)
            ->get();

        session()->put(['title' => 'QUẢN LÝ TÀI LIỆU']);
        return view('pages.DocumentStorage.Document.list', [
            'datas' => $datas,
            'departments' => $departments,
            'document_types' => $document_types,
            'warehouses' => $warehouses,
            'rooms' => $rooms,
            'shelves' => $shelves,
            'locations' => $locations
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:documents,code',
            'name' => 'required',
            'location_id' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'createErrors')->withInput();
        }

        $filepath = $request->filepath;
        if ($request->hasFile('file_attachment')) {
            $file = $request->file('file_attachment');
            $folderPath = 'uploads/documents/' . date('Y/m');
            $destinationPath = public_path($folderPath);

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $filepath = $folderPath . '/' . $fileName;
        }

        $docId = DB::table('documents')->insertGetId([
            'code' => $request->code,
            'name' => $request->name,
            'owner' => $request->owner ?? session('user')['fullName'],
            'filepath' => $filepath,
            'location_id' => $request->location_id,
            'department_id' => $request->department_id,
            'expired_date' => $request->expired_date,
            'is_private' => $request->has('is_private'),
            'status_id' => 1, // Default Active
            'created_by' => session('user')['fullName'],
            'created_at' => now(),
        ]);

        if ($request->document_types_id) {
            $typesData = [];
            foreach ($request->document_types_id as $typeId) {
                $typesData[] = [
                    'document_id' => $docId,
                    'document_type_id' => $typeId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            DB::table('document_has_types')->insert($typesData);
        }

        return redirect()->back()->with('success', 'Đã thêm tài liệu thành công!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:documents,code,' . $request->id,
            'name' => 'required',
            'location_id' => 'required',
            'department_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator, 'updateErrors')->withInput();
        }

        $filepath = $request->filepath;
        if ($request->hasFile('file_attachment')) {
            $file = $request->file('file_attachment');
            $folderPath = 'uploads/documents/' . date('Y/m');
            $destinationPath = public_path($folderPath);

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
            $filepath = $folderPath . '/' . $fileName;
        }

        DB::table('documents')->where('id', $request->id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'owner' => $request->owner,
            'filepath' => $filepath,
            'location_id' => $request->location_id,
            'department_id' => $request->department_id,
            'expired_date' => $request->expired_date,
            'is_private' => $request->has('is_private'),
            'updated_by' => session('user')['fullName'],
            'updated_at' => now(),
        ]);

        // Sync document types
        DB::table('document_has_types')->where('document_id', $request->id)->delete();
        if ($request->document_types_id) {
            $typesData = [];
            foreach ($request->document_types_id as $typeId) {
                $typesData[] = [
                    'document_id' => $request->id,
                    'document_type_id' => $typeId,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            DB::table('document_has_types')->insert($typesData);
        }

        return redirect()->back()->with('success', 'Cập nhật tài liệu thành công!');
    }

    public function deActive(Request $request)
    {
        $id = $request->id;
        $status_id = $request->status_id;

        DB::table('documents')->where('id', $id)->update([
            'status_id' => ($status_id == 1 ? 0 : 1),
            'updated_by' => session('user')['fullName'],
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Đã thay đổi trạng thái thành công!');
    }
}
