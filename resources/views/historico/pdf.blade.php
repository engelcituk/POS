<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    {{-- <link rel="stylesheet"  href="{{asset('css/bootstrap.min.css')}}"> --}}
    <style>
        .table {
            width: 100%;
            border: 1px solid #999999;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <table class="table table-striped">
        <thead>
        <tr style="border: 1px solid black; background-color: #5bc0de;">
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
    <p>Cuentas:</p>
    <table class="table table-striped">
        <thead>
        <tr style="border: 1px solid black; background-color: #5bc0de;">
            <th>Cuenta</th>
            <th>Folio</th>
            <th>Fecha Apertura</th>
            <th>Hora Alta</th>  
            <th>Hora Cierre</th>
            <th>Habitación</th>
            <th>Cliente</th>
            <th>Pax</th>
            <th>Total Cuenta</th>     
        </tr>
        </thead>
        <tbody>
            @foreach ($cuentas as $cuenta)
             <tr>
                <td>{{$cuenta->id}}</td>
                <td>{{$cuenta->folio}}</td>
                <td>{{$cuenta->fechaAlta}}</td>
                <td>{{$cuenta->horaAlta}}</td>
                <td>{{$cuenta->horaCierre}}</td>
                <td>{{$cuenta->habitacion}}</td>
                <td>{{$cuenta->nombreCliente}}</td>
                <td>{{$cuenta->pax}}</td>
                <td>{{$cuenta->totalCuenta}}</td>            
            </tr>                                 
            @endforeach
            
        </tbody>
    </table>
    <br>
    <p>Productos: </p>
    <table class="table table-striped">
        <thead>
        <tr style="border: 1px solid black; background-color: #5bc0de;">
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
    
</body>
</html>