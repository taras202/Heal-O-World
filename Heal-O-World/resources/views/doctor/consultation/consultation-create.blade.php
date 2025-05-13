@extends('layout.menu-consultation-doctor')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Додати годину консультації</h5>
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="card-body">
        @if($errors->any())
    <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


            <form action="{{ route('work-schedule.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Дата:</label>
                    <input type="date" name="appointment_date" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="consultation_time" class="form-label">Час:</label>
                    <input type="time" name="consultation_time" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Додати в розклад
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Ваш графік консультацій</h5>
        </div>
        <div class="card-body">
            @if($schedules->count())
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Час</th>
                            <th>Дія</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($schedule->appointment_date)->format('d.m.Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->consultation_time)->format('H:i') }}</td>
                                <td>
                                    <form action="{{ route('work-schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Справді видалити цю годину консультації?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3"></i> Видалити
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $schedules->links() }}
            @else
                <p class="text-muted">Поки що немає годин у розкладі.</p>
            @endif
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
