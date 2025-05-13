@foreach($doctors as $doctor)
    @include('components.doctor-card', ['doctor' => $doctor])
@endforeach

@if($doctors->isEmpty())
    <p style="text-align: center;">Лікарів не знайдено.</p>
@endif
