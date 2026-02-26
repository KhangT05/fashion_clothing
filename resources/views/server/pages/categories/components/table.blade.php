@if ($categories !== [])
    @foreach ($categories as $item)
        <tr>
            <td class="">
                <span class="">{{ $item->id }}</span>
            </td>
            <td class="">
                <strong>{{ $item->name }}</strong>
            </td>
            <td class="">
                <small class="">
                    {{ $item->description ? Str::limit($item->description, 80) : 'Chưa có mô tả' }}
                </small>
            </td>
            <td class="">
                <code>{{ $item->slug }}</code>
            </td>
            <td class="">
                @if ($item->publish == 1 || $item->trangthai == 1)
                    <span class="label label-success">
                        <i class=""></i> Hiển thị
                    </span>
                @else
                    <span class="">
                        <i class=""></i> Ẩn
                    </span>
                @endif
            </td>
            <td class="">
                <a href="{{ route('categories.edit', ['id' => $item->id]) }}" class="btn btn-xs btn-warning">
                    <i class="fa fa-edit"></i> Sửa
                </a>
                <form action="{{ route('categories.destroy', ['id' => $item->id]) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash"></i> Xóa
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
@else
    <div>Không có danh mục!</div>
@endif
<strong>{{ $categories->links() }}</strong>
