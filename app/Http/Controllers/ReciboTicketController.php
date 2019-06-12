<?php
namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class ReciboTicketController extends Controller
{
 
    public function createRecibo(){
        $impresoraIp = '172.16.0.207';
        $impresoraPuerto = 9100;

        $conector = new NetworkPrintConnector($impresoraIp, $impresoraPuerto);
        $impresora = new Printer($conector);
        try {
            $impresora->text("titulo\n");
            $impresora->text("-----------------------\n");
            $impresora->text("cuerpo del ticket\n");
            $impresora->cut();
        } finally {
            $impresora->close();
        }
        
    }
       
}
