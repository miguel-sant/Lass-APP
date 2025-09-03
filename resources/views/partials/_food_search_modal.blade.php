<div class="modal fade" id="foodSearchModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar alimento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="meal_type_input" name="meal_type">
                <div class="input-group mb-3">
                    <input id="foodQuery" class="form-control" placeholder="Pesquisar alimento (ex.: arroz, frango)">
                    <button id="foodSearchBtn" class="btn btn-primary">Buscar</button>
                </div>

                <div id="foodResults" class="list-group"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('#foodSearchBtn').on('click', function() {
                const q = $('#foodQuery').val().trim();
                if (!q) return $('#foodResults').html('<div class="text-muted">Digite para buscar.</div>');
                $('#foodResults').html('<div class="text-muted">Buscando...</div>');
                $.get('/food/search', {
                    q
                }, function(res) {
                    if (!res.length) return $('#foodResults').html(
                        '<div class="text-muted">Nenhum resultado.</div>');
                    let html = '';
                    res.forEach(f => {
                        const serving = f.serving_size || 100;
                        html += `<div class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>${f.name}</strong>
            <div class="small text-muted">P:${f.protein}g • C:${f.carbs}g • F:${f.fat}g • ${serving}g</div>
          </div>
          
          <div class="d-flex align-items-center">
            <input type="number" value="${serving}" class="form-control form-control-sm me-2 amount-input" style="width:90px"/>
            <button class="btn btn-sm btn-success add-food-btn" data-id="${f.id}">Adicionar</button>
          </div>
        </div>`;
                    });
                    $('#foodResults').html(html);
                });
            });

            $(document).on('click', '.add-food-btn', function() {
                const id = $(this).data('id');
                const amount = $(this).closest('.list-group-item').find('.amount-input').val() || 100;
                const mealType = $('#meal_type_input').val();

                $.post('/meal', {
                    food_id: id,
                    amount: amount,
                    meal_type: mealType,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, function() {
                    var modal = bootstrap.Modal.getInstance(document.getElementById('foodSearchModal'));
                    modal.hide();
                    location.reload();
                }).fail(function(xhr) {
                    alert('Erro ao adicionar: ' + (xhr.responseJSON?.message || ''));
                });
            });

            $('.meal-period-chart-container').on('click', function() {
                currentMealType = $(this).data('meal-type');
                $('#meal_type_input').val(currentMealType);
                // ...
            });
        });
    </script>
@endpush
