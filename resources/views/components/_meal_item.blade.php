<li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
        <strong>{{ $item->food->name }}</strong>
        <div class="small text-muted"> {{ $item->amount }} g • P:{{ $item->protein }} C:{{ $item->carbs }}
            F:{{ $item->fat }}</div>
    </div>
    <div><small class="text-muted">            {{ \Carbon\Carbon::parse($item->consumed_at)->format('d/m/Y H:i') }}
</small></div>
</li>
