@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Ofensivas</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createChallengeModal">Nova ofensiva</button>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                <h6>Calendário (dias batidos)</h6>
                <!-- Simples visual: lista com datas. Para calendário real, integrar FullCalendar -->
                <div class="mt-2">
                    @foreach ($challenges as $c)
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $c->title }}</strong>
                                    <div class="small text-muted">{{ $c->start_date->format('d/m/Y') }} @if ($c->end_date)
                                            - {{ $c->end_date->format('d/m/Y') }}
                                        @endif
                                    </div>
                                    <div class="small mt-1">Dias batidos: {{ $c->logs->where('met', true)->count() }}</div>
                                </div>
                                <div><a href="{{ route('challenges.show', $c) }}" class="btn btn-sm btn-outline-primary">Ver
                                        detalhes</a></div>
                            </div>
                        </div>
                    @endforeach
                    @if ($challenges->isEmpty())
                        <div class="text-muted">Nenhuma ofensiva criada.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h6>Como funciona</h6>
                <p class="small text-muted">Crie uma ofensiva (por exemplo: \"Bater meta proteína 7 dias\"). Cada dia que
                    você atingir a meta, marque como batido. Adicione amigos para competir.</p>
            </div>
        </div>
    </div>

    <!-- Modal criar -->
    <div class="modal fade" id="createChallengeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createChallengeForm">
                    <div class="modal-header">
                        <h6 class="modal-title">Nova ofensiva</h6><button class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2"><input name="title" class="form-control"
                                placeholder="Título (ex: Proteína 7 dias)"></div>
                        <div class="mb-2">
                            <textarea name="description" class="form-control" rows="3" placeholder="Descrição (opcional)"></textarea>
                        </div>
                        <div class="mb-2"><label>Início</label><input type="date" name="start_date"
                                class="form-control"></div>
                        <div class="mb-2"><label>Fim (opcional)</label><input type="date" name="end_date"
                                class="form-control"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary">Criar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#createChallengeForm').on('submit', function(e) {
                    e.preventDefault();
                    const data = $(this).serialize();
                    $.post('/challenges', data + '&_token=' + $('meta[name="csrf-token"]').attr('content'),
                            function() {
                                location.reload();
                            })
                        .fail(xhr => alert('Erro: ' + (xhr.responseJSON?.message || '')));
                });
            });
        </script>
    @endpush
@endsection
