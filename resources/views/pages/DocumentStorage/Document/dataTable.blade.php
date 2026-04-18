<style>
    /* Card Grid Styles */
    .document-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .document-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 4px solid #3b82f6;
        /* Blue for Document */
        position: relative;
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .document-card .icon {
        font-size: 2.5rem;
        color: #3b82f6;
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .document-card .code {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .document-card .name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 5px 0 10px;
    }

    .document-card .info-row {
        font-size: 0.85rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 3px;
    }

    .document-card .status {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .document-card .actions {
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .view-toggle {
        display: flex;
        background: #f1f5f9;
        padding: 5px;
        border-radius: 8px;
        gap: 5px;
    }

    .view-toggle button {
        border: none;
        background: transparent;
        padding: 5px 10px;
        border-radius: 6px;
        color: #64748b;
        transition: all 0.3s;
    }

    .view-toggle button.active {
        background: white;
        color: #3b82f6;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }

    /* Search Section Styles */
    .search-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        margin-bottom: 25px;
        border-left: 5px solid #3b82f6;
    }

    .search-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="content-wrapper">
    <div class="search-section mt-4 mx-3">
        <div class="search-title">
            <i class="fas fa-search text-primary"></i> TÌM KIẾM TÀI LIỆU NHANH
        </div>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Từ khóa (Tên, Mã, QR Code)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            {{-- <span class="input-group-text bg-light border-right-0"><i class="fas fa-qrcode"></i></span> --}}
                            <button class="btn btn-primary" id="btn-scan-qr" type="button" title="Quét mã bằng Camera">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <input type="text" id="quick-search-input" class="form-control"
                            placeholder="Nhập tên hoặc quét mã QR...">
                        <div class="input-group-append">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Loại tài liệu</label>
                    <select id="filter-type" class="form-control select2">
                        <option value="">-- Tất cả loại --</option>
                        @foreach ($document_types as $type)
                            <option value="{{ $type->name }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-secondary w-100" id="btn-reset-filter"
                    style="height: 38px;">
                    <i class="fas fa-sync-alt"></i> Reset
                </button>
            </div>
        </div>
        <div class="row g-3 mt-2 pt-2 border-top">
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Kho</label>
                    <select id="filter-warehouse" class="form-control select2">
                        <option value="">-- Tất cả kho --</option>
                        @foreach ($warehouses as $w)
                            <option value="{{ $w->name }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Phòng</label>
                    <select id="filter-room" class="form-control select2">
                        <option value="">-- Tất cả phòng --</option>
                        @foreach ($rooms as $r)
                            <option value="{{ $r->name }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Kệ</label>
                    <select id="filter-shelf" class="form-control select2">
                        <option value="">-- Tất cả kệ --</option>
                        @foreach ($shelves as $s)
                            <option value="{{ $s->name }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-0">
                    <label class="small font-weight-bold text-muted">Vị trí chi tiết</label>
                    <select id="filter-location" class="form-control select2">
                        <option value="">-- Tất cả vị trí --</option>
                        @foreach ($locations as $loc)
                            <option value="{{ $loc->name }}">{{ $loc->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-none bg-transparent mx-3">
        <div class="card-body p-0">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#createModal"
                    style="width: 170px; border-radius: 8px; font-weight: 600;">
                    <i class="fas fa-plus-circle"></i> THÊM TÀI LIỆU
                </button>


                <div class="view-toggle">
                    <button type="button" id="btn-grid-view" class="active" title="Xem dạng lưới">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button type="button" id="btn-table-view" title="Xem dạng bảng">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Grid View -->
            <div id="document-grid-view" class="document-grid">
                @foreach ($datas as $data)
                    <div class="document-card">
                        <div class="status">
                            @if ($data->status_id == 1)
                                <span class="badge badge-success">Sử dụng</span>
                            @else
                                <span class="badge badge-danger">Ngưng</span>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <div class="code">{{ $data->code }}</div>
                        <div class="qr-code-small" id="qr-grid-{{ $data->id }}" data-code="{{ $data->code }}"
                            style="position: absolute; top: 15px; right: 80px; background: white; padding: 2px; border: 1px solid #eee; border-radius: 4px; cursor: pointer;"
                            onclick="printQRCode('{{ $data->code }}', '{{ $data->name }}', 'qr-grid-{{ $data->id }}')"
                            title="Click để in mã QR"></div>
                        <div class="name">{{ $data->name }}</div>
                        <div class="info-row">
                            <i class="fas fa-building text-info"></i>
                            Bộ phận: {{ $data->department_name }}
                        </div>
                        <div class="info-row">
                            <i class="fas fa-user-tie text-secondary"></i>
                            Sở hữu: {{ $data->owner ?? 'N/A' }}
                        </div>
                        <div class="info-row">
                            <i class="fas fa-tags text-primary"></i>
                            @php
                                $typeIds = json_decode($data->document_types_id) ?? [];
                                $typeNames = $document_types->whereIn('id', $typeIds)->pluck('name')->toArray();
                            @endphp
                            Loại: {{ !empty($typeNames) ? implode(', ', $typeNames) : 'N/A' }}
                        </div>
                        <div class="info-row">
                            <i class="fas fa-map-marker-alt text-danger"></i>
                            Vị trí: {{ $data->location_name ?? 'N/A' }}
                        </div>
                        @if ($data->filepath)
                            <div class="info-row">
                                <i class="fas fa-link text-primary"></i>
                                <a href="{{ strpos($data->filepath, 'http') === 0 ? $data->filepath : asset($data->filepath) }}"
                                    target="_blank" class="text-primary truncate" style="max-width: 200px">File đính
                                    kèm</a>
                            </div>
                        @endif
                        @if ($data->expired_date)
                            <div class="info-row">
                                <i class="fas fa-calendar-times text-warning"></i>
                                Hết hạn: {{ \Carbon\Carbon::parse($data->expired_date)->format('d/m/Y') }}
                            </div>
                        @endif
                        @if ($data->is_private)
                            <div class="info-row mt-2">
                                <span class="badge badge-pill badge-dark"><i class="fas fa-eye-slash"></i> Riêng
                                    tư</span>
                            </div>
                        @endif
                        <div class="actions">
                            <button type="button" class="btn btn-sm btn-info btn-view-details"
                                data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                data-name="{{ $data->name }}" data-owner="{{ $data->owner }}"
                                data-filepath="{{ $data->filepath }}" data-dept="{{ $data->department_name }}"
                                data-location="{{ $data->location_name }}"
                                data-warehouse="{{ $data->warehouse_name ?? 'N/A' }}"
                                data-room="{{ $data->room_name ?? 'N/A' }}"
                                data-shelf="{{ $data->shelf_name ?? 'N/A' }}"
                                data-expired="{{ $data->expired_date ? \Carbon\Carbon::parse($data->expired_date)->format('d/m/Y') : 'N/A' }}"
                                data-private="{{ $data->is_private }}"
                                data-types="{{ !empty($typeNames) ? implode(', ', $typeNames) : 'N/A' }}"
                                data-status="{{ $data->status_id == 1 ? 'Sử dụng' : 'Ngưng' }}" title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if ($data->filepath)
                                <a href="{{ strpos($data->filepath, 'http') === 0 ? $data->filepath : asset($data->filepath) }}"
                                    target="_blank" class="btn btn-sm btn-primary" title="Xem File đính kèm">
                                    <i class="fas fa-file-download"></i>
                                </a>
                            @endif
                            <button type="button" class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                data-name="{{ $data->name }}" data-owner="{{ $data->owner }}"
                                data-filepath="{{ $data->filepath }}" data-dept="{{ $data->department_id }}"
                                data-location="{{ $data->location_id }}" data-expired="{{ $data->expired_date }}"
                                data-private="{{ $data->is_private }}" data-types="{{ $data->document_types_id }}"
                                data-toggle="modal" data-target="#updateModal" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form class="d-inline" action="{{ route('pages.documentStorage.document.deActive') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="status_id" value="{{ $data->status_id }}">
                                <button type="submit"
                                    class="btn btn-sm btn-{{ $data->status_id == 1 ? 'danger' : 'success' }}"
                                    title="{{ $data->status_id == 1 ? 'Khoá' : 'Mở' }}">
                                    <i class="fas fa-{{ $data->status_id == 1 ? 'lock' : 'unlock' }}"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Table View -->
            <div id="document-table-view" class="d-none">
                <table id="data_table_document" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã Tài liệu</th>
                            <th class="text-center">QR Code</th>
                            <th>Tên Tài liệu</th>
                            <th>Người sở hữu</th>
                            <th>Loại Tài liệu</th>
                            <th>Vị trí lưu trữ</th>
                            <th>Ngày hết hạn</th>
                            <th>Riêng tư</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->code }}</td>
                                <td class="text-center">
                                    <div class="qr-code-table d-inline-block" id="qr-table-{{ $data->id }}"
                                        data-code="{{ $data->code }}" style="cursor: pointer"
                                        onclick="printQRCode('{{ $data->code }}', '{{ $data->name }}', 'qr-table-{{ $data->id }}')"
                                        title="Click để in"></div>
                                </td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->owner }}</td>
                                <td>
                                    @php
                                        $typeIds = json_decode($data->document_types_id) ?? [];
                                        $typeNames = $document_types->whereIn('id', $typeIds)->pluck('name')->toArray();
                                    @endphp
                                    {{ !empty($typeNames) ? implode(', ', $typeNames) : '-' }}
                                </td>
                                <td>{{ $data->location_name }}</td>
                                <td>{{ $data->expired_date ? \Carbon\Carbon::parse($data->expired_date)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    @if ($data->is_private)
                                        <i class="fas fa-lock text-muted" title="Riêng tư"></i>
                                    @else
                                        <i class="fas fa-globe text-success" title="Công khai"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($data->status_id == 1)
                                        <span class="badge badge-success">Sử dụng</span>
                                    @else
                                        <span class="badge badge-danger">Ngưng</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-info btn-view-details"
                                        data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                        data-name="{{ $data->name }}" data-owner="{{ $data->owner }}"
                                        data-filepath="{{ $data->filepath }}"
                                        data-dept="{{ $data->department_name }}"
                                        data-location="{{ $data->location_name }}"
                                        data-warehouse="{{ $data->warehouse_name ?? 'N/A' }}"
                                        data-room="{{ $data->room_name ?? 'N/A' }}"
                                        data-shelf="{{ $data->shelf_name ?? 'N/A' }}"
                                        data-expired="{{ $data->expired_date ? \Carbon\Carbon::parse($data->expired_date)->format('d/m/Y') : 'N/A' }}"
                                        data-private="{{ $data->is_private }}"
                                        data-types="{{ !empty($typeNames) ? implode(', ', $typeNames) : 'N/A' }}"
                                        data-status="{{ $data->status_id == 1 ? 'Sử dụng' : 'Ngưng' }}"
                                        title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if ($data->filepath)
                                        <a href="{{ strpos($data->filepath, 'http') === 0 ? $data->filepath : asset($data->filepath) }}"
                                            target="_blank" class="btn btn-sm btn-primary" title="File">
                                            <i class="fas fa-file-download"></i>
                                        </a>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-warning btn-edit"
                                        data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                        data-name="{{ $data->name }}" data-owner="{{ $data->owner }}"
                                        data-filepath="{{ $data->filepath }}" data-dept="{{ $data->department_id }}"
                                        data-location="{{ $data->location_id }}"
                                        data-expired="{{ $data->expired_date }}"
                                        data-private="{{ $data->is_private }}"
                                        data-types="{{ $data->document_types_id }}" data-toggle="modal"
                                        data-target="#updateModal" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form class="d-inline"
                                        action="{{ route('pages.documentStorage.document.deActive') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <input type="hidden" name="status_id" value="{{ $data->status_id }}">
                                        <button type="submit"
                                            class="btn btn-sm btn-{{ $data->status_id == 1 ? 'danger' : 'success' }}"
                                            title="Lock/Unlock">
                                            <i class="fas fa-{{ $data->status_id == 1 ? 'lock' : 'unlock' }}"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

@if (session('success'))
    <script>
        Swal.fire({
            title: 'Thành công!',
            text: '{{ session('success') }}',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    </script>
@endif

<script>
    $(document).ready(function() {
        const table = $('#data_table_document').DataTable({
            autoWidth: false,
            responsive: true
        });

        // Toggle View Logic
        $('#btn-grid-view').click(function() {
            $(this).addClass('active');
            $('#btn-table-view').removeClass('active');
            $('#document-grid-view').removeClass('d-none');
            $('#document-table-view').addClass('d-none');
        });

        $('#btn-table-view').click(function() {
            $(this).addClass('active');
            $('#btn-grid-view').removeClass('active');
            $('#document-grid-view').addClass('d-none');
            $('#document-table-view').removeClass('d-none');
            table.columns.adjust().draw();
        });

        // Search & Filter Logic
        function applyFilters() {
            const keyword = $('#quick-search-input').val().toLowerCase().trim();
            const type = $('#filter-type').val();
            const warehouse = $('#filter-warehouse').val();
            const room = $('#filter-room').val();
            const shelf = $('#filter-shelf').val();
            const location = $('#filter-location').val();

            // Filter Table View
            table.search(keyword).draw();

            // Filter Grid View
            $('.document-card').each(function() {
                const card = $(this);
                const name = card.find('.name').text().toLowerCase();
                const code = card.find('.code').text().toLowerCase();
                const cardText = card.text();

                let visible = true;

                if (keyword && !name.includes(keyword) && !code.includes(keyword)) visible = false;
                if (type && !cardText.includes(type)) visible = false;
                if (warehouse && !cardText.includes(warehouse)) visible = false;
                if (room && !cardText.includes(room)) visible = false;
                if (shelf && !cardText.includes(shelf)) visible = false;
                if (location && !cardText.includes(location)) visible = false;

                if (visible) {
                    card.show();
                } else {
                    card.hide();
                }
            });
        }

        $('#quick-search-input').on('keyup', applyFilters);
        $('#filter-location, #filter-type, #filter-warehouse, #filter-room, #filter-shelf').on('change',
            applyFilters);
        $('#btn-reset-filter').click(function() {
            $('#quick-search-input').val('');
            $('#filter-type').val('').trigger('change');
            $('#filter-warehouse').val('').trigger('change');
            $('#filter-room').val('').trigger('change');
            $('#filter-shelf').val('').trigger('change');
            $('#filter-location').val('').trigger('change');
            applyFilters();
        });

        // Detail View Logic
        $(document).on('click', '.btn-view-details', function() {
            const btn = $(this);
            const modal = $('#detailModal');

            modal.find('#detail_name').text(btn.data('name'));
            modal.find('#detail_code').text(btn.data('code'));
            modal.find('#detail_dept').text(btn.data('dept'));
            modal.find('#detail_types').text(btn.data('types'));
            modal.find('#detail_warehouse').text(btn.data('warehouse'));
            modal.find('#detail_room').text(btn.data('room'));
            modal.find('#detail_shelf').text(btn.data('shelf'));
            modal.find('#detail_location').text(btn.data('location'));
            modal.find('#detail_owner').text(btn.data('owner') || 'N/A');
            modal.find('#detail_expired').text(btn.data('expired'));
            modal.find('#detail_status').text(btn.data('status'));

            const filepath = btn.data('filepath');
            if (filepath) {
                modal.find('#detail_filepath').text(filepath);
                const fullUrl = filepath.startsWith('http') ? filepath : '{{ asset('') }}' +
                    filepath;
                modal.find('#detail_open_link').attr('href', fullUrl).show();
            } else {
                modal.find('#detail_filepath').text('Không có file đính kèm');
                modal.find('#detail_open_link').hide();
            }

            if (btn.data('private')) {
                modal.find('#detail_private_section').show();
            } else {
                modal.find('#detail_private_section').hide();
            }

            // Generate QR for detail
            modal.find('#detail_qr').empty();
            new QRCode(document.getElementById("detail_qr"), {
                text: btn.data('code'),
                width: 150,
                height: 150,
                colorDark: "#003a4f",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Set print action
            $('#btn-print-detail').off('click').on('click', function() {
                printQRCode(btn.data('code'), btn.data('name'), 'detail_qr');
            });

            modal.modal('show');
        });

        $(document).on('click', '.btn-edit', function() {
            const button = $(this);
            const modal = $('#updateModal');
            modal.find('#update_id').val(button.data('id'));
            modal.find('#update_code').val(button.data('code'));
            modal.find('#update_name').val(button.data('name'));
            modal.find('#update_owner').val(button.data('owner'));
            modal.find('#update_filepath').val(button.data('filepath'));
            modal.find('#update_dept_display').val(button.data('dept'));
            modal.find('#update_dept_id').val(button.data('dept'));
            modal.find('#update_location').val(button.data('location'));
            modal.find('#update_expired').val(button.data('expired'));
            modal.find('#update_is_private').prop('checked', button.data('private') == 1);

            // Populate multi-select for Document Types
            const types = button.data('types');
            if (types) {
                try {
                    const typesArray = typeof types === 'string' ? JSON.parse(types) : types;
                    modal.find('#update_document_types').val(typesArray).trigger('change');
                } catch (e) {
                    console.error("Error parsing document types:", e);
                    modal.find('#update_document_types').val([]).trigger('change');
                }
            } else {
                modal.find('#update_document_types').val([]).trigger('change');
            }
        });

        // Initialize Select2 for modals
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        // Reset multi-select when createModal is shown
        $('#createModal').on('show.bs.modal', function() {
            $(this).find('.select2').val([]).trigger('change');
            $('#create_file_attachment').val('');
            $('#file_name_display').text('').removeClass('text-success font-weight-bold').addClass(
                'text-muted');
        });

        // Generate QR Codes
        function generateAllQRs() {
            $('.qr-code-small').each(function() {
                var id = $(this).attr('id');
                var code = $(this).data('code');
                $(this).empty();
                new QRCode(document.getElementById(id), {
                    text: code,
                    width: 40,
                    height: 40,
                    colorDark: "#003a4f",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });

            $('.qr-code-table').each(function() {
                var id = $(this).attr('id');
                var code = $(this).data('code');
                $(this).empty();
                new QRCode(document.getElementById(id), {
                    text: code,
                    width: 30,
                    height: 30,
                    colorDark: "#333333",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });
        }

        // Generate on load
        generateAllQRs();

        // Regenerate when table or view changes
        $('#btn-table-view, #btn-grid-view').click(function() {
            setTimeout(generateAllQRs, 100);
        });

        table.on('draw', function() {
            generateAllQRs();
        });

        // Print functionality
        window.printQRCode = function(code, name, qrElementId) {
            const qrCanvas = document.getElementById(qrElementId).querySelector('canvas');
            if (!qrCanvas) return;

            const qrImageData = qrCanvas.toDataURL("image/png");
            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
                <html>
                <head>
                    <title>In mã QR - ${code}</title>
                    <style>
                        body { 
                            display: flex; 
                            flex-direction: column; 
                            align-items: center; 
                            justify-content: center; 
                            height: 100vh; 
                            margin: 0; 
                            font-family: Arial, sans-serif;
                            text-align: center;
                        }
                        .container {
                            border: 1px solid #eee;
                            padding: 20px;
                            border-radius: 8px;
                        }
                        .name { font-size: 18px; font-weight: bold; margin-top: 10px; }
                        .code { font-size: 14px; color: #666; }
                        img { width: 200px; height: 200px; }
                        @media print {
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body onload="window.print(); window.close();">
                    <div class="container">
                        <img src="${qrImageData}" />
                        <div class="name">${name}</div>
                        <div class="code">Mã: ${code}</div>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
        };
    });
</script>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detailModalLabel"><i class="fas fa-info-circle"></i> Chi Tiết Tài Liệu
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <div id="detail_qr"
                            style="display: inline-block; padding: 10px; background: white; border: 1px solid #eee; border-radius: 8px;">
                        </div>
                        <h4 class="mt-2 font-weight-bold text-primary" id="detail_name"></h4>
                        <span class="badge badge-pill badge-primary" id="detail_code"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-warehouse text-primary mr-2"></i> Kho:</th>
                                <td id="detail_warehouse"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-door-open text-info mr-2"></i> Phòng:</th>
                                <td id="detail_room"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-layer-group text-warning mr-2"></i> Kệ:</th>
                                <td id="detail_shelf"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-map-marker-alt text-danger mr-2"></i> Vị trí:</th>
                                <td id="detail_location"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-times text-warning mr-2"></i> Hết hạn:</th>
                                <td id="detail_expired"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-check-circle text-success mr-2"></i> Trạng thái:</th>
                                <td id="detail_status"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-building text-info mr-2"></i> Bộ phận:</th>
                                <td id="detail_dept"></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-tags text-primary mr-2"></i> Loại:</th>
                                <td id="detail_types"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%"><i class="fas fa-user-tie text-secondary mr-2"></i> Sở hữu:</th>
                                <td id="detail_owner"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12" id="detail_private_section">
                        <div class="alert alert-warning py-2">
                            <i class="fas fa-eye-slash mr-2"></i> <strong>Tài liệu nội bộ:</strong> Chỉ người có quyền
                            mới có thể truy cập nội dung này.
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="font-weight-bold">File đính kèm / Đường dẫn:</label>
                        <div id="detail_file_container"
                            class="p-3 bg-light rounded d-flex justify-content-between align-items-center">
                            <span id="detail_filepath" class="text-muted truncate mr-2"></span>
                            <a href="#" id="detail_open_link" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Xem File
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-success px-4" id="btn-print-detail">
                    <i class="fas fa-print mr-1"></i> In QR
                </button>
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div class="modal fade" id="qrScannerModal" tabindex="-1" role="dialog" aria-labelledby="qrScannerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="qrScannerModalLabel"><i class="fas fa-qrcode"></i> Quét mã QR bằng Camera
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="qr-reader" style="width: 100%; min-height: 300px; background: #000;"></div>
            </div>
            <div class="modal-footer p-2">
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Hủy bỏ</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let html5QrCode;

        $('#btn-scan-qr').on('click', function() {
            $('#qrScannerModal').modal('show');

            // Wait for modal transition to finish
            setTimeout(() => {
                html5QrCode = new Html5Qrcode("qr-reader");
                const config = {
                    fps: 15,
                    qrbox: {
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0
                };

                html5QrCode.start({
                        facingMode: "environment"
                    },
                    config,
                    (decodedText, decodedResult) => {
                        // Success
                        $('#quick-search-input').val(decodedText).keyup();
                        $('#qrScannerModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã nhận diện!',
                            text: 'Mã: ' + decodedText,
                            timer: 1000,
                            showConfirmButton: false
                        });
                        stopScanner();
                    },
                    (errorMessage) => {
                        // ignore failures
                    }
                ).catch((err) => {
                    console.error("Camera error:", err);
                    Swal.fire('Lỗi Camera',
                        'Không thể khởi động camera. Vui lòng kiểm tra quyền truy cập.',
                        'error');
                    $('#qrScannerModal').modal('hide');
                });
            }, 500);
        });

        function stopScanner() {
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                }).catch(err => console.error("Scanner stop err:", err));
            }
        }

        $('#qrScannerModal').on('hidden.bs.modal', function() {
            stopScanner();
        });
    });
</script>
