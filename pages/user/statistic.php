<?php 
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/autoload.php");
    use Controllers\Page;
    use Controllers\User;
    use Controllers\Dbconnection;
    $db=new Dbconnection();
    if(isset($_SESSION['id']))
    $user=new User($_SESSION['id']);
    else $user=new User();
    $user->redirectUser(true,false,true);
    $page=new Page();
    $page->drawHead('Statistics',renderPath(__DIR__));
    require_once("{$_SERVER['DOCUMENT_ROOT']}/Maturski/nav.php");
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable(
          <?php $user->chartUser();?>
        );

        var options = {
         width:$("#chartContainer").css('width'),
          height:$("#chartContainer").css('height')
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartContainer'));

        chart.draw(data, options);
      }
      function chartSubcategory(){
          $.post('handlers/user/chart-category.php',{id:$("#category").val()},function(data,status){
            var d = google.visualization.arrayToDataTable(eval(data));

        var options = {
         width:$("#chartCategory").css('width'),
          height:$("#chartCategory").css('height')
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartCategory'));

        chart.draw(d, options);
          });
      }
    </script>
    <div class="container col-12">
        <div class="element-center row">
            <div class="col-12">
                <h3 class='text-center'>
                    Data by categories
                </h3>
            </div>
        </div>
        <div class='row'>
        <div class="col-6"><pre> </pre></div>
            <div class="col-6">
                <div class="form-group text-center">
                    <h3 class="text-center">Detailed stats for a category</h3>
                    <p class='text-center'>Select category<b class="text-danger">*</b></p>
                    <select class='form-control col-2 mx-auto' name="category" id="category" onchange='chartSubcategory()'>
                        <?php 
                        $all = $db->fetch('CALL getCategories()', true);
                        echo "<option value='NULL'></option>";
                        foreach ($all as $a) {
                            echo "<option value='" . $a['id'] . "'>" . $a['title'] . "</option>";
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="element-center row">
        <div class="col-6">
        <div id="chartContainer" class='col-12 chart-height' ></div></div>
            <div class="col-6">
                <div id="chartCategory" class='col-12 chart-height'></div>
            </div>
        </div>
    </div>
</body>

</html>