    <table>        
        <tbody>           
            <tr>
                <td>Cierre: {{$pv}}</td>
                <td>Fecha: {{$fecha}}</td>              
            </tr>                                                                                             
        </tbody>
    </table>
    <p>Popularidad: </p>
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
   
   <table>
        <thead>
        <tr>
            <th>Totales</th>
            <th>Cantidad</th>                
        </tr>
        </thead>
        <tbody>           
            <tr>
                <td>Total de cuentas</td>
                <td>{{$totalCuentas}}</td>              
            </tr>
            <tr>
                <td>Total de adultos</td>
                <td>{{$totalAdultos}}</td>                
            </tr>  
            <tr>
                <td>Total de niños</td>
                <td>{{$totalNinos}}</td>                               
            </tr>
            <tr>
                <td>Total Pax</td>
                <td>{{$totalPax}}</td>                               
            </tr>                                                       
        </tbody>
    </table>

            