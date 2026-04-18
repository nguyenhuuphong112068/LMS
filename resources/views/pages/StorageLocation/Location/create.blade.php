<div class="modal fade" id="createModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Vị trí Mới</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('pages.storageLocation.location.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="department_id" class="form-control"
                            value="{{ session('user')['department_id'] }}">
                        <label>Bộ Phận/Phòng Ban <span class="text-danger">*</span></label>
                        <select name="department_id" class="form-control" disabled>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}"
                                    {{ isset(session('user')['department_id']) && session('user')['department_id'] == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thuộc Kho</label>
                        <select name="warehouse_id" class="form-control">
                            <option value="">-- Không chọn --</option>
                            @foreach ($warehouses as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thuộc Phòng</label>
                        <select name="room_id" class="form-control">
                            <option value="">-- Không chọn --</option>
                            @foreach ($rooms as $rm)
                                <option value="{{ $rm->id }}">{{ $rm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Thuộc Kệ (Shelf)</label>
                        <select name="shelf_id" class="form-control">
                            <option value="">-- Không chọn --</option>
                            @foreach ($shelves as $sh)
                                <option value="{{ $sh->id }}">{{ $sh->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mã Vị trí <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tên Vị trí <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
