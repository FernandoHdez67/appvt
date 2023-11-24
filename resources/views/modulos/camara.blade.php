@extends('principal')

@section('title',"Ayuda | Cachorro PET")

@section ('contenido')
{{ Breadcrumbs::render('ayuda') }}


<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 text-center">
            <!-- Contenedor para la vista de la cámara o la imagen capturada -->
            <div id="cameraContainer" class="rounded overflow-hidden">
                <video id="video" width="100%" height="100%" style="display: none;" autoplay></video>
                <img id="capturedImage" class="d-none" width="100%" height="100%">
            </div>
            <!-- Botón para iniciar la cámara -->
            <button class="btn btn-success mt-2" id="startCamera">Tomar foto</button>
            <!-- Botón para cambiar entre cámaras -->
            <button class="btn btn-primary mt-2 d-none" id="switchCamera">Cambiar Cámara</button>
            <!-- Botón para tomar la foto -->
            <button class="btn btn-success mt-2 d-none" id="capture">Tomar Foto</button>
        </div>
    </div>
</div>


<br><br><br><br><br><br><br><br><br><br><br>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
      const video = document.getElementById('video');
      const capturedImage = document.getElementById('capturedImage');
      const startCameraButton = document.getElementById('startCamera');
      const switchCameraButton = document.getElementById('switchCamera');
      const captureButton = document.getElementById('capture');
      const cameraContainer = document.getElementById('cameraContainer');

      let stream;

      startCameraButton.addEventListener('click', () => {
        // Ocultar el botón de iniciar y mostrar el video
        startCameraButton.style.display = 'none';
        switchCameraButton.classList.remove('d-none');
        video.style.display = 'block';

        // Obtener la transmisión de la cámara al hacer clic en el botón
        navigator.mediaDevices.getUserMedia({ video: true })
          .then((mediaStream) => {
            stream = mediaStream;
            video.srcObject = mediaStream;
            captureButton.classList.remove('d-none'); // Mostrar el botón de tomar foto
            capturedImage.classList.add('d-none'); // Ocultar la imagen capturada al iniciar la cámara
          })
          .catch((error) => {
            console.error('Error al acceder a la cámara:', error);
          });
      });

      switchCameraButton.addEventListener('click', () => {
        // Cambiar la dirección de la cámara entre frontal y trasera
        const videoConstraints = stream.getVideoTracks()[0].getConstraints();
        videoConstraints.facingMode = (videoConstraints.facingMode === 'user') ? 'environment' : 'user';

        // Detener la transmisión actual y obtener una nueva transmisión con las nuevas restricciones
        stream.getTracks().forEach(track => track.stop());
        navigator.mediaDevices.getUserMedia({ video: videoConstraints })
          .then((mediaStream) => {
            stream = mediaStream;
            video.srcObject = mediaStream;
            // Ocultar la imagen capturada al cambiar de cámara
            capturedImage.classList.add('d-none');
          })
          .catch((error) => {
            console.error('Error al cambiar la cámara:', error);
          });
      });

      captureButton.addEventListener('click', () => {
        // Capturar un cuadro de la transmisión de video y mostrar la imagen
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        capturedImage.src = canvas.toDataURL('image/png');

        // Detener la transmisión de la cámara
        stream.getTracks().forEach(track => track.stop());

        // Ocultar el video y mostrar la imagen capturada
        video.style.display = 'none';
        capturedImage.classList.remove('d-none');
        switchCameraButton.classList.add('d-none');
        captureButton.classList.add('d-none');
        startCameraButton.style.display = 'block';
      });
    });
</script>
