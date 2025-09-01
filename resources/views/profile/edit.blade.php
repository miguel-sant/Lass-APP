@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Meu Perfil / Metas</h4>
    </div>

    <div class="card p-3">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Objetivo</label>
                    <select name="goal" class="form-select">
                        <option value="gain" @if ($profile->goal === 'gain') selected @endif>Ganho de massa</option>
                        <option value="lose" @if ($profile->goal === 'lose') selected @endif>Perda de peso</option>
                        <option value="maintain" @if ($profile->goal === 'maintain') selected @endif>Manutenção</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.1" name="weight" class="form-control"
                        value="{{ old('weight', $profile->weight ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Altura (cm)</label>
                    <input type="number" name="height" class="form-control"
                        value="{{ old('height', $profile->height ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Nível de atividade</label>
                    <select name="activity_level" class="form-select">
                        <option value="1.2" @if (($profile->activity_level ?? '') == '1.2') selected @endif>Sedentário</option>
                        <option value="1.375" @if (($profile->activity_level ?? '') == '1.375') selected @endif>Leve</option>
                        <option value="1.55" @if (($profile->activity_level ?? '') == '1.55') selected @endif>Moderado</option>
                        <option value="1.725" @if (($profile->activity_level ?? '') == '1.725') selected @endif>Intenso</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Calorias alvo (opcional)</label>
                    <input name="daily_calories_target" type="number" class="form-control"
                        value="{{ old('daily_calories_target', $profile->daily_calories_target ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Proteína alvo (g)</label>
                    <input name="daily_protein_target" type="number" class="form-control"
                        value="{{ old('daily_protein_target', $profile->daily_protein_target ?? '') }}">
                </div>

                <div class="col-12 mt-3">
                    <button class="btn btn-primary">Salvar</button>
                    <small class="text-muted ms-2">Se deixar em branco, o sistema usará cálculo automático (TMB +
                        atividade)</small>
                </div>
            </div>
        </form>
    </div>
@endsection
