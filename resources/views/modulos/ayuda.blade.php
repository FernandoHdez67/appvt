@extends('principal')

@section('title',"Ayuda | Cachorro PET")

@section ('contenido')
{{ Breadcrumbs::render('ayuda') }}


<div class="container">
  <h5>Preguntas frecuentes</h5>
  <div class="accordion accordion-flush" id="accordionFlushExample">
      @foreach ($ayuda as $key => $value)
          <div class="accordion-item">
              <h2 class="accordion-header" id="flush-heading-{{ $key }}">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-{{ $key }}" aria-expanded="false" aria-controls="flush-collapse-{{ $key }}">
                      {{ $value->pregunta }}
                  </button>
              </h2>
              <div id="flush-collapse-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="flush-heading-{{ $key }}" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                      {!! nl2br(e($value->respuesta)) !!}
                  </div>
              </div>
          </div>
      @endforeach
  </div>

</div>

<br><br><br><br><br><br><br><br><br><br><br>
@endsection
