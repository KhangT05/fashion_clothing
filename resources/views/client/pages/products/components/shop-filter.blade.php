<div class="card">
    <form method="GET" action="{{ route('client.products.index') }}" class="no-effect-form">
        <div class="filter-card p-3">
            <input type="text" name="keyword" class="form-control mb-2" placeholder="Tìm theo tên hoặc mô tả"
                value="{{ request('keyword') }}">
            <select name="category_id" class="form-control mb-2">
                <option value="">-- Tất cả danh mục --</option>
                @foreach ($categories ?? [] as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="row">
                <div class="col">
                    <input type="number" name="min_price" class="form-control" placeholder="Giá từ"
                        value="{{ request('min_price') }}">
                </div>
                <div class="col">
                    <input type="number" name="max_price" class="form-control" placeholder="Giá đến"
                        value="{{ request('max_price') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">
                <i class="fa fa-filter"></i> Lọc sản phẩm
            </button>
        </div>
    </form>
</div>
