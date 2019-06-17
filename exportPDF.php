<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors','1');
    header("Content-Type: text/html; charset=utf-8",true);

    require_once('classes/experimento.class.php');
    require_once('classes/conexao.class.php');
    require('fpdf/fpdf.php');

    $conexao = new Conexao;
    $conn = $conexao->Conectar();
    $Experimento = new Experimento();
    $Experimento->conn = $conn;
    
    $type = $_REQUEST['table'];
    $expid = $_REQUEST['expid'];
    
    if($type == 'exp'){
        $pdf = new FPDF();
        $pdf->AddPage('Landscape');
        $pdf->SetFont('Arial','B',12);
    
        if ($_SESSION['s_idusuario']!='4') {
        // fetch the data
            $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.experiment.idstatusexperiment as idstatusexperiment 
            from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser
            where modelr.experiment.iduser = " . $_SESSION['s_idusuario'];
    
            $header = array('Experimento', 'Descrição', 'Status');
        }
        else {
            // fetch the data
            $sql = "select modelr.experiment.name as name, modelr.experiment.description as description, modelr.user.name as username, modelr.experiment.idstatusexperiment as idstatusexperiment 
            from modelr.experiment inner join modelr.user on modelr.experiment.iduser=modelr.user.iduser";
    
            $header = array('Experimento', 'Descrição', 'Usuário', 'Status');
        }
        
        $res = pg_exec($conn,$sql);
    
        foreach($header as $title) {
            $pdf->SetFillColor(63,83,103);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(70,12,$title,1,0,'C', true);
        }
    
        while($rows = pg_fetch_assoc($res)) {
            $pdf->SetFont('Arial','',12);
            $pdf->SetTextColor(0,0,0);
            $pdf->Ln();
           
            if($rows['idstatusexperiment'] == 1) $rows['idstatusexperiment'] = 'Aguardando';
            if($rows['idstatusexperiment'] == 2) $rows['idstatusexperiment'] = 'Liberado';
            if($rows['idstatusexperiment'] == 3) $rows['idstatusexperiment'] = 'Em processamento';
            if($rows['idstatusexperiment'] == 4) $rows['idstatusexperiment'] = 'Processado';
    
            foreach($rows as $column) {
                $pdf->Cell(70,12,$column,1);
            }
        }
    
        $pdf->Output();
    }
    else if($type == 'points'){

        class ConductPDF extends FPDF {
            function vcell($c_width,$c_height,$x_axis,$text,$align){
                $w_w=$c_height/3;
                $w_w_1=$w_w+2;
                $w_w1=$w_w+$w_w+$w_w+3;
                $len=strlen($text);// check the length of the cell and splits the text into 7 character each and saves in a array 
                if($len>16){
                    $w_text=str_split($text,16);
                    $this->SetX($x_axis);
                    $this->Cell($c_width,$w_w_1,$w_text[0],'','','');
                    $this->SetX($x_axis);
                    $this->Cell($c_width,$w_w1,$w_text[1],'','','');
                    $this->SetX($x_axis);
                    $this->Cell($c_width,$c_height,'','LTRB',0,'L',0);
                } else {
                    $this->SetX($x_axis);
                    $this->Cell($c_width,$c_height,$text,'LTRB',0,$align,0);
                }
            }
        }


            $pdf = new ConductPDF();
            $pdf->AddPage('Landscape');
            $pdf->SetFont('Arial','B',10);
            $pdf->Ln();

            $c_width=28;
            $c_height=20;

            // fetch the data
            $sql = "select idexperiment,herbario, numtombo,taxon,collector,collectnumber,statusoccurrence,country || ' - ' || majorarea || ' - ' ||  minorarea as localizacao,
            case when lat2 is not null then lat2 else lat end as lat,
            case when long2 is not null then long2
            else long end as long
            from modelr.occurrence, modelr.statusoccurrence where 
            occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
            idexperiment = ".$expid;

            $header = array('idexperimento', 'herbário', 'tombo', 'taxon','coletor','número coleta', 'status','localização', 'latitude', 'longitude');
            
            $res = pg_exec($conn,$sql);

            foreach($header as $title) {
                $pdf->SetFillColor(63,83,103);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell($c_width,$c_height,$title,1,0,'C', true);
            }
        
            while($rows = pg_fetch_assoc($res)) {
                $pdf->SetFont('Arial','',8);
                $pdf->SetTextColor(0,0,0);
                $pdf->Ln();
        
                foreach($rows as $column) {
                    $x_axis=$pdf->getx();
                    $pdf->vcell($c_width,$c_height,$x_axis,$column,'L');
                }
            }

			ob_clean();
            $pdf->Output();
    }
?>