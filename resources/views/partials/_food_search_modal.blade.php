<div class="modal fade" id="foodSearchModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="foodSearchModalLabel">Buscar alimento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0">
        <div id="food-search-view" class="p-3">
          <form id="foodSearchForm" class="d-flex gap-2 mb-3">
            @csrf
            <input type="text" id="searchInput" class="form-control" placeholder="Arroz, ovo..." autocomplete="off">
            <button class="btn btn-primary" id="btnSearch">Buscar</button>
          </form>
          <div id="results" class="list-group small"></div>
        </div>

        <div id="food-detail-view" class="p-3" style="display:none;">
          <button type="button" class="btn btn-link p-0 mb-2 small" id="backToResults">&larr; Voltar</button>
          <h6 id="fd-name" class="fw-bold mb-1"></h6>
          <div class="text-muted small mb-3" id="fd-base"></div>

          <form id="addFoodForm">
            <div class="row g-2 mb-3">
              <div class="col-4">
                <label class="form-label small mb-1">Qtd</label>
                <input type="number" step="0.25" min="0.25" value="1" id="fd-qty" class="form-control">
              </div>
              <div class="col-8">
                <label class="form-label small mb-1">Porção</label>
                <select id="fd-portion" class="form-select"></select>
              </div>
            </div>

            <div class="border rounded-3 mb-3 p-2 bg-light">
              <div class="row text-center small fw-semibold">
                <div class="col">Calorias</div>
                <div class="col">Gorduras</div>
                <div class="col">Carb</div>
                <div class="col">Proteínas</div>
              </div>
              <div class="row text-center small" id="fd-macro-cards">
                <div class="col" id="fd-calories">0</div>
                <div class="col" id="fd-fat">0g</div>
                <div class="col" id="fd-carbs">0g</div>
                <div class="col" id="fd-protein">0g</div>
              </div>
            </div>

            <div class="small mb-2 fw-bold">Informação Nutricional (por porção)</div>
            <table class="table table-sm mb-3">
              <tbody class="small" id="fd-nutrition-rows"></tbody>
            </table>

            <input type="hidden" id="meal_type_input" name="meal_type">
            <input type="hidden" id="fd-food-id">
            <button type="submit" class="btn btn-success w-100 mb-2">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>