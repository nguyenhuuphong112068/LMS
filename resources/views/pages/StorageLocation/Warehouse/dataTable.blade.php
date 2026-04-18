<style>
    /* Card Grid Styles */
    .warehouse-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-top: 15px;
    }

    .warehouse-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        padding: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-top: 4px solid var(--primary-navy, #003a4f);
        position: relative;
    }

    .warehouse-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .warehouse-card .icon {
        font-size: 2.5rem;
        color: var(--primary-navy, #003a4f);
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .warehouse-card .code {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .warehouse-card .name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin: 5px 0 10px;
    }

    .warehouse-card .dept {
        font-size: 0.9rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .warehouse-card .status {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .warehouse-card .actions {
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
        color: var(--primary-navy, #003a4f);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="content-wrapper">
    <div class="card mt-5">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#createModal" style="width: 155px">
                    <i class="fas fa-plus"></i> Thêm mới Kho
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
            <div id="warehouse-grid-view" class="warehouse-grid">
                @foreach ($datas as $data)
                    <div class="warehouse-card">
                        <div class="status">
                            @if ($data->status_id == 1)
                                <span class="badge badge-success">Sử dụng</span>
                            @else
                                <span class="badge badge-danger">Ngưng</span>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                        <div class="code">{{ $data->code }}</div>
                        <div class="name">{{ $data->name }}</div>
                        <div class="dept">
                            <i class="fas fa-building text-info"></i>
                            {{ $data->department_name }}
                        </div>
                        <div class="actions">
                            <button type="button" class="btn btn-sm btn-outline-warning btn-edit"
                                data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                data-name="{{ $data->name }}" data-dept="{{ $data->department_id }}"
                                data-toggle="modal" data-target="#updateModal">
                                <i class="fas fa-edit"></i> Sửa
                            </button>
                            <form class="d-inline" action="{{ route('pages.storageLocation.warehouse.deActive') }}"
                                method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <input type="hidden" name="status_id" value="{{ $data->status_id }}">
                                <button type="submit"
                                    class="btn btn-sm btn-outline-{{ $data->status_id == 1 ? 'danger' : 'success' }}">
                                    <i class="fas fa-{{ $data->status_id == 1 ? 'lock' : 'unlock' }}"></i>
                                    {{ $data->status_id == 1 ? 'Khoá' : 'Mở' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Table View -->
            <div id="warehouse-table-view" class="d-none">
                <table id="data_table_warehouse" class="table table-bordered table-striped w-100">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã Kho</th>
                            <th>Tên Kho</th>
                            <th>Phòng Ban</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->code }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->department_name }}</td>
                                <td class="text-center">
                                    @if ($data->status_id == 1)
                                        <span class="badge badge-success">Sử dụng</span>
                                    @else
                                        <span class="badge badge-danger">Ngưng</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-warning btn-edit mr-1"
                                        data-id="{{ $data->id }}" data-code="{{ $data->code }}"
                                        data-name="{{ $data->name }}" data-dept="{{ $data->department_id }}"
                                        data-toggle="modal" data-target="#updateModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form class="d-inline" action="{{ route('pages.storageLocation.warehouse.deActive') }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <input type="hidden" name="status_id" value="{{ $data->status_id }}">
                                        <button type="submit"
                                            class="btn btn-{{ $data->status_id == 1 ? 'danger' : 'success' }}">
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
        const table = $('#data_table_warehouse').DataTable({
            autoWidth: false,
            responsive: true
        });

        // Toggle View Logic
        $('#btn-grid-view').click(function() {
            $(this).addClass('active');
            $('#btn-table-view').removeClass('active');
            $('#warehouse-grid-view').removeClass('d-none');
            $('#warehouse-table-view').addClass('d-none');
        });

        $('#btn-table-view').click(function() {
            $(this).addClass('active');
            $('#btn-grid-view').removeClass('active');
            $('#warehouse-grid-view').addClass('d-none');
            $('#warehouse-table-view').removeClass('d-none');
            // Adjust datatable columns since it was hidden
            table.columns.adjust().draw();
        });

        $(document).on('click', '.btn-edit', function() {
            const button = $(this);
            const modal = $('#updateModal');
            modal.find('#update_id').val(button.data('id'));
            modal.find('#update_code').val(button.data('code'));
            modal.find('#update_name').val(button.data('name'));
            modal.find('#update_dept').val(button.data('dept'));
        });
    });
</script>
