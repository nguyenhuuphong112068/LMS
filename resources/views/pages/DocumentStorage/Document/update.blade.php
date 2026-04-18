<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="updateModalLabel">Cập nhật Tài Liệu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pages.documentStorage.document.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="update_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bộ Phận/Phòng Ban <span class="text-danger">*</span></label>
                        <input type="hidden" name="department_id" id="update_dept_id">
                        <select class="form-control" id="update_dept_display" disabled>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Mã Tài liệu <span class="text-danger">*</span></label>
                        <input type="text" name="code" id="update_code" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tên Tài liệu <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="update_name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Loại Tài liệu</label>
                        <select name="document_types_id[]" id="update_document_types" class="form-control select2" multiple="multiple" data-placeholder="Chọn loại tài liệu" style="width: 100%;">
                            @foreach ($document_types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Người sở hữu / Chịu trách nhiệm</label>
                        <input type="text" name="owner" id="update_owner" class="form-control" placeholder="Tên người sở hữu">
                    </div>

                    <div class="form-group">
                        <label>Đường dẫn File hoặc Đính kèm mới</label>
                        <div class="input-group">
                            <input type="text" name="filepath" id="update_filepath" class="form-control" placeholder="URL hoặc chọn file đính kèm...">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-info" onclick="document.getElementById('update_file_attachment').click()">
                                    <i class="fas fa-paperclip"></i> Đính kèm
                                </button>
                                <input type="file" name="file_attachment" id="update_file_attachment" style="display: none;">
                            </div>
                        </div>
                        <small class="text-muted" id="update_file_name_display"></small>
                    </div>

                    <div class="form-group">
                        <label>Vị trí lưu trữ <span class="text-danger">*</span></label>
                        <select name="location_id" id="update_location" class="form-control" required>
                            @foreach ($locations as $loc)
                                <option value="{{ $loc->id }}">{{ $loc->name }} ({{ $loc->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ngày hết hạn</label>
                                <input type="date" name="expired_date" id="update_expired" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="checkbox" name="is_private" class="custom-control-input" id="update_is_private">
                                <label class="custom-control-label font-weight-bold" for="update_is_private">Tài liệu nội bộ (Riêng tư)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-warning">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('update_file_attachment');
        const filepathInput = document.getElementById('update_filepath');
        const fileNameDisplay = document.getElementById('update_file_name_display');
        
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files.length > 0) {
                    const fileName = this.files[0].name;
                    fileNameDisplay.textContent = 'Đã chọn: ' + fileName;
                    fileNameDisplay.classList.remove('text-muted');
                    fileNameDisplay.classList.add('text-success', 'font-weight-bold');
                    
                    // Auto fill filepath
                    filepathInput.value = fileName;
                } else {
                    fileNameDisplay.textContent = '';
                }
            });
        }
        
        // Reset file display when update modal is opened
        $(document).on('click', '.btn-edit', function() {
            if (fileNameDisplay) fileNameDisplay.textContent = '';
            if (fileInput) fileInput.value = '';
        });
    });
</script>
