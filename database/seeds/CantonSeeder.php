<?php

use Illuminate\Database\Seeder;
use App\Canton;

class CantonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Cantons = array(
          array('idCanton' => '101','idProvincia' => '1','nombreCanton' => 'SAN JOSÉ'),
          array('idCanton' => '102','idProvincia' => '1','nombreCanton' => 'ESCAZÚ'),
          array('idCanton' => '103','idProvincia' => '1','nombreCanton' => 'DESAMPARADOS'),
          array('idCanton' => '104','idProvincia' => '1','nombreCanton' => 'PURISCAL'),
          array('idCanton' => '105','idProvincia' => '1','nombreCanton' => 'TARRAZÚ'),
          array('idCanton' => '106','idProvincia' => '1','nombreCanton' => 'ASERRÍ'),
          array('idCanton' => '107','idProvincia' => '1','nombreCanton' => 'MORA'),
          array('idCanton' => '108','idProvincia' => '1','nombreCanton' => 'GOICOECHEA'),
          array('idCanton' => '109','idProvincia' => '1','nombreCanton' => 'SANTA ANA'),
          array('idCanton' => '110','idProvincia' => '1','nombreCanton' => 'ALAJUELITA'),
          array('idCanton' => '111','idProvincia' => '1','nombreCanton' => 'VASQUEZ DE CORONADO'),
          array('idCanton' => '112','idProvincia' => '1','nombreCanton' => 'ACOSTA'),
          array('idCanton' => '113','idProvincia' => '1','nombreCanton' => 'TIBÁS'),
          array('idCanton' => '114','idProvincia' => '1','nombreCanton' => 'MORAVIA'),
          array('idCanton' => '115','idProvincia' => '1','nombreCanton' => 'MONTES DE OCA'),
          array('idCanton' => '116','idProvincia' => '1','nombreCanton' => 'TURRUBARES'),
          array('idCanton' => '117','idProvincia' => '1','nombreCanton' => 'DOTA'),
          array('idCanton' => '118','idProvincia' => '1','nombreCanton' => 'CURRIDABAT'),
          array('idCanton' => '119','idProvincia' => '1','nombreCanton' => 'PÉREZ ZELEDÓN'),
          array('idCanton' => '120','idProvincia' => '1','nombreCanton' => 'LEÓN CORTÉS'),
          array('idCanton' => '201','idProvincia' => '2','nombreCanton' => 'ALAJUELA'),
          array('idCanton' => '202','idProvincia' => '2','nombreCanton' => 'SAN RAMÓN'),
          array('idCanton' => '203','idProvincia' => '2','nombreCanton' => 'GRECIA'),
          array('idCanton' => '204','idProvincia' => '2','nombreCanton' => 'SAN MATEO'),
          array('idCanton' => '205','idProvincia' => '2','nombreCanton' => 'ATENAS'),
          array('idCanton' => '206','idProvincia' => '2','nombreCanton' => 'NARANJO'),
          array('idCanton' => '207','idProvincia' => '2','nombreCanton' => 'PALMARES'),
          array('idCanton' => '208','idProvincia' => '2','nombreCanton' => 'POÁS'),
          array('idCanton' => '209','idProvincia' => '2','nombreCanton' => 'OROTINA'),
          array('idCanton' => '210','idProvincia' => '2','nombreCanton' => 'SAN CARLOS'),
          array('idCanton' => '211','idProvincia' => '2','nombreCanton' => 'ALFARO RUIZ'),
          array('idCanton' => '212','idProvincia' => '2','nombreCanton' => 'VALVERDE VEGA'),
          array('idCanton' => '213','idProvincia' => '2','nombreCanton' => 'UPALA'),
          array('idCanton' => '214','idProvincia' => '2','nombreCanton' => 'LOS CHILES'),
          array('idCanton' => '215','idProvincia' => '2','nombreCanton' => 'GUATUSO'),
          array('idCanton' => '301','idProvincia' => '4','nombreCanton' => 'CARTAGO'),
          array('idCanton' => '302','idProvincia' => '4','nombreCanton' => 'PARAÍSO'),
          array('idCanton' => '303','idProvincia' => '4','nombreCanton' => 'LA UNIÓN'),
          array('idCanton' => '304','idProvincia' => '4','nombreCanton' => 'JIMÉNEZ'),
          array('idCanton' => '305','idProvincia' => '4','nombreCanton' => 'TURRIALBA'),
          array('idCanton' => '306','idProvincia' => '4','nombreCanton' => 'ALVARADO'),
          array('idCanton' => '307','idProvincia' => '4','nombreCanton' => 'OREAMUNO'),
          array('idCanton' => '308','idProvincia' => '4','nombreCanton' => 'EL GUARCO'),
          array('idCanton' => '401','idProvincia' => '3','nombreCanton' => 'HEREDIA'),
          array('idCanton' => '402','idProvincia' => '3','nombreCanton' => 'BARVA'),
          array('idCanton' => '403','idProvincia' => '3','nombreCanton' => 'SANTO DOMINGO'),
          array('idCanton' => '404','idProvincia' => '3','nombreCanton' => 'SANTA BÁRBARA'),
          array('idCanton' => '405','idProvincia' => '3','nombreCanton' => 'SAN RAFAEL'),
          array('idCanton' => '406','idProvincia' => '3','nombreCanton' => 'SAN ISIDRO'),
          array('idCanton' => '407','idProvincia' => '3','nombreCanton' => 'BELÉN'),
          array('idCanton' => '408','idProvincia' => '3','nombreCanton' => 'FLORES'),
          array('idCanton' => '409','idProvincia' => '3','nombreCanton' => 'SAN PABLO'),
          array('idCanton' => '410','idProvincia' => '3','nombreCanton' => 'SARAPIQUÍ '),
          array('idCanton' => '501','idProvincia' => '6','nombreCanton' => 'LIBERIA'),
          array('idCanton' => '502','idProvincia' => '6','nombreCanton' => 'NICOYA'),
          array('idCanton' => '503','idProvincia' => '6','nombreCanton' => 'SANTA CRUZ'),
          array('idCanton' => '504','idProvincia' => '6','nombreCanton' => 'BAGACES'),
          array('idCanton' => '505','idProvincia' => '6','nombreCanton' => 'CARRILLO'),
          array('idCanton' => '506','idProvincia' => '6','nombreCanton' => 'CAÑAS'),
          array('idCanton' => '507','idProvincia' => '6','nombreCanton' => 'ABANGARES'),
          array('idCanton' => '508','idProvincia' => '6','nombreCanton' => 'TILARÁN'),
          array('idCanton' => '509','idProvincia' => '6','nombreCanton' => 'NANDAYURE'),
          array('idCanton' => '510','idProvincia' => '6','nombreCanton' => 'LA CRUZ'),
          array('idCanton' => '511','idProvincia' => '6','nombreCanton' => 'HOJANCHA'),
          array('idCanton' => '601','idProvincia' => '5','nombreCanton' => 'PUNTARENAS'),
          array('idCanton' => '602','idProvincia' => '5','nombreCanton' => 'ESPARZA'),
          array('idCanton' => '603','idProvincia' => '5','nombreCanton' => 'BUENOS AIRES'),
          array('idCanton' => '604','idProvincia' => '5','nombreCanton' => 'MONTES DE ORO'),
          array('idCanton' => '605','idProvincia' => '5','nombreCanton' => 'OSA'),
          array('idCanton' => '606','idProvincia' => '5','nombreCanton' => 'AGUIRRE'),
          array('idCanton' => '607','idProvincia' => '5','nombreCanton' => 'GOLFITO'),
          array('idCanton' => '608','idProvincia' => '5','nombreCanton' => 'COTO BRUS'),
          array('idCanton' => '609','idProvincia' => '5','nombreCanton' => 'PARRITA'),
          array('idCanton' => '610','idProvincia' => '5','nombreCanton' => 'CORREDORES'),
          array('idCanton' => '611','idProvincia' => '5','nombreCanton' => 'GARABITO'),
          array('idCanton' => '701','idProvincia' => '7','nombreCanton' => 'LIMÓN'),
          array('idCanton' => '702','idProvincia' => '7','nombreCanton' => 'POCOCÍ'),
          array('idCanton' => '703','idProvincia' => '7','nombreCanton' => 'SIQUIRRES '),
          array('idCanton' => '704','idProvincia' => '7','nombreCanton' => 'TALAMANCA'),
          array('idCanton' => '705','idProvincia' => '7','nombreCanton' => 'MATINA'),
          array('idCanton' => '706','idProvincia' => '7','nombreCanton' => 'GUÁCIMO')
        );
        
        foreach ($Cantons as $canton) {
            Canton::create ([
                'id'=> $canton['idCanton'],
                'name'=> $canton['nombreCanton'],
                'id_province' => $canton['idProvincia'],
            ]);
        }
    }
}
