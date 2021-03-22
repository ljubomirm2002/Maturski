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
          <?php echo $user->chartUser();?>
        );

        var options = {
         width:$("#chartContainer").css('width'),
          height:$("#chartContainer").css('height')
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartContainer'));

        chart.draw(data, options);
      }
      function chartUser(){
          $.post('handlers/user/chart-user.php',{id:$("#user").val()},function(data,status){
            var d = google.visualization.arrayToDataTable(eval(data));

        var options = {
         width:$("#chartUser").css('width'),
          height:$("#chartUser").css('height')
        };

        var chart = new google.visualization.PieChart(document.getElementById('chartUser'));

        chart.draw(d, options);
          });
      }
    </script>
    <div class="container col-12 allow-overflow">
        <div class="element-center row">
            <div class="col-12">
                <h3 class='text-center'>
                    Compare yourself with another user
                </h3>
            </div>
        </div>
        <div class="element-center row">
            <div class="col-6"><pre></pre></div>
            <div class="col-6">
                <div class="form-group text-center">
                    <p class='text-center'>Select user<b class="text-danger">*</b></p>
                    <select class='form-control col-2 mx-auto' name="user" id="user" onchange='chartUser()'>
                        <?php $all = $db->fetch('CALL getUsers()', true);
                        echo "<option value='NULL'></option>";
                        foreach ($all as $a) {
                            if($_SESSION['id']!=$a['id'] && $a['role_id']!=1)
                            echo "<option value='" . $a['id'] . "'>" . $a['name'] . "</option>";
                        } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="element-center row">
            <div class="col-6"> <div id="chartContainer" class='col-12 chart-height' ></div></div>
            <div class="col-6">
                <div id="chartUser" class='col-12 chart-height'></div>
            </div>
        </div>
    </div>
</body>

</html>