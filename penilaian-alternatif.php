<?php

include_once './includes/api.php';
include_once 'header1.php';
include_once './includes/session.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb" style="background: transparent; padding:0px;">
                <li><a href="main.php" style="color: #333;">Beranda</a></li>
                <li class="text-success" style="font-weight: bold;">Penilaian Alternatif</li>
            </ol>
        </div>
        <div class="col-md-6 text-left">
            <h5>Penilaian Alternatif</h5>
        </div>
            <div class="container">
        <div class="row">
        <div class="col-md-12">
            <form method="post" action="process_evaluation.php">
                <div class="form-group">
                    <label for="criteria">Alternatif:</label>
                    <input type="text" class="form-control" id="criteria" name="criteria">
                </div>
                <div class="form-group">
   
                <select class="form-control" id="score" name="score">
                    
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>

                </div>


                <button type="submit" class="btn btn-danger">Submit</button>
                <button type="button" onclick="location.href='alternatif.php'" class="btn btn-danger">Kembali</button>
            </form>
        </div>
    </div>
</div>

<?php include_once 'footer.php'; ?>
        </div>
    </div>
</div>


<?php include_once 'footer.php'; ?>