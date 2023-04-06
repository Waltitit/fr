<?php

$fine = 'check';
(@require_once './web/init.php') or die("You not have permisions");
if (!defined('ELGHO3T_AB_ROOT')) {die("You not have permisions");}
if (!isset($_SERVER['HTTP_USER_AGENT'])){die("You not have permisions");}
$tool = new Tools();

if(GHOST_SECURE == true):
    // echo "active boot";
    if(GHOST_CONSTRICT == true):
        if($tool->Add_Block() == true):
            $tool->visiteur("<font color='red'>False</font>",["isp" => "constr","org" => "constr","country" => $tool->get_client_country()],"constrict mode");
            // echo "mode construction 404";
            $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
            // header("HTTP/1.1 404 Not Found");
            exit();
        endif;
    endif;
    

    if($tool->Check_User_limet() !== true):
        if(isset($_SESSION) && isset($_SESSION['data_info'])):
            // echo $tool->get_client_ip();
            
    
            if($tool->check_validate($_SESSION["data_info"]) == true):
                // echo "from validate success valid info data";
                if($tool->Add_User() == true):
                    // echo "adding user from session hena acces scam valid => success";
                    $rowid = $_SESSION['bid'] = $tool->rowsid(16);
                    $tool->visiteur("<font color='green'>True</font>",$_SESSION["data_info"],"Validate true success");
                    $tool->go_to( PATCH . "/index.php?evola=noobs&id=".$rowid );
                    exit();
                endif;
            else:
                if($tool->Add_Block() == true):
                    $tool->visiteur("<font color='red'>False</font>",$_SESSION["data_info"],"Validate Error");
                    // echo "from fi session block becausse no validate isp org";
                    // header("HTTP/1.1 404 Not Found");
                    $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
                    exit();
                endif;
            endif;
            
        else:
            // echo "no session makynach dyal data info";
            $data_info =  $tool->grabinfos($tool->ip);
            if($data_info):
                if($tool->check_validate($data_info) == true):
                    if($tool->Add_User() == true):
                        // echo "from create session valid data info hena access scam valid => success from new session";
                        $rowid = $_SESSION['bid'] = $tool->rowsid(16);
                        $tool->visiteur("<font color='green'>True</font>",$data_info,"success allow valid");
                        $tool->go_to( PATCH . "/index.php?evola=noobs&id=".$rowid );
                        exit();
                
                    endif;
                    
                else:
                    
                    if($tool->Add_Block() == true):
                        $tool->visiteur("<font color='red'>False</font>",$data_info,"Validate");
                        // echo "from no valid osp orag from create session";
                        // header("HTTP/1.1 404 Not Found");
                        $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
                        exit();
                    endif;
                endif;
            endif;
    
    
        endif;
    else:
        // echo "block sf limet";
        if($tool->Add_Block() == true):
            $tool->visiteur("<font color='red'>False</font>",["isp" => "limet","org" => "limet","country" => $tool->get_client_country()],"limet");
            // header("HTTP/1.1 404 Not Found");
            $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
            exit();
        endif;
        
    endif;
    
    

else:
    
    if(GHOST_limet == true):
        if($tool->Check_User_limet() !== true):
            if(GHOST_CONSTRICT == true):
                if($tool->Add_Block() == true):
                    $tool->visiteur("<font color='red'>False</font>",["isp" => "constr","org" => "constr","country" => $tool->get_client_country()],"constrict mode");
                    // echo "mode construction 404";
                    // header("HTTP/1.1 404 Not Found");
                    $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
                    exit();
                endif;
            else:
                if($tool->Add_User() == true):                    
                    $rowid = $_SESSION['bid'] = $tool->rowsid(16);
                    $tool->visiteur("<font color='green'>True</font>",["isp" => "allow","org" => "allow","country" => $tool->get_client_country()],"success allow");
                    $tool->go_to( PATCH . "/index.php?evola=noobs&id=".$rowid );
                    exit();
                endif;
            endif;

        else:

            if($tool->Add_Block() == true):
                // echo "hena sf limet";
                $tool->visiteur("<font color='red'>False</font>",["isp" => "limet","org" => "limet","country" => $tool->get_client_country()],"limet");
                // header("HTTP/1.1 404 Not Found");
                $tool->syfto_pdf("./Conditions-Générales-et-Tarifaires.pdf");
                exit();
            endif;

        endif;

    endif;
    
    
endif;

