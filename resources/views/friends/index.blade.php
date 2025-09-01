@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Amigos</h4>
        <button class="btn btn-primary" id="openAddFriend">Adicionar amigo</button>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card p-3 card-compact">
                <h6>Seus amigos</h6>
                <ul class="list-group list-group-flush mt-2">
                    @foreach ($friends as $f)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="duo-friend">
                                <img src="{{ $f->avatar_url ?? 'https://i.pravatar.cc/40' }}" class="avatar-small me-2">
                                <div>
                                    <div class="fw-bold">{{ $f->name }}</div>
                                    <div class="small text-muted">Conectado</div>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary me-1">Desafiar</button>
                                <button class="btn btn-sm btn-outline-danger remove-friend"
                                    data-id="{{ $f->id }}">Remover</button>
                            </div>
                        </li>
                    @endforeach
                    @if ($friends->isEmpty())
                        <li class="list-group-item text-muted">Você ainda não tem amigos. Adicione para competir!</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 card-compact">
                <h6>Convidar</h6>
                <form id="inviteForm">
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control" placeholder="Email do amigo">
                    </div>
                    <button class="btn btn-success">Enviar convite</button>
                </form>
                <small class="text-muted d-block mt-2">Convites por email — o usuário receberá link para se
                    conectar.</small>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $('#inviteForm').on('submit', function(e) {
                    e.preventDefault();
                    const email = $(this).find('input[name=email]').val();
                    $.post('/friends', {
                            email,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        }, function() {
                            alert('Convite enviado');
                            location.reload();
                        })
                        .fail(xhr => alert('Erro: ' + (xhr.responseJSON?.message || '')));
                });

                $(document).on('click', '.remove-friend', function() {
                    if (!confirm('Remover amigo?')) return;
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/friends/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: () => location.reload()
                    });
                });
            });
        </script>
    @endpush
@endsection
