<?php
if(!isset($_GET['id']) || $_GET['id'] == ""){
    die("SEARCH PARAMETER IS MISSING");
}
//if the student application number is defined
$std_app_num_ = base64_decode(base64_decode($_GET['id']));

$getStudent = DB_EBPORTAL::getInstance()->query("SELECT * FROM [dbo].[vw_biodata] WHERE [Appnum] LIKE '$std_app_num_'");
$count = 0;
if($getStudent->error() == false){
    //do_alert($getStudent->count());
    //do_alert($count);
    if($getStudent->count() !== 0){
        //get the students details
        while($getStudent->count() < $count){
            $json = [
                'std_fullname'  => $getStudent->results()[$count]->Surname.' '.$getStudent->results()[$count]->Firstname.' '.$getStudent->results()[$count]->Othername,
                'std_programme' => $getStudent->results()[$count]->program,
                'std_acadsess'  => $getStudent->results()[$count]->EntrySession,

                'std_ptacronym' => $getStudent->results()[$count]->PTAcronym,
                'std_pcacronym' => $getStudent->results()[$count]->PCAcronym,
                'std_ptname' => $getStudent->results()[$count]->PTName
            ];
            $count --;
        }
        //var_dump($json['std_fullname']);
        //die();
    }else{
        die("THIS STUDENT DATA DOES NOT EXISTS");
    }
}else{
    die("AN ERROR OCCURED WHILE FETCHING STUDENT DATA");
}
?>
<head>
    <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/jquery.watermark.min.js"></script>
    <style type="text/css">
        body{
            font-family: 'Rajdhani', sans-serif;

        }
        table, th, td {
            border: 1px solid #060;
        }
        #printDiv {
            background-image:url(assets/img/yblogo.jpg);

        }

        .bio_print{
            color:#006600;
            font-size: 12px;
            padding: 5px 5px;
        }
        blockquote.emph {
            padding: 10px 10px;
            margin: 0px 0px 0px;
            font-size: 17.5px;
            color:#006600;
            border-left:10px solid #006600;
            border-left-color: #006600;
        }
        #bg-text{
            text-align:center;
            position:absolute;
            margin-top:400px;
            margin-left:460px;
            z-index: 1000;
            color:#ffff00;
            font-size:100px;
            transform:rotate(330deg);
            -webkit-transform:rotate(330deg);
            opacity:0.3;
        }

    </style>
    <style type="text/css" media="print">
        @media print {
            #button{
                display:none;
            }
        }
    </style>
</head>
<body  oncontextmenu="return false" onkeydown="return false;" class="panel-body" id="printDiv">
<div class="vertical-align-wrap">
    <div class="vertical-align-middle">
        <div class="content" >
            <div>
             <div class="print"   style="">

                <div class="panel-body">
                    <table style="width:800px; border: 0px; margin-bottom:0px;" align="center" >
                        <tr>
                            <td align="center" style="border: 0px; padding-left:50px; padding-bottom:20px;">

                                    <img  src="assets/img/logo3.png" alt="Yaba_tech Logo">

                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="border: 0px; padding-left:50px; color:#060; font-size:20px;">
                               <strong>PROVISIONAL ADMISSION LETTER</strong>
                            </td>
                        </tr>
                        <tr style="">
                            <td align="center" style="border: 0px; padding:10px; background-color:#060;">
                                <b style="color:#fff;">P.M.B 2011 YABA, LAGOS, NIGERIA&ensp;|&ensp;E-mail: registry@yabatech.edu.ng</b>
                            </td>
                        </tr>
                    </table>
                    <table style="width:950px; border: 1px solid #060; margin-top:0px; color:#060" align="center" id="printDiv">
                        <p align="center" id="bg-text">YABA COLLEGE OF<br> TECHNOLOGY</p>
                        <tr>
                            <td>
                                <table style="width:900px; border: 0px; margin-bottom:30px;" align="center" >
                                    <tr>
                                        <td style="border: 0px;">
                                            <table style="border: 0px;">

                                                <tr>
                                                    <td style="border: 0px;">
                                                        <blockquote class="emph"><b>APPLICANT NUMBER</b></blockquote>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="border: 0px; font-size:20px; ">

                                                            <b style="color:#060; padding-left:40px;"><?php echo strtoupper($std_app_num_);?></b>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td align="right" style="border: 0px;">
                                            <?php
                                                $pass_link = 'nill';
                                                $get_picture = DBMSQL::getInstance()->query("SELECT * FROM [dbo].[onlineAppImages] WHERE [appnum] LIKE '$std_app_num_'");
                                                if($get_picture->count() !== 0){
                                                    $picture =  $get_picture->first()->imagename;
                                                    $pass_link = 'http://portal.yabatech.edu.ng/applications/applicantarea/passports/'.$picture;
                                                }else{
                                                    $pass_link = 'nill';
                                                }
                                            ?>
                                            <img class="display" src="<?php echo $pass_link; ?>" alt="<?php echo $std_app_num_; ?>" width="150px" height="150px" style="padding-top:10px;">
                                        </td>
                                    </tr>
                                </table>
                                <table style="width:900px; border: 0px solid #060; margin-top:50px; color:#060" align="center">
                                    <tr style="border: 0px;">
                                        <td align="left" style="border: 0px; padding-bottom:10px;">
                                            <b><?php echo $json['std_fullname']; ?></b>
                                        </td>
                                    </tr>
                                    <tr style="border: 0px;">
                                        <td align="center" style="border: 0px; padding-bottom:10px; font-size:22px;">
                                            <u><b><strong>PROVISIONAL ADMISSION FOR <?php echo $json['std_pcacronym'];?> <?php echo $json['std_ptname'];?> PROGRAMME <?php echo $json['std_acadsess'];?> ACADEMIC SESSION<strong></b></u>
                                        </td>
                                    </tr>
                                    <tr style="border: 0px;">
                                        <td align="left " style="border: 0px;">
                                            <ol style="font-size:17px;">
                                                <li style="border: 0px; padding-bottom:20px;">
                                                    I have the pleasure to inform you that you have been offered a provisional admission into <b><?php echo $json['std_pcacronym'];?> <?php echo $json['std_ptname'];?></b> programme
                                                    in <b><?php echo $json['std_programme'];?></b> for the <b><?php echo $json['std_acadsess'];?></b> Academic Session
                                                </li>

                                                <li style="border: 0px; padding-bottom:20px;">
                                                    Please note that the offer is contigent upon the college management beign satisfied that:
                                                    <ul>
                                                        <li>
                                                            Your academic qualifications meet the advertised requirement for the programme.
                                                        </li>
                                                        <li>
                                                            Your disciplinary record is not negative
                                                        </li>
                                                        <li>
                                                            Full payment of the fees for your proposed programme is to be paid within the stipulated registration period
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li style="border: 0px; padding-bottom:20px;">
                                                    Kindly note that if at any time it is discovered that you provided false information, used forged documents or did not meet any of the conditions stipulated above, the
                                                    provisional admission will be withdrawn and you will be expelled from the College immmediately.
                                                </li>

                                                <li style="border: 0px; padding-bottom:20px;">
                                                    This offer will elapse if you do not register within the stipulated registration period. You are therefore required to report at the Admission Department of the Registry for futher
                                                    information and registration at the stipulated time.
                                                </li>

                                                <li style="border: 0px; padding-bottom:20px;">
                                                    You are required to bring along the following,
                                                    <ul>
                                                        <li>
                                                            Letter of Admission.
                                                        </li>
                                                        <li>
                                                            Original and photocopies of credentials.
                                                        </li>
                                                        <li>
                                                            Two (2) reference letters, one from last institution attended and the other from a Clergy, Imam, Senior Civil Servant or a Lawyer.
                                                        </li>
                                                        <li>
                                                            Testimonial from principal of the last Secondary School attended (Original and Photocopy)
                                                        </li>
                                                        <li>
                                                            10 copies of recent passport photograph of the candidate (Red backgroung).
                                                        </li>
                                                        <li>
                                                            Postcard size photograph of parents or guardian of the candidate.
                                                        </li>
                                                        <li>
                                                            Birth certificate/sworn declaration of age (Original and Photocopy).
                                                        </li>
                                                        <li>
                                                            Acceptance letter (Two(2) copy).
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li style="border: 0px; padding-bottom:20px;">
                                                    Failure to produce these documents will nulify the offer of admission.
                                                </li>

                                            </ol>
                                        </td>
                                    </tr>
                                    <tr style="border: 0px;">
                                        <td style="border: 0px; padding-bottom:10px;">

                                            <h3>Congratulation!</h3>

                                            <span id="qr" style="float:right;">
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 0px; padding-top:30px;">
                                        <img src="<?php echo BASE_URL;?>assets/img/signatures/registra/momodu.png"  width="20%" alt="Registrar's Signature">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 0px; padding:0px;">
                                            _____________________________
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 0px;">
                                            <b>DR. SIKIRU MOMODU</b><br>
                                            <b>REGISTRAR</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 0px;" class="col-md-4">
                                            <span><small>DEVELOPED BY: CENTER FOR INFORMATION AND TECHNOLOGY MANAGEMENT, (CITM) YABA COLLEGE OF TECHNOLOGY</small></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="border: 0px;" class="col-md-4">
                                            <span><small>DATE PRINTED : <?php echo date('Y-m-d / H:i:s'); ?></small></span><!---LOCAL MACHINE-->
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>
                    </table>


                    <table id="button" style="width:800px; border: 0px; margin-top:20px; color:#060;" align="center">
                        <tr>
                            <td align="center" style="border: 0px;" class="col-md-4">

                            </td>
                            <td align="center"style="border: 0px;" class="col-md-4">
                                <button class="btn btn-default btn-block" id="print" onclick="window.print(this)">PRINT</button>
                                <button class="btn btn-default btn-block"  onclick="window.history.back()">GO BACK TO PORTAL</button>
                            </td>
                            <td align="right" style="border: 0px;" class="col-md-4">

                            </td>
                        </tr>
                    </table>


                </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
$list = "";
$list .="http://portal.yabatech.edu.ng/portalplusapplicants/?pg=verify&id=".base64_encode(base64_encode($std_app_num_));
$data = json_encode($list);
?>
<script>
    generate_qr(<?php echo $data;?>);

    function generate_qr(string){
        jQuery(function(){
            jQuery('#qr').qrcode({width: 120,height: 120,text: string});
        });
    }

    generate_watermark();

    function generate_watermark(){
        $('.display').watermark({
            path: 'assets/img/log.png',
            margin: 0,
            gravity: 'se',
            opacity: 0.3,
            outputWidth: 400
        });
    }
</script>
