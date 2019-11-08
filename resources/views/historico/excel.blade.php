  <table>
        <thead>
        <tr>
            <th>Total de cuentas</th>
            <th>Total de adultos</th>
            <th>Total de Niños</th>
            <th>Total Pax</th>       
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$totalAdultos}}</td>
            <td>{{$totalCuentas}}</td>
            <td>{{$totalNinos}}</td>
            <td>{{$totalPax}}</td>
        </tr>      
        </tbody>
    </table>    
    <br>
    <p>Productos: </p>
    <table>
        <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>                
        </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
             <tr>
                <td>{{$producto->producto}}</td>
                <td>{{$producto->count}}</td>                
            </tr>                                 
            @endforeach
            
        </tbody>
    </table>
