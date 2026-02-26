@extends('server.layout')

@section('title', 'Danh sách liên hệ')

@section('content')
    <div class="card shadow mb-4">
        @if (!$contacts)
            <div class="text-center" style="margin: 40px 0;">
                <h1 class="text-muted">
                    <i class="fa fa-folder-open"></i>
                    <span>Không có liên hệ nào mới</span>
                </h1>
            </div>
        @else
            <div class="btn-group" style="display: flex; gap: 8px; width: 100%;"></div>
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                    style="
                            width: 100%;
                            height: 45px;
                            border-radius: 10px;
                            font-size: 15px;
                            margin: 5px 1px;
                        ">
                    <i class="fa fa-filter"></i>
                    Lọc trạng thái
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['status' => '1', 'page' => 1]) }}">
                            <h4><i class="fa fa-th-list"></i>
                                Chưa đọc</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['status' => '2', 'page' => 1]) }}">
                            <h4><i class="fa fa-ok text-success"></i>
                                Đã đọc</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['status' => '0', 'page' => 1]) }}">
                            <h4><i class="fa fa-time text-warning"></i>
                                Đã xóa</h4>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="btn-group" style="flex: 1">
                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                    style="
                            width: 100%;
                            height: 45px;
                            border-radius: 10px;
                            font-size: 15px;
                        ">
                    <i class="fa fa-sort"></i>
                    Sắp xếp
                    <span class="caret"></span>
                </button>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'desc']) }}">
                            <h4><i class="fa fa-sort-by-attributes-alt"></i>
                                Mới nhất</h4>
                        </a>
                    </li>
                    <li>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'asc']) }}">
                            <h4><i class="fa fa-sort-by-attributes"></i>
                                Cũ nhất</h4>
                        </a>
                    </li>
                </ul>
            </div>
    </div>
    <div style="max-height: 450px;overflow-y: auto;padding-right: 5px;">
        @foreach ($contacts as $contact)
            <div class="panel panel-default" style="position: relative; border-radius: 10px;">
                <div class="panel-body">
                    <div class="row">

                        <div class="col-sm-9">
                            <strong style="font-size: 20px;"><b>{{ $contact->name }}</b></strong>
                            <div style="color: #777;">Email: {{ $contact->email }} -
                                <span><u>{{ $contact->created_at->format('d-m-Y') }}</u></span>
                            </div>


                            <p style="margin-top: 8px; font-size: 16px;">
                                {{ $contact->noidung }}
                            </p>

                            @if ($contact->trangthai == 1)
                                <span class="label label-warning">Chưa đọc</span>
                            @elseif ($contact->trangthai == 2)
                                <span class="label label-success">Đã đọc</span>
                            @else
                                <span class="label label-danger">Đã xóa</span>
                            @endif

                        </div>
                        @if ($contact->trangthai !== 0)
                            <div class="col-sm-3 text-right">
                                @if ($contact->trangthai == 1)
                                    <form action="{{ route('contacts.update', ['id' => $contact->id]) }}" method="POST"
                                        onsubmit="return confirm('Đánh dấu đã đọc liên hệ của {{ $contact->name }}')">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success" style="width: 60%;" type="submit">
                                            <i class="fa fa-ok"></i> Đánh dấu dã đọc
                                        </button>
                                    </form>
                                @endif
                                <br><br>
                                <form action="{{ route('contacts.destroy', ['id' => $contact->id]) }}" method="POST"
                                    onsubmit="return confirm('Đánh dấu đã đọc liên hệ của {{ $contact->name }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" style="width: 60%;" type="submit">
                                        <i class="fa fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <strong>{{ $contacts->links() }}</strong>
    @endif

    </div>
@endsection
