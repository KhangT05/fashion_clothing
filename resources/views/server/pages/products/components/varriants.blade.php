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
                        name="has_attribute" id="customSwitch" {{ old('has_attribute') == 1 ? 'checked' : '' }}>
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
                            thuộc tính khác nhau
                        </div>

                        <div class="variant-wrapper {{ old('has_attribute') == 1 ? '' : 'd-none' }}">
                            <div class="variant-body mb-3">
                                <div id="variantAttributesContainer"></div>
                            </div>

                            <div class="variant-foot mb-3">
                                <button type="button" class="btn btn-primary" id="addAttributeBtn">
                                    <i class="fa fa-plus"></i> Thêm thuộc tính
                                </button>
                            </div>

                            <div class="card product-variant mt-3">
                                <div class="card-header">
                                    Danh sách phiên bản sản phẩm
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="variantsTableContainer">
                                            <thead>
                                                <tr>
                                                    <th>Phiên bản</th>
                                                    <th>SKU</th>
                                                    <th>Giá (VNĐ)</th>
                                                    <th>Số lượng</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTableBody">
                                                <tr id="emptyState">
                                                    <td colspan="5" class="text-center text-muted">
                                                        Chọn thuộc tính để tạo biến thể
                                                    </td>
                                                </tr>
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
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f9f9f9;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 5px;
        flex: 0 0 auto;
    }

    .checkbox-item input[type="checkbox"] {
        cursor: pointer;
    }

    .checkbox-item label {
        margin: 0;
        cursor: pointer;
        user-select: none;
    }

    .variant-wrapper.d-none {
        display: none;
    }

    .variant-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .variant-item:last-child {
        border-bottom: none;
    }
</style>

<script>
    const variantTypes = @json($bienthe ?? []);
    const baseSku = document.getElementById('sku')?.value || "{{ $sku ?? 'PROD' }}";
    const basePrice = document.getElementById('giaban')?.value || 0;

    const variantValues = {};
    variantTypes.forEach(t => {
        variantValues[t.id] = t.bienthe_values || [];
    });

    let attributeIndex = 0;
    document.getElementById('customSwitch').addEventListener('change', function() {
        const wrapper = document.querySelector('.variant-wrapper');
        if (this.checked) {
            wrapper.classList.remove('d-none');
        } else {
            wrapper.classList.add('d-none');
        }
    });

    document.getElementById('addAttributeBtn').addEventListener('click', addAttributeRow);

    function onTypeChange(id) {
        const typeId = document.getElementById(`type-${id}`).value;
        const container = document.getElementById(`value-container-${id}`);
        container.innerHTML = '';

        if (!typeId) {
            generateVariants();
            return;
        }

        const values = variantValues[typeId] || [];

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

    function removeVariantRow(index) {
        const row = document.querySelector(`tr[data-variant-index="${index}"]`);
        if (row) row.remove();
    }

    function cartesian(arr) {
        return arr.reduce((a, b) => a.flatMap(d => b.map(e => [].concat(d, e))));
    }

    function generateVariants() {
        const groups = [];
        document.querySelectorAll('[id^="attr-"]').forEach(row => {
            const id = row.id.split('-')[1];
            const type = document.getElementById(`type-${id}`);

            if (!type || !type.value) return;

            const checkboxes = document.querySelectorAll(`input[name="variant-value-${id}"]:checked`);
            const selected = Array.from(checkboxes).map(cb => ({
                type_id: type.value,
                value_id: cb.value,
                value_name: cb.getAttribute('data-value-name')
            }));

            if (selected.length > 0) {
                groups.push(selected);
            }
        });

        if (!groups.length) {
            document.getElementById('emptyState').style.display = 'table-row';
            document.querySelectorAll('#variantsTableBody tr[data-variant-index]').forEach(el => el.remove());
            return;
        }

        document.getElementById('emptyState').style.display = 'none';
        const combos = cartesian(groups);
        renderVariants(combos);
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
                    ${variantTypes.map(t => `<option value="${t.id}">${t.type}</option>`).join('')}
                </select>
            </div>

            <div class="col-lg-8">
                <label class="form-label">Chọn Giá Trị (Click vào ô vuông)</label>
                <div class="checkbox-group" id="value-container-${id}">
                    <p class="text-muted" style="width: 100%; margin: 0;">Chọn thuộc tính trước</p>
                </div>
            </div>

            <div class="col-lg-1">
                <label class="form-label">&nbsp;</label>
                <button type="button" class="btn btn-icon btn-danger w-100 h-100" onclick="removeAttr(${id})">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        `;

        document.getElementById('variantAttributesContainer').appendChild(div);
    }

    function renderVariants(combos) {
        const currentSku = document.getElementById('sku')?.value || 'SP'.now();
        const currentPrice = document.getElementById('giaban')?.value || 1000;
        const currentQuantity = document.getElementById('soluong')?.value || 1;
        const tbody = document.getElementById('variantsTableBody');
        // Xóa tất cả rows cũ (giữ emptyState)
        document.querySelectorAll('#variantsTableBody tr[data-variant-index]').forEach(el => el.remove());
        combos.forEach((attrs, i) => {
            const name = attrs.map(a => a.value_name).join(' - ');
            let attributeInputs = '';
            // Tạo hidden inputs cho attributes
            attrs.forEach(a => {
                attributeInputs += `
                <input type="hidden" 
                       name="sanpham_variants[${i}][attributes][]" 
                       value="${a.value_id}">
            `;
            });

            const row = document.createElement('tr');
            row.setAttribute('data-variant-index', i);
            row.innerHTML = `
            <td>
                ${name}
                ${attributeInputs}
            </td>
           <td>
            <input class="form-control"
                   type="text"
                   name="sanpham_variants[${i}][sku]"
                   value="${currentSku}-${i + 1}"
                   required>
            </td>
            <td>
            <input type="text"
                   class="form-control"
                   name="sanpham_variants[${i}][giaban]"
                   value="${currentPrice}"
                   required>
            </td>
            <td>
            <input type="text"
                   class="form-control"
                   name="sanpham_variants[${i}][soluong]"
                   value="${currentQuantity}"
                   required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeVariantRow(${i})">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
            tbody.appendChild(row);
        });
    }
    // Lắng nghe thay đổi SKU và Giá sản phẩm cha
    const skuInput = document.getElementById('sku');
    const giaInput = document.getElementById('giaban');
    const soluongInput = document.getElementById('soluong');
    if (skuInput) {
        skuInput.addEventListener('input', function() {
            document.querySelectorAll('input[name*="sanpham_variants"][name*="sku"]').forEach((el, idx) => {
                el.value = this.value + '-' + (idx + 1);
            });
        });
    }
    if (giaInput) {
        giaInput.addEventListener('input', function() {
            document.querySelectorAll('input[name*="sanpham_variants"][name*="giaban"]').forEach(el => {
                if (el.value === '0' || el.value === '') {
                    el.value = this.value;
                }
            });
        });
    }
    if (soluongInput) {
        soluongInput.addEventListener('input', function() {
            document.querySelectorAll('input[name*="sanpham_variants"][name*="soluong"]').forEach(el => {
                if (el.value === '0' || el.value === '') {
                    el.value = this.value;
                }
            });
        });
    }
</script>
