<div class="container-fluid">
            <form class="form-edit-add" 
                action="{{ route('curso.visualizar_resultados_curso.respuesta_publica', ['categoria_id' => $curso->categoria, 'curso_id' => $curso->getID()]) }}" 
                method="GET">

                <div class="form-group  col-sm-6 col-md-3 ">
                    <label class="control-label" for="name">Periodo Lectivo</label>
                    <select id="periodos_lectivos" class="form-control select2" name="periodo_lectivo" required>
                        @foreach($periodos_collection as $periodo_index=>$periodo)
                            <option value="{{$periodo->id}}">{{$periodo->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group  col-sm-6 col-md-3 ">
                    <label class="control-label" for="name">Instrumentos</label>
                    <select id="instrumentos" class="form-control select2" name="instrumento" required>
                        @foreach($instrumentos_collection2 as $instrumento_index=>$instrumento)
                            <option value="{{$instrumento->id}}">{{$instrumento->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group  col-sm-8 col-md-4 ">
                    <label class="control-label" for="name">Seleccionar usuario</label>
                    <select id="search_users" class="js-data-example-ajax form-control select2" name="user" required>
                    </select>
                </div>
                <div class="form-group  col-sm-4 col-md-2 " style="margin-top: 15px;">
                    <button type="submit" class="btn btn-success btn-add-new">
                        <i class="voyager-plus"></i> <span>Ir</span>
                    </button>
                </div>
            </form>
        </div>