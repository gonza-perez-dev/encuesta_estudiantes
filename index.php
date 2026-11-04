<?php
session_start();
require_once __DIR__ . '/includes/funciones.php';
$mensaje = $_SESSION['mensaje_exito'] ?? '';
unset($_SESSION['mensaje_exito']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Encuesta de estudiantes - Educación Superior</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

<header class="encabezado">
  <div class="container py-4">
    <span class="etiqueta">DIRECCIÓN DE EDUCACIÓN SUPERIOR</span>
    <h1 class="h2 mt-2 mb-2">Encuesta para estudiantes ISFD / ISFT</h1>
    <p class="mb-0">Caracterización psicosocial de la población estudiantil de los Institutos de Educación Superior de la Provincia de San Juan.</p>
  </div>
</header>

<main class="container my-4 my-lg-5">

  <?php if ($mensaje): ?>
    <div class="alert alert-success"><?= e($mensaje) ?></div>
  <?php endif; ?>

  <div class="aviso mb-4">
    <strong>Antes de comenzar:</strong> esta encuesta solicita tu correo electrónico y carrera. Tus respuestas serán tratadas de manera confidencial y utilizadas para caracterizar las trayectorias estudiantiles.
    <div class="small text-secondary mt-2">Completá todas las preguntas y presioná «Enviar encuesta» al finalizar.</div>
  </div>

  <form action="guardar.php" method="POST" class="formulario">
    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token'] = bin2hex(random_bytes(32))) ?>">

    <section class="seccion">
      <div class="numero">A</div>
      <div class="flex-grow-1">

        <h2>Institución de pertenencia y Carrera</h2>

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label" for="institucion">¿A qué institución pertenecés? <span class="text-danger">*</span></label>
            <select class="form-select" id="institucion" name="institucion" required>
              <option value="">Seleccioná una institución...</option>
              <?= opciones([
                'ISFD ESCUELA NORMAL SUPERIOR "GRAL. SAN MARTÍN"',
                'ISFT DE BIBLIOTECOLOGÍA "DR. MARIANO MORENO"',
                'ISFD ESCUELA NORMAL SUP. "GRAL. MANUEL BELGRANO" (Formación Docente)',
                'ISFT ESCUELA NORMAL SUP. "GRAL. MANUEL BELGRANO" (Formación Técnica)'
              ]) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label" for="carrera">¿Cuál es tu carrera? <span class="text-danger">*</span></label>
            <select class="form-select" id="carrera" name="carrera" required>
              <option value="">Seleccioná primero una institución...</option>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label" for="email">Correo electrónico <span class="text-danger">*</span></label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              maxlength="150"
              placeholder="ejemplo@correo.com"
              autocomplete="email"
              required
            >
          </div>

        </div>
      </div>
    </section>

    <section class="seccion">
      <div class="numero">B</div>
      <div class="flex-grow-1">

        <h2>Variables de caracterización personal y familiar</h2>

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label">1. Edad *</label>
            <select class="form-select" name="edad" required>
              <?= opciones(['17 a 19','20 a 25','26 a 30','31 a 35','36 a 40','41 o más']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">2. Género *</label>
            <select class="form-select" name="genero" required>
              <?= opciones(['Femenino','Masculino','Otro']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">3. Departamento de residencia *</label>
            <select class="form-select" name="departamento" required>
              <?= opciones(['Albardón','Angaco','Calingasta','Capital','Caucete','Chimbas','Iglesia','Jáchal','9 de Julio','Pocito','Rawson','Rivadavia','San Martín','Santa Lucía','Sarmiento','Ullum','Valle Fértil','25 de Mayo','Zonda']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">4. ¿Con quiénes vivís? *</label>
            <select class="form-select" name="convivencia" required>
              <?= opciones(['Solo/a','Con pareja solamente','Con pareja e hijos','Con padres y/o hijos y/u otros familiares']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">5. ¿Tenés personas a tu cargo? *</label>
            <select class="form-select" name="personas_cargo" required>
              <?= opciones(['0','1','2','3','4 o más']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">6. ¿Cuál es la distancia aproximada desde tu domicilio hasta la institución educativa? *</label>
            <select class="form-select" name="distancia" required>
              <?= opciones(['Hasta 5 km','De 5 a 10 km','Más de 10 km']) ?>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">7. ¿Qué medio de transporte utilizás para trasladarte hacia la institución? *</label>
            <select class="form-select" name="transporte" required>
              <?= opciones(['Transporte público (colectivo)','Vehículo particular motorizado (Auto/Moto)','A pie o Bicicleta','Otro']) ?>
            </select>
          </div>

        </div>
      </div>
    </section>

    <section class="seccion">
      <div class="numero">C</div>
      <div class="flex-grow-1">

        <h2>Situación laboral</h2>

        <div class="row g-3">

          <div class="col-md-6">
            <label class="form-label">1. ¿Trabajás actualmente? (principal) *</label>
            <select class="form-select" name="situacion_laboral" required>
              <?= opciones(['No trabajo','Trabajo medio día','Trabajo a tiempo completo','Trabajo los fines de semana','Trabajo ocasional o eventual']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">2. ¿Cuál es tu relación laboral? *</label>
            <select class="form-select" name="relacion_laboral" required>
              <?= opciones(['Tengo un trabajo en relación de dependencia (en blanco)','Tengo un trabajo en relación de dependencia (en negro)','Trabajo por mi cuenta (autónomo)']) ?>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">3. ¿Contás con ayuda social para tu sustento académico (por ejemplo: beca Progresar)? *</label>
            <select class="form-select" name="ayuda_social" required>
              <?= opciones(['Sí','No']) ?>
            </select>
          </div>

        </div>
      </div>
    </section>

    <section class="seccion">
      <div class="numero">D</div>
      <div class="flex-grow-1">

        <h2>Trayectoria académica</h2>

        <div class="row g-3">

          <div class="col-md-12">
            <label class="form-label">1. En tu trayectoria académica, ¿se presentó alguna de las siguientes situaciones? *</label>
            <select class="form-select" name="trayectoria_previa" required>
              <?= opciones(['Estudió otra carrera de nivel superior pero no la culminó','Estudió otra carrera de nivel superior y la culminó','Es la primera carrera de nivel superior','Realizó capacitación laboral de oficios']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">2. ¿Viste interrumpida la continuidad de tu trayectoria académica? *</label>
            <select class="form-select" name="interrupcion" required>
              <?= opciones(['0 a 2 años','2 a 5 años','5 a 10 años','Nunca']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">3. ¿Considerás que tu actividad laboral afecta tu desempeño académico? *</label>
            <select class="form-select" name="impacto_laboral" required>
              <?= opciones(['Mucho','Poco','No afecta','No tengo']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">4. ¿Considerás que tus responsabilidades familiares afectan tu desempeño académico? *</label>
            <select class="form-select" name="impacto_familiar" required>
              <?= opciones(['Mucho','Poco','No afecta','No tengo']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">5. ¿Cuál considerás que es tu porcentaje de asistencia a clases en un cuatrimestre? *</label>
            <select class="form-select" name="asistencia" required>
              <?= opciones(['100%','75%','50%','25%','Menos del 25%']) ?>
            </select>
          </div>

          <div class="col-md-12">
            <label class="form-label">6. ¿Cuál considerás que es el principal factor que te impide asistir regularmente a clases? *</label>
            <select class="form-select" name="factor_inasistencia" required>
              <?= opciones(['Responsabilidades familiares','Problemas de salud propios','Problemas de salud de un familiar o persona a cargo','Responsabilidades laborales','Factores económicos: falta de recursos materiales de estudio','Motivación y clima institucional','Problemas de transporte: distancias largas, falta de transporte público eficiente o vías de acceso en mal estado','Ninguno']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">7. ¿Llegás tarde al cursado o debés retirarte antes de que finalice el horario correspondiente? *</label>
            <select class="form-select" name="puntualidad" required>
              <?= opciones(['Nunca','Ocasionalmente','Seguido','Siempre']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">8. ¿Con qué dispositivos tecnológicos contás para cumplir con las actividades académicas? Marcá el más utilizado. *</label>
            <select class="form-select" name="dispositivo" required>
              <?= opciones(['PC o Notebook','Tablet','Teléfono celular propio','Ninguno']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">9. El dispositivo tecnológico que utilizás, ¿es...? *</label>
            <select class="form-select" name="propiedad_dispositivo" required>
              <?= opciones(['Propio','Compartido','Ninguno']) ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label">10. ¿Qué tipo de conexión a internet utilizás habitualmente para realizar las actividades académicas en tu hogar? *</label>
            <select class="form-select" name="conexion_internet" required>
              <?= opciones(['Wifi y datos móviles','Solo Wifi','Solo datos móviles','Ninguna']) ?>
            </select>
          </div>

        </div>
      </div>
    </section>

    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mt-4">

      <small class="text-secondary">Los campos marcados con * son obligatorios.</small>

      <button class="btn btn-primary btn-lg px-5" type="submit">
        Enviar encuesta
      </button>

    </div>

  </form>

  <p class="text-center text-secondary small mt-4">
    Encuesta de caracterización estudiantil · Educación Superior · San Juan
  </p>

</main>

<script>
  // Mapeo de carreras por institución (puedes ajustar los nombres exactos según las que mandó el profesor)
  const carrerasPorInstitucion = {
    'ISFD ESCUELA NORMAL SUPERIOR "GRAL. SAN MARTÍN"': [
      'Profesorado de Educación Inicial',
      'Profesorado de Educación Primaria',
      'Profesorado de Educación Especial',
      'Profesorado en Matemática',
      'Profesorado en Lengua y Literatura'
    ],
    'ISFT DE BIBLIOTECOLOGÍA "DR. MARIANO MORENO"': [
      'Tecnicatura Superior en Bibliotecología',
      'Tecnicatura Superior en Gestión de Documentación e Información'
    ],
    'ISFD ESCUELA NORMAL SUP. "GRAL. MANUEL BELGRANO" (Formación Docente)': [
      'Profesorado de Educación Física',
      'Profesorado en Historia',
      'Profesorado en Geografía'
    ],
    'ISFT ESCUELA NORMAL SUP. "GRAL. MANUEL BELGRANO" (Formación Técnica)': [
      'Tecnicatura Superior en Administración de Empresas',
      'Tecnicatura Superior en Análisis de Sistemas',
      'Tecnicatura Superior en Mantenimiento Industrial'
    ]
  };

  document.getElementById('institucion').addEventListener('change', function() {
    const institucionSeleccionada = this.value;
    const selectCarrera = document.getElementById('carrera');
    
    // Limpiar opciones anteriores
    selectCarrera.innerHTML = '<option value="">Seleccioná una carrera...</option>';
    
    if (institucionSeleccionada && carrerasPorInstitucion[institucionSeleccionada]) {
      carrerasPorInstitucion[institucionSeleccionada].forEach(function(carrera) {
        const option = document.createElement('option');
        option.value = carrera;
        option.textContent = carrera;
        selectCarrera.appendChild(option);
      });
    }
  });
</script>

</body>
</html>