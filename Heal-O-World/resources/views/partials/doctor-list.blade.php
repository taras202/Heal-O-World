@foreach($doctors as $doctor)
    @include('partials.doctor-card', ['doctor' => $doctor])
@endforeach

@if($doctors->isEmpty())
    <p style="text-align: center;">Лікарів не знайдено.</p>
@endif
