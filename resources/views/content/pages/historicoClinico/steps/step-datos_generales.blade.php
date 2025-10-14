{{-- Paso para registrar datos generales --}}
<div id="step-datos_generales" class="content">
  <div class="content-header mb-3">
    <h6 class="mb-0"><span class="mdi mdi-chart-arc me-2"></span>Datos generales</h6>
    <small>Los datos marcados con<i class="text-danger">*</i> son obligatorios</small>
  </div>

  <div class="row">

    {{-- Id del usuario que lo elaboro --}}
    <input type="hidden" id="historico_clinico-elaborado_por_usuario_id" name="historico_clinico[elaborado_por_usuario_id]"
      value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['elaborado_por_usuario_id'] != '') ? $datos_vista['historico_clinico'][0]['elaborado_por_usuario_id'] : Auth::user()->id }}" >

    {{-- CURP --}}
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-curp" name="historico_clinico[curp]" placeholder="Ingresa el CURP"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['curp'] != '') ? $datos_vista['historico_clinico'][0]['curp'] : '' }}" />
        <label for="">CURP <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Fecha de nacimiento --}}
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="date" class="form-control campo_visualizar" id="historico_clinico-fecha_nacimiento" name="historico_clinico[fecha_nacimiento]" placeholder="Ingresa la fecha de nacimiento"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['fecha_nacimiento'] != '') ? $datos_vista['historico_clinico'][0]['fecha_nacimiento'] : '' }}" />
        <label for="">Fecha de nacimiento <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Edad --}}
    <div class="col-md-6 col-lg-2 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="number" class="form-control campo_visualizar" id="historico_clinico-edad" name="historico_clinico[edad]" placeholder="Ingresa la edad" min="10" max="100"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['edad'] != '') ? $datos_vista['historico_clinico'][0]['edad'] : '' }}" />
        <label for="">Edad <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Numero de telefono --}}
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="form-floating form-floating-outline">
        <input class="form-control campo_visualizar" id="historico_clinico-celular" name="historico_clinico[celular]" type="tel" placeholder="Ingresa un número celular"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['celular'] != '') ? $datos_vista['historico_clinico'][0]['celular'] : '' }}" />
        <label for="paciente-celular">Número Celular</label>
      </div>
    </div>

  </div>

  <div class="row">

    {{-- Nombre(s) --}}
    <div class="col-md-12 col-lg-4 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-nombre" name="historico_clinico[nombre]" placeholder="Ingresa el/los nombre(s)"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['nombre'] != '') ? $datos_vista['historico_clinico'][0]['nombre'] : '' }}" />
        <label for="">Nombre(s) <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Apellido paterno --}}
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-apellido_paterno" name="historico_clinico[apellido_paterno]" placeholder="Ingresa el apellido paterno"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['apellido_paterno'] != '') ? $datos_vista['historico_clinico'][0]['apellido_paterno'] : '' }}" />
        <label for="">Apellido Paterno <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Apellido materno --}}
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-apellido_materno" name="historico_clinico[apellido_materno]" placeholder="Ingresa el apellido materno"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['apellido_materno'] != '') ? $datos_vista['historico_clinico'][0]['apellido_materno'] : '' }}" />
        <label for="">Apellido materno <i class="text-danger">*</i></label>
      </div>
    </div>

  </div>

  <div class="row">

    {{-- Genero --}}
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="form-floating form-floating-outline">
        <select class="form-select select2 campo_visualizar" id="historico_clinico-genero" name="historico_clinico[genero]" placeholder="Ingresa el genero" onchange="seccionSeleccionGeneroMujer()">
          <option value="" disabled {{ !isset($datos_vista['historico_clinico'][0]['genero']) ? 'selected' : '' }}>Selecciona una opción</option>
          <option value="M" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['genero'] == 'M') ? 'selected' : '' }}>Hombre</option>
          <option value="F" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['genero'] == 'F') ? 'selected' : '' }}>Mujer</option>
        </select>
        <label for="">Género <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Estado civil --}}
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-estado_civil" name="historico_clinico[estado_civil]" placeholder="Ingresa el estado civil"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['estado_civil'] != '') ? $datos_vista['historico_clinico'][0]['estado_civil'] : '' }}" />
        <label for="">Estado civil <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Hijos --}}
    <div class="col-md-6 col-lg-2 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="number" class="form-control campo_visualizar" id="historico_clinico-hijos" name="historico_clinico[hijos]" placeholder="Ingresa la cantidad de hijos" min="0" max="30"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['hijos'] != '') ? $datos_vista['historico_clinico'][0]['hijos'] : '' }}" />
        <label for="">Hijos <i class="text-danger">*</i></label>
      </div>
    </div>

    {{-- Tipo de sangre --}}
    <div class="col-md-6 col-lg-3 mb-4">
      <div class="form-floating form-floating-outline">
        <select class="form-select select2 campo_visualizar" id="historico_clinico-grupo_sanguineo" name="historico_clinico[grupo_sanguineo]" placeholder="Ingresa el grupo sanguineo">
          <option value="" disabled {{ !isset($datos_vista['historico_clinico'][0]['grupo_sanguineo']) ? 'selected' : '' }}>Selecciona una opción</option>
            <option value="A+" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'A+') ? 'selected' : '' }}>A+</option>
            <option value="A-" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'A-') ? 'selected' : '' }}>A-</option>
            <option value="B+" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'B+') ? 'selected' : '' }}>B+</option>
            <option value="B-" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'B-') ? 'selected' : '' }}>B-</option>
            <option value="AB+" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'AB+') ? 'selected' : '' }}>AB+</option>
            <option value="AB-" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'AB-') ? 'selected' : '' }}>AB-</option>
            <option value="O+" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == '0+') ? 'selected' : '' }}>O+</option>
            <option value="O-" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'O-') ? 'selected' : '' }}>O-</option>
            <option value="Desconocido" {{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['grupo_sanguineo'] == 'Desconocido') ? 'selected' : '' }}>Desconocido</option>
        </select>
        <label for="">G. sanguíneo y F. RH <i class="text-danger">*</i></label>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-md-6 col-lg-7 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-escolaridad" name="historico_clinico[escolaridad]" placeholder="Ingresa la escolaridad"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['escolaridad'] != '') ? $datos_vista['historico_clinico'][0]['escolaridad'] : '' }}" />
        <label for="">Escolaridad <i class="text-danger">*</i></label>
      </div>
    </div>
    <div class="col-md-6 col-lg-5 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-profesion_oficio" name="historico_clinico[profesion_oficio]" placeholder="Ingresa la profesion o oficio"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['profesion_oficio'] != '') ? $datos_vista['historico_clinico'][0]['profesion_oficio'] : '' }}" />
        <label for="">Profesión/Oficio</label>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 mb-4">
      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control campo_visualizar" id="historico_clinico-domicilio" name="historico_clinico[domicilio]" placeholder="Ingresa el domicilio"
          value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['domicilio'] != '') ? $datos_vista['historico_clinico'][0]['domicilio'] : '' }}" />
        <label for="">Domicilio</label>
      </div>
    </div>
  </div>

  {{-- Apartado que solo aparece cuando el genero es mujer --}}
  <div class="card shadow-none bg-label-secondary p-3 mb-3" style="display: none;" id="antecedente_gineObstetricos">

    <h6 class="mb-4"><i class="mdi mdi-human-female-female me-2"></i></span>Antecedentes Gineco-obstetricos:</h6>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-menarca" name="historico_clinico_gineco_obstetricos[menarca]" placeholder="Ingresa menarca"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['menarca'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['menarca'] : '' }}" />
          <label for="">Menarca <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-fur" name="historico_clinico_gineco_obstetricos[fur]" placeholder="Ingresa F.U.R."
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['fur'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['fur'] : '' }}"/>
          <label for="">F.U.R. <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-ritmo" name="historico_clinico_gineco_obstetricos[ritmo]" placeholder="Ingresa ritmo"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['ritmo'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['ritmo'] : '' }}"/>
          <label for="">Ritmo <i class="text-danger">*</i></label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-ivsa" name="historico_clinico_gineco_obstetricos[ivsa]" placeholder="Ingresa I.V.S.A."
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['ivsa'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['ivsa'] : '' }}"/>
          <label for="">I.V.S.A. <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="number" min="0" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-gesta" name="historico_clinico_gineco_obstetricos[gesta]" placeholder="Ingresa gesta"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['gesta'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['gesta'] : '' }}"/>
          <label for="">Gesta <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="number" min="0" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-partos" name="historico_clinico_gineco_obstetricos[partos]" placeholder="Ingresa partos"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['partos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['partos'] : '' }}"/>
          <label for="">Partos <i class="text-danger">*</i></label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-doc" name="historico_clinico_gineco_obstetricos[doc]" placeholder="Ingresa D.O.C."
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['doc'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['doc'] : '' }}"/>
          <label for="">D.O.C. <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="number" min="0" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-cesareas" name="historico_clinico_gineco_obstetricos[cesareas]" placeholder="Ingresa cesáreas"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['cesareas'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['cesareas'] : '' }}"/>
          <label for="">Cesáreas <i class="text-danger">*</i></label>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="number" min="0" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-abortos" name="historico_clinico_gineco_obstetricos[abortos]" placeholder="Ingresa abortos"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['abortos'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['abortos'] : '' }}"/>
          <label for="">Abortos <i class="text-danger">*</i></label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control campo_visualizar" id="historico_clinico_gineco_obstetricos-anticonceptivo" name="historico_clinico_gineco_obstetricos[anticonceptivo]" placeholder="Ingresa metodo anticonceptivo"
            value="{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['anticonceptivo'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['anticonceptivo'] : '' }}"/>
          <label for="">Metodo anticonceptivo <i class="text-danger">*</i></label>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="form-floating form-floating-outline">
          <textarea class="form-control campo_visualizar h-px-100" id="historico_clinico_gineco_obstetricos-otros" name="historico_clinico_gineco_obstetricos[otros]" placeholder="Escribe otros...">{{ (isset($datos_vista['historico_clinico']) && $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['otros'] != '') ? $datos_vista['historico_clinico'][0]['historico_clinico_gineco_obstetricos'][0]['otros'] : '' }}</textarea>
          <label for="">Otros:</label>
        </div>
      </div>
    </div>

  </div>

  <div class="col-12 d-flex justify-content-between">
    <button class="btn btn-outline-secondary btn-prev" disabled> <i class="icon-base ri ri-arrow-left-line icon-sm scaleX-n1-rtl me-sm-1 me-0"></i>
      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
    </button>
    <button class="btn btn-primary btn-next" id="boton-siguiente-datos_generales"><span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span> <i class="icon-base ri ri-arrow-right-line icon-sm"></i></button>
  </div>
</div>
