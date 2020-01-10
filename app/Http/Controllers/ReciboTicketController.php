<?php
namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Illuminate\Http\Request;

class ReciboTicketController extends Controller
{
 
    public function createRecibo(Request $request){
        $impresoraIp = '172.16.0.207';
        $impresoraPuerto = 9100;
        $contenidoTicket = $request->get('contenidoTicket');

        $conector = new NetworkPrintConnector($impresoraIp, $impresoraPuerto);
        $impresora = new Printer($conector);
        try {
            $impresora->text("titulo\n");
            $impresora->text("-----------------------\n");
            $impresora->text("cuerpo del ticket\n");
            $impresora->cut(); 
            $impresora->text("\n");

        } finally {
            $impresora->close();
        }
        
    }
    //
    public function imprimirRecibo(Request $request){
        $contenidoTicket = $request->get('contenidoTicket');
        
        $smb='smb://';
        $maquinaImpresora = $request->get('maquinaImpresora');
        $initialCode = $request->get('initialCode');


        $profile = CapabilityProfile::load("simple");

        $connector = new WindowsPrintConnector($smb.$maquinaImpresora);
        $impresora = new Printer($connector, $profile);

        // $bytes = array(0x1d, 0x56, 0x00);// array de bits para en teoria cortar cadena
        // $string = implode(array_map("chr", $bytes));
        
        try {
            $impresora->text($initialCode);
            $impresora->text($contenidoTicket);
            // $impresora->text("titulo\n");
            // $impresora->text("-----------------------\n");
            $impresora->text("\n");
            // $impresora->text($string);
            $impresora->cut(); 

        } finally {
            $impresora->close();
        }
        
    }
    public function imprimirRecibo2(Request $request){
        $contenidoTicket = $request->get('contenidoTicket');
                
        $maquinaImpresora = $request->get('maquinaImpresora');
              
        return $contenidoTicket." ". $maquinaImpresora;

    }
    public function imprimirReciboTest(Request $request){
                        
        $profile = CapabilityProfile::load("simple");

        $connector = new WindowsPrintConnector("smb://SC-GTE-FUNDACIO/Impresora-Tickets");
        $impresora = new Printer($connector, $profile);

        try {            
            $impresora->text("titulo\n");
            $impresora->text("-----------------------\n");
            $impresora->text("cuerpo del ticket\n");
            $impresora->cut();            
        } finally {
            $impresora->close();
        }
        
    }
    // 172.16.4.229
}
