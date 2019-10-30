<select class="form-control selectMesasZonas" onchange="cambiarMesa()">
    <option value="">Cambiar mesa de la cuenta</option>               
    @foreach($zonas as $zona)
    <optgroup label="{{$zona->name}}">
        @php                                
            $idZona=$zona->id;                          
            $mesas=App\Http\Controllers\OrdenController::obtenerMesasPorZona($idZona);               
        @endphp        
    </optgroup>
        @foreach($mesas as $mesa)
            <option value="{{$mesa->id}}">{{$mesa->name}}</option>            
        @endforeach                                
    @endforeach                                
</select>