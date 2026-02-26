@if ($errors->has('sanpham_variants'))
    <div class="alert alert-danger">
        {{ $errors->first('sanpham_variants') }}
    </div>
@endif
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <label for="" class="d-flex align-items-center mb-0" style="gap: 10px">
                Sản phẩm có nhiều phiên bản
                <div class="form-check form-switch">
                    <input type="checkbox" class="form-check-input js-switch turnOnVariant" value="1"
                        name="has_attribute" id="customSwitch"
                        {{ old('has_attribute', optional($products)->has_attribute ?? 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="customSwitch"></label>
                </div>
            </label>
        </div>
        <div class="card-body">
            <div class="form-group mb-0">
                <div class="attribute_container_product">
                    <div class="form-group">
                        <div class="alert alert-primary">
                            <strong class="text-danger">*</strong> Cho phép bạn tạo nhiều phiên bản sản phẩm với các
                            thuộc tính khác nhau như màu sắc, kích thước, v.v.
                        </div>
                        <div
                            class="variant-wrapper {{ old('has_attribute', optional($products)->has_attribute ?? 0) == 1 ? '' : 'd-none' }}">
                            <div class="variant-body mb-3">
                                <div id="variantAttributesContainer">
                                    @if (isset($products) && $products->sanpham_variants->count() > 0)
                                        @php
                                            // Lấy unique type_id từ tất cả variants
                                            $uniqueTypes = [];
                                            foreach ($products->sanpham_variants as $variant) {
                                                foreach ($variant->attributesValues as $attr) {
                                                    $typeId = $attr->bienthe_id;
                                                    if (!isset($uniqueTypes[$typeId])) {
                                                        $uniqueTypes[$typeId] = [];
                                                    }
                                                    $uniqueTypes[$typeId][] = $attr->id;
                                                }
                                            }
                                            // Loại bỏ duplicate
                                            foreach ($uniqueTypes as $typeId => $values) {
                                                $uniqueTypes[$typeId] = array_unique($values);
                                            }
                                        @endphp
                                        @php $attributeIndex = 0; @endphp
                                        @foreach ($uniqueTypes as $typeId => $valueIds)
                                            @php
                                                $attrType = $bienthe->firstWhere('id', $typeId);
                                            @endphp
                                            @if ($attrType)
                                                <div class="row mb-3 align-items-start variant-item"
                                                    id="attr-{{ $attributeIndex }}">
                                                    <div class="col-lg-3">
                                                        <label class="form-label">Chọn Thuộc Tính <span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control choose-attribute"
                                                            onchange="onTypeChange({{ $attributeIndex }})"
                                                            id="type-{{ $attributeIndex }}">
                                                            <option value="">-- Chọn Nhóm thuộc tính --</option>
                                                            @foreach ($bienthe as $type)
                                                                <option value="{{ $type->id }}"
                                                                    {{ $type->id == $typeId ? 'selected' : '' }}
                                                                    data-type-name="{{ $type->name }}">
                                                                    {{ $type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-8">
                                                        <label class="form-label">Chọn Giá Trị</label>
                                                        <div class="checkbox-group"
                                                            id="value-container-{{ $attributeIndex }}">
                                                            @foreach ($attrType->bienthe_values as $value)
                                                                <div class="checkbox-item">
                                                                    <input type="checkbox"
                                                                        id="value-{{ $attributeIndex }}-{{ $value->id }}"
                                                                        name="variant-value-{{ $attributeIndex }}"
                                                                        value="{{ $value->id }}"
                                                                        data-value-name="{{ $value->value }}"
                                                                        data-type-id="{{ $typeId }}"
                                                                        {{ in_array($value->id, $valueIds) ? 'checked' : '' }}
                                                                        onchange="generateVariants()">
                                                                    <label
                                                                        for="value-{{ $attributeIndex }}-{{ $value->id }}">
                                                                        {{ $value->value }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <label class="form-label">&nbsp;</label>
                                                        <button type="button" class="btn btn-icon btn-danger w-100"
                                                            onclick="removeAttr({{ $attributeIndex }})"
                                                            title="Xóa thuộc tính">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @php $attributeIndex++; @endphp
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="variant-foot mb-3">
                                <button type="button" class="btn btn-primary" id="addAttributeBtn">
                                    <i class="fa fa-plus"></i> Thêm thuộc tính
                                </button>
                            </div>

                            <div class="card product-variant mt-3">
                                <div class="card-header bg-light">
                                    <strong>Danh sách phiên bản sản phẩm</strong>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover mb-0"
                                            id="variantsTableContainer">
                                            <thead class="table-light">
                                                <tr>
                                                    <th width="30%">Phiên bản</th>
                                                    <th width="20%">SKU</th>
                                                    <th width="20%">Giá (VNĐ)</th>
                                                    <th width="15%">Số lượng</th>
                                                    <th width="10%" class="text-center">Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTableBody">
                                                @if (isset($products) && $products->sanpham_variants->count() > 0)
                                                    @foreach ($products->sanpham_variants as $index => $variant)
                                                        <tr data-variant-index="{{ $index }}">
                                                            {{-- Hidden ID field --}}
                                                            <input type="hidden"
                                                                name="sanpham_variants[{{ $index }}][id]"
                                                                value="{{ $variant->id }}">
                                                            <td>
                                                                <strong>{{ $variant->attributesValues->pluck('value')->join(' - ') }}</strong>
                                                                {{-- Hidden attribute IDs --}}
                                                                @foreach ($variant->attributesValues as $attr)
                                                                    <input type="hidden"
                                                                        name="sanpham_variants[{{ $index }}][attributes][]"
                                                                        value="{{ $attr->id }}">
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                <input class="form-control form-control-sm"
                                                                    type="text"
                                                                    name="sanpham_variants[{{ $index }}][sku]"
                                                                    value="{{ $variant->sku }}" placeholder="SKU"
                                                                    required>
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    class="form-control form-control-sm"
                                                                    name="sanpham_variants[{{ $index }}][giaban]"
                                                                    value="{{ $variant->giaban }}" min="0"
                                                                    step="0.01" placeholder="Giá bán" required>
                                                            </td>
                                                            <td>
                                                                <input type="number"
                                                                    class="form-control form-control-sm"
                                                                    name="sanpham_variants[{{ $index }}][soluong]"
                                                                    value="{{ $variant->soluong }}" min="0"
                                                                    placeholder="Số lượng" required>
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                    onclick="removeVariantRow({{ $index }})"
                                                                    title="Xóa biến thể">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr id="emptyState">
                                                        <td colspan="5" class="text-center text-muted py-4">
                                                            <i class="fa fa-info-circle"></i> Chọn thuộc tính để tạo
                                                            biến thể
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        max-height: 200px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #f8f9fa;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 10px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .checkbox-item:hover {
        background: #e9ecef;
        border-color: #adb5bd;
    }

    .checkbox-item input[type="checkbox"] {
        cursor: pointer;
        width: 16px;
        height: 16px;
    }

    .checkbox-item label {
        margin: 0;
        cursor: pointer;
        user-select: none;
        font-weight: 500;
    }

    .variant-wrapper.d-none {
        display: none !important;
    }

    .variant-item {
        margin-bottom: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .variant-item:last-child {
        margin-bottom: 0;
    }

    .product-variant .table th {
        font-weight: 600;
        background-color: #f8f9fa;
    }

    .product-variant .table td {
        vertical-align: middle;
    }

    .form-control-sm {
        font-size: 0.875rem;
    }

    #variantsTableBody tr:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    const variantTypes = @json($bienthe ?? []);
    const baseSku = '{{ isset($products) ? $products->sku : 'PROD' }}';
    const basePrice = parseFloat('{{ isset($products) ? $products->giaban : 0 }}') || 0;

    const variantValues = {};
    variantTypes.forEach(t => {
        variantValues[t.id] = t.bienthe_values || [];
    });
    let attributeIndex = {{ $attributeIndex ?? 0 }};

    function generateUniqueSku(attributes, baseSkuValue) {
        if (!attributes || attributes.length === 0) {
            return baseSkuValue;
        }
        const suffix = attributes.map(a => {
            const name = a.value_name || '';
            return name.substring(0, 3).toUpperCase().replace(/\s+/g, '');
        }).filter(s => s).join('-');

        return suffix ? `${baseSkuValue}-${suffix}` : baseSkuValue;
    }

    function isSkuDuplicate(sku, currentIndex) {
        const allSkuInputs = document.querySelectorAll('input[name*="sanpham_variants"][name*="[sku]"]');
        let isDuplicate = false;

        allSkuInputs.forEach((input, idx) => {
            if (idx !== currentIndex && input.value.trim() === sku.trim()) {
                isDuplicate = true;
            }
        });

        return isDuplicate;
    }

    function ensureUniqueSku(baseSku, attributes, index) {
        let sku = generateUniqueSku(attributes, baseSku);
        let counter = 1;

        while (isSkuDuplicate(sku, index)) {
            sku = `${generateUniqueSku(attributes, baseSku)}-${counter}`;
            counter++;
        }

        return sku;
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle variant wrapper
        const customSwitch = document.getElementById('customSwitch');
        if (customSwitch) {
            customSwitch.addEventListener('change', function() {
                const wrapper = document.querySelector('.variant-wrapper');
                if (this.checked) {
                    wrapper.classList.remove('d-none');
                } else {
                    wrapper.classList.add('d-none');
                    // Confirm trước khi ẩn
                    if (document.querySelectorAll('#variantsTableBody tr[data-variant-index]').length >
                        0) {
                        if (!confirm(
                                'Tắt tính năng biến thể sẽ xóa tất cả các biến thể hiện có. Bạn có chắc chắn?'
                            )) {
                            this.checked = true;
                            wrapper.classList.remove('d-none');
                        }
                    }
                }
            });
        }
        const addBtn = document.getElementById('addAttributeBtn');
        if (addBtn) {
            addBtn.addEventListener('click', addAttributeRow);
        }
        const giaInput = document.getElementById('giaban');
        if (giaInput) {
            giaInput.addEventListener('change', function() {
                const newPrice = this.value;
                document.querySelectorAll('input[name*="sanpham_variants"][name*="[giaban]"]').forEach(
                    el => {
                        if (el.value === '0' || el.value === '' || el.value === '0.00') {
                            el.value = newPrice;
                        }
                    });
            });
        }
    });
    // Upload ảnh cho album chung
    $(document).on('click', '.upload-picture[data-name="album"]', function() {
        selectImageFromMedia('album', true); // true = multiple
    });

    // Upload ảnh cho từng variant
    $(document).on('click', '.upload-picture[data-variant-index]', function() {
        const variantIndex = $(this).data('variant-index');
        selectImageFromMedia(`sanpham_variants[${variantIndex}][album]`, true);
    });

    // Hàm thêm ảnh vào danh sách
    function addImageToAlbum(inputName, imageUrl) {
        const container = $(`button[data-name="${inputName}"]`)
            .closest('.album-upload-wrapper')
            .find('.upload-list');

        const html = `
        <li class="ui-state-default img_li_DAMH col-xl-2 col-md-3 col-sm-6 mb-3">
            <div class="thumb img_albums_DAMH">
                <span class="span image img-scaledown">
                    <a href="${imageUrl}" data-fancybox="gallery">
                        <img src="${imageUrl}" alt="Album preview" 
                             width="100%" class="img-thumbnail">
                    </a>
                    <input type="hidden" name="${inputName}[]" value="${imageUrl}">
                </span>
                <div class="btn_delete_albums_DAMH">
                    <button type="button" 
                            class="delete-image btn btn-sm btn-light-danger" 
                            title="Delete Image">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            </div>
        </li>
    `;

        container.append(html);
    }

    // Xóa ảnh
    $(document).on('click', '.delete-image', function() {
        $(this).closest('li').remove();
    });

    function onTypeChange(id) {
        const typeSelect = document.getElementById(`type-${id}`);
        const typeId = typeSelect ? typeSelect.value : '';
        const container = document.getElementById(`value-container-${id}`);

        if (!container) return;

        container.innerHTML = '';

        if (!typeId) {
            container.innerHTML =
                '<p class="text-muted" style="width: 100%; margin: 0;">Chọn nhóm thuộc tính trước</p>';
            generateVariants();
            return;
        }

        const values = variantValues[typeId] || [];

        if (values.length === 0) {
            container.innerHTML = '<p class="text-muted" style="width: 100%; margin: 0;">Không có giá trị nào</p>';
            return;
        }

        values.forEach((v) => {
            const checkboxDiv = document.createElement('div');
            checkboxDiv.className = 'checkbox-item';
            checkboxDiv.innerHTML = `
                <input 
                    type="checkbox" 
                    id="value-${id}-${v.id}" 
                    name="variant-value-${id}" 
                    value="${v.id}" 
                    data-value-name="${v.value}"
                    data-type-id="${typeId}"
                    onchange="generateVariants()">
                <label for="value-${id}-${v.id}">${v.value}</label>
            `;
            container.appendChild(checkboxDiv);
        });

        generateVariants();
    }

    function removeAttr(id) {
        const row = document.getElementById(`attr-${id}`);
        if (row) {
            row.remove();
            generateVariants();
        }
    }

    function addAttributeRow() {
        const id = attributeIndex++;
        const div = document.createElement('div');
        div.className = 'row mb-3 align-items-start variant-item';
        div.id = `attr-${id}`;

        div.innerHTML = `
            <div class="col-lg-3">
                <label class="form-label">Chọn Thuộc Tính <span class="text-danger">*</span></label>
                <select class="form-control choose-attribute" onchange="onTypeChange(${id})" id="type-${id}">
                    <option value="">-- Chọn Nhóm thuộc tính --</option>
                    ${variantTypes.map(t => `<option value="${t.id}">${t.name}</option>`).join('')}
                </select>
            </div>

            <div class="col-lg-8">
                <label class="form-label">Chọn Giá Trị</label>
                <div class="checkbox-group" id="value-container-${id}">
                    <p class="text-muted" style="width: 100%; margin: 0;">Chọn nhóm thuộc tính trước</p>
                </div>
            </div>

            <div class="col-lg-1">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-danger w-100" onclick="removeAttr(${id})" title="Xóa thuộc tính">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;

        document.getElementById('variantAttributesContainer').appendChild(div);
    }

    function removeVariantRow(index) {
        const row = document.querySelector(`tr[data-variant-index="${index}"]`);
        if (row) row.remove();
    }

    function updateVariantIndices() {
        const rows = document.querySelectorAll('#variantsTableBody tr[data-variant-index]');
        rows.forEach((row, newIndex) => {
            row.setAttribute('data-variant-index', newIndex);
            row.querySelectorAll('input').forEach(input => {
                const name = input.getAttribute('name');
                if (name && name.includes('sanpham_variants')) {
                    const newName = name.replace(/\[\d+\]/, `[${newIndex}]`);
                    input.setAttribute('name', newName);
                }
            });
            const deleteBtn = row.querySelector('button[onclick*="removeVariantRow"]');
            if (deleteBtn) {
                deleteBtn.setAttribute('onclick', `removeVariantRow(${newIndex})`);
            }
        });
    }

    function cartesian(arr) {
        if (!arr || arr.length === 0) return [];
        return arr.reduce((a, b) =>
            a.flatMap(d => b.map(e => Array.isArray(d) ? [...d, e] : [d, e]))
        );
    }

    function generateVariants() {
        const groups = [];
        document.querySelectorAll('[id^="attr-"]').forEach(row => {
            const id = row.id.split('-')[1];
            const typeSelect = document.getElementById(`type-${id}`);

            if (!typeSelect || !typeSelect.value) return;

            const checkboxes = document.querySelectorAll(`input[name="variant-value-${id}"]:checked`);
            const selected = Array.from(checkboxes).map(cb => ({
                bienthe_value_id: cb.value,
                value_name: cb.getAttribute('data-value-name'),
                type_id: cb.getAttribute('data-type-id') || typeSelect.value
            }));

            if (selected.length > 0) {
                groups.push(selected);
            }
        });
        if (groups.length === 0) {
            const emptyState = document.getElementById('emptyState');
            if (emptyState) {
                emptyState.style.display = 'table-row';
            } else {
                const tbody = document.getElementById('variantsTableBody');
                tbody.innerHTML = `
                    <tr id="emptyState">
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="fa fa-info-circle"></i> Chọn thuộc tính để tạo biến thể
                        </td>
                    </tr>
                `;
            }
            document.querySelectorAll('#variantsTableBody tr[data-variant-index]').forEach(el => el.remove());
            return;
        }

        // Hide empty state
        const emptyState = document.getElementById('emptyState');
        if (emptyState) {
            emptyState.style.display = 'none';
        }

        // Generate combinations
        const combos = cartesian(groups);
        renderVariants(combos);
    }

    function renderVariants(combos) {
        const tbody = document.getElementById('variantsTableBody');
        const existingRows = document.querySelectorAll('#variantsTableBody tr[data-variant-index]');

        // Save existing data
        const existingData = [];
        existingRows.forEach(row => {
            const variantId = row.querySelector('input[name*="[id]"]')?.value;
            const sku = row.querySelector('input[name*="[sku]"]')?.value;
            const giaban = row.querySelector('input[name*="[giaban]"]')?.value;
            const soluong = row.querySelector('input[name*="[soluong]"]')?.value;
            const attributes = Array.from(row.querySelectorAll('input[name*="[attributes]"]'))
                .map(inp => inp.value)
                .sort()
                .join(',');

            existingData.push({
                variantId,
                sku,
                giaban,
                soluong,
                attributes
            });
        });
        existingRows.forEach(el => el.remove());
        const currentBaseSku = document.getElementById('sku')?.value || baseSku;
        combos.forEach((attrs, i) => {
            const name = attrs.map(a => a.value_name).join(' - ');
            const newAttributes = attrs.map(a => a.bienthe_value_id).sort().join(',');
            const existingMatch = existingData.find(d => d.attributes === newAttributes);
            const uniqueSku = existingMatch?.sku || ensureUniqueSku(currentBaseSku, attrs, i);
            const attributeInputs = attrs.map(a => `
                <input type="hidden" 
                       name="sanpham_variants[${i}][attributes][]" 
                       value="${a.bienthe_value_id}">
            `).join('');

            const row = document.createElement('tr');
            row.setAttribute('data-variant-index', i);
            row.innerHTML = `
                ${existingMatch?.variantId ? `<input type="hidden" name="sanpham_variants[${i}][id]" value="${existingMatch.variantId}">` : ''}
                <td>
                    <strong>${name}</strong>
                    ${attributeInputs}
                </td>
                <td>
                    <input class="form-control form-control-sm" type="text" 
                           name="sanpham_variants[${i}][sku]" 
                           value="${uniqueSku}" 
                           placeholder="SKU"
                           required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                           name="sanpham_variants[${i}][giaban]" 
                           value="${existingMatch?.giaban || basePrice}" 
                           min="0" step="0.01"
                           placeholder="Giá bán"
                           required>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm" 
                           name="sanpham_variants[${i}][soluong]" 
                           value="${existingMatch?.soluong || 0}" 
                           min="0"
                           placeholder="Số lượng"
                           required>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="removeVariantRow(${i})"
                            title="Xóa biến thể">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }
</script>
