<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Compress</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>

    <style type="text/css">
        .item {
            height: 250px;
            width: 100%;
            border: 1px solid #ccc;
            align-items: center;
            display: flex;
        }
        .item img {
            width:100%;
            height:auto;
        }
        .item-info {
            margin-top:10px;
            margin-bottom:30px;
            padding:5px;
            border-bottom: 1px solid #ccc;
        }
        .item-info span {
            font-size:14px;
            font-weight:600;
        }
    </style>

</head>

<body>


    <?php 
include './classes/compressor.php';
use \COMPRESSOR\Compressor;
$Compressor = Compressor::instance();
if(isset($_POST['submit'])){ 
    

    //  uploading files
    $respponse =  $Compressor->upload_image( $_FILES, $_POST['quality'] ); 

    echo $respponse;

}
?>
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-center">::Image Compress::</h2>
                </div>
                <div class="col-sm-6 col-sm-offset-3">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="image">Optimize Quality</label>
                            <select name="quality" id="quality" class="form-control">
                                <option value="">Please Select...</option>
                                <option value="90">90</option>
                                <option value="80">80</option>
                                <option value="70">70</option>
                                <option selected value="60">60</option>
                                <option value="50">50</option>
                                <option value="40">40</option>
                                <option value="30">30</option>
                                <option value="20">20</option>
                            </select>
                        </div>

                        <button type="submit" value="Compress Now" name="submit" class="btn btn-primary">Compress
                            Now</button>

                    </form>
                </div>
            </div>

            <div class="row" style="margin-top:50px;">
                <div class="col-sm-12 text-center">
                    <h4>Compress Images</h4>
                </div>

                
                    <?php 
                        $baseurl = $Compressor->base_url();
                        $images = glob("uploads/images/*.*");

                        if( !empty( $images ) ){
                            foreach( $images as $image ) {
                                    $path = $baseurl . $image;
                                ?>
                                <div class="col-sm-3">
                                    <div class="item">
                                        <img src="<?php echo $path; ?>" alt="image" />
                                    </div>
                                    <div class="item-info">
                                        <span>Size : </span> <span><?php echo $Compressor->formatSizeUnits($path); ?></span>
                                    </div>
                                </div>
                           <?php }
                        }
                    ?>
               

            </div>

        </div>
    </div>



</body>

</html>