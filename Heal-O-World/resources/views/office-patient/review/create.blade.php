@extends('layout.menu-consultation-patient')

@section('content')
    <h2 class="section-title">Залишити відгук</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('reviews.store', ['doctor' => $doctorId]) }}">
        @csrf
        <div>
            <label for="rating">Оцінка:</label>
            <select name="rating" required>
                <option value="">Оберіть оцінку</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div>
            <label for="comment">Коментар (необов’язково):</label>
            <textarea name="comment" rows="4" cols="50" placeholder="Ваш відгук..."></textarea>
        </div>

        <button type="submit">Надіслати відгук</button>
    </form>
@endsection
