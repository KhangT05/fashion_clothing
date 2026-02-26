@foreach ($roles as $item)
    <tr>
        <td><input type="checkbox" /></td>
        <td>{{ $item->id }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->description }}</td>
        @if ($item->publish === 1)
            <td class="badge bg-success">Hiện</td>
        @elseif($item->publish === 2)
            <td class="badge bg-warning">Ẩn</td>
        @endif
        <td>
            <div class="action-buttons-inline" style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('roles.show', $item->id) }}" class="btn btn-action btn-info">Xem chi tiết</a>
                <a href="{{ route('roles.edit', $item->id) }}" class="btn btn-action btn-edit">Sửa</a>
                <form action="{{ route('roles.delete', $item->id) }}" method="POST" style="margin: 0;"
                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-md">Xóa</button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
