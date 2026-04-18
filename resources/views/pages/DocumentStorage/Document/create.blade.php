<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModalLabel">Thêm Tài Liệu Mới</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pages.documentStorage.document.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bộ Phận/Phòng Ban <span class="text-danger">*</span></label>
                        <input type="hidden" name="department_id" value="{{ session('user')['department_id'] }}">
                        <select class="form-control" disabled>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}" {{ session('user')['department_id'] == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mã Tài liệu <span class="text-danger">*</span></label>
                        <input type="text" name="code" class="form-control" required placeholder="Nhập mã tài liệu">
                        @if($errors->createErrors->has('code'))
                            <span class="text-danger small">{{ $errors->createErrors->first('code') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Tên Tài liệu <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Nhập tên tài liệu">
                    </div>

                    <div class="form-group">
                        <label>Loại Tài liệu</label>
                        <select name="document_types_id[]" class="form-control select2" multiple="multiple" data-placeholder="Chọn loại tài liệu" style="width: 100%;">
                            @foreach ($document_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Người sở hữu / Chịu trách nhiệm</label>
                        <input type="text" name="owner" class="form-control" value="{{ session('user')['fullName'] }}" placeholder="Tên người sở hữu">
                    </div>

                    <div class="form-group">
                        <label>Đường dẫn File hoặc Đính kèm</label>
                        <div class="input-group">
                            <input type="text" name="filepath" id="create_filepath" class="form-control" placeholder="URL hoặc chọn file đính kèm...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info" onclick="document.getElementById('create_file_attachment').click()">
                                    <i class="fas fa-paperclip"></i> Đính kèm
                                </button>
                                <input type="file" name="file_attachment" id="create_file_attachment" style="display: none;">
                            </div>
                        </div>
                        <small class="text-muted" id="file_name_display"></small>
                    </div>

                    <div class="form-group">
                        <label>Vị trí lưu trữ <span class="text-danger">*</span></label>
                        <select name="location_id" class="form-control" required>
                            <option value="">-- Chọn Vị trí --</option>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }} ({{ $loc->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày hết hạn (Nếu có)</label>
                                <input type="date" name="expired_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="checkbox" name="is_private" class="custom-control-input" id="is_private_switch">
                                <label class="custom-control-label font-weight-bold" for="is_private_switch">Tài liệu nội bộ (Riêng tư)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu tài liệu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('create_file_attachment');
        const filepathInput = document.getElementById('create_filepath');
        const fileNameDisplay = document.getElementById('file_name_display');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const fileName = this.files[0].name;
                    fileNameDisplay.textContent = 'Đã chọn: ' + fileName;
                    fileNameDisplay.classList.remove('text-muted');
                    fileNameDisplay.classList.add('text-success', 'font-weight-bold');
                    
                    // Auto fill filepath if it's empty or looks like a filename
                    filepathInput.value = fileName;
                } else {
                    fileNameDisplay.textContent = '';
                }
            });
        }
    });
</script>
