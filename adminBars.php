<!-- html file for top bar and side bar in admin Panel  -->


<!-- top nav bar -->
<nav class="navbar navbar-default navbar-fixed-top" id="topNav" style="background: rgb(239, 250, 250 );">
    <div class="container-fluid">
        <div class="navbar-header">
        <a href="adminPanelProjects.php">
             <img src="logo.png" style="width:155px;height:33px;">
        </a> 
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li ><a ><label style="color: rgb(0,0,0);"><?php
        
                      $mail= $_SESSION['login_email'];
                      $query="select name from user where email='$mail'";
                      $result=mysqli_query($conn,$query)or die(mysqli_error($conn));
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_array()){ 
                                echo $row['name']."   ";              
                            }
                        }     

                ?></label></a></li>
            <li ><a href="logout.php" type="button" id="logout-button" class="btn btn-danger" style="color: rgb(300,300,300);"><span class="glyphicon glyphicon-log-out" ></span><b> LOGOUT</b> </a></li>    
        </ul>
    </div>
</nav>

    <!-- sidebar -->
    <nav class="main-menu" id="sideNav">
        <ul id="sections">
          <li>
            <a href="adminPanelProjects.php" id="a">
              <i class="fa fa-folder  fa-2x"></i> <span class="nav-text"><b> Project Expenses </b></span>
            </a> 
          </li>
          <li class="has-subnav">
            <a href="adminPanelEmployees.php" id="b">
              <i class="fa fa-group fa-2x"></i> <span class="nav-text"><b> Employee Expenses </b></span>
            </a>            
          </li> 
          <li class="has-subnav">
            <a href="adminPanelAssets.php" id="g">
              <i class="fa fa-suitcase fa-2x"></i> <span class="nav-text"><b> Assets </b></span>
            </a>            
          </li>
          <li class="has-subnav">
            <a href="adminPanelLeaveManagement.php" id="j">
              <i class="fa fa-glass fa-2x"></i> <span class="nav-text"><b> Leave Management </b></span>
            </a>            
          </li>
          <li class="has-subnav ">
          <div class="dropdown has-subnav">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle" style="color:rgb(0, 4, 4  );">
              <i class="fa fa-chevron-right fa-2x"> </i><span class="nav-text"><b >Master</b></span>
            </a>
            <ul class="dropdown-menu " style="background: rgb(239, 250, 250 );">
                <li class="has-subnav ">
                <a href="adminPanelUpdateProj.php" id="c">
                  <i class="fa fa-folder-o fa-2x"></i> <span class="nav-text"><b> Projects </b></span>
                </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelUpdateEmp.php" id="d">
                    <i class="fa fa-circle fa-2x"></i> <span class="nav-text"><b> Employees </b></span>
                  </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelCategories.php" id="e">
                    <i class="fa fa-files-o fa-2x"></i> <span class="nav-text"><b> Expense categories </b></span>
                  </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelUpdateInventory.php" id="h">
                    <i class="fa fa-suitcase fa-2x"></i> <span class="nav-text"><b> Inventory types </b></span>
                  </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelRentalCompanies.php" id="i">
                    <i class="fa fa-home fa-2x"></i> <span class="nav-text"><b> Rental Companies </b></span>
                  </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelRestrictedHolidays.php" id="j">
                    <i class="fa fa-calendar fa-2x"></i> <span class="nav-text"><b> Restricted Holidays </b></span>
                  </a>            
                </li>
                <li class="has-subnav ">
                  <a href="adminPanelAddUser.php" id="f">
                    <i class="fa fa-unlock-alt fa-2x"></i> <span class="nav-text"><b> Permissions </b></span>
                  </a>            
                </li>
            </ul>
            </div>
          </li>  
          
        </ul>    
    </nav>

    <script type="text/javascript">

    $(document).ready(function(){

      //for adjusting sidebar calulated height of topbar
      var calculateHeight = function () {
          $('#sideNav').css('top', $('#topNav').height() + 'px')
      }
      // init
      calculateHeight()
      // recalculate on window resize
      $(window).on('resize', calculateHeight)

      $("#logout-button").click(function(e){ //remove all items from local storage on logout
          localStorage.removeItem('filter-projects');
          localStorage.removeItem('filter-employees');
          localStorage.removeItem('sort');
          localStorage.removeItem('filter1-employees');
          localStorage.removeItem('filter2-employees');
          localStorage.removeItem('filter1-projects');
      });

    });
    </script>