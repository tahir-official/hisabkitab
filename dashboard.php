<?php
   include_once('include/header.php');
   ?>
<div class="container-fluid page-body-wrapper">
<?php
   include_once('include/sidebar.php');
   ?>
<!-- partial -->
<div class="main-panel">
<div class="content-wrapper">
   <!-- Page Title Header Starts-->
   <?php
      if (isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }
      ?>
   <div class="row page-title-header">
      <div class="col-12">
         <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card">
                  <div class="card-body pb-0">
                     <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Total Bill Amount</h4>
                        <?php
                           $query_all_bill_amount = "SELECT sum(bill_amount) as total_bill_amount FROM bills where  store_id  = $store_id ";
                           $statement_all_bill_amount = $conn->query($query_all_bill_amount);
                           $statement_all_bill_amount_data= $statement_all_bill_amount->fetch_assoc();
                           
                           ?>
                     </div>
                     <h3 class="font-weight-medium mb-4"><?=CURRENCY.number_format((float)$statement_all_bill_amount_data['total_bill_amount'], 2, '.', '')?></h3>
                  </div>
                  <canvas class="mt-n4" height="90" id="total-revenue">
                  </canva>
               </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card" style="background: #5c6bc0; color:white">
                  <div class="card-body pb-0">
                     <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0" style="color: white;">Total Paid Amount</h4>
                     </div>
                     <h3 class="font-weight-medium"><?=CURRENCY?>147.7</h3>
                  </div>
                  <canvas class="mt-n3" height="90" id="total-transaction1">
                  </canva>
               </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
               <div class="card" style="background: #ff8a80; color:white">
                  <div class="card-body pb-0">
                     <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-0">Total Due Amount</h4>
                     </div>
                     <h3 class="font-weight-medium"><?=CURRENCY?>147.7</h3>
                  </div>
                  <canvas class="mt-n2" height="90" id="total-transaction2">
                  </canva>
               </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card">
                  <div class="p-4 border-bottom bg-light">
                    <h4 class="card-title mb-0">Mixed Chart</h4>
                  </div>
                  <div class="card-body">
                    <canvas id="mixed-chart" height="100"></canvas>
                    <div class="mr-5" id="mixed-chart-legend"></div>
                  </div>
                </div>
              </div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="row">
            
            <div class="col-md-6 grid-margin">
               <div class="card">
                  <div class="card-body">
                     <div class="row">
                        <div class="col-md-6">
                           <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              <a href="<?=MAIN_URL?>/broker_management.php">
                                 <p class="mb-0">Total Brokers</p>
                              </a>
                           </div>
                           <?php
                              $query_all_broker = "SELECT * FROM users where user_type = 'broker' and store_id  = $store_id ";
                              $statement_all_broker = $conn->query($query_all_broker);
                              $statement_all_count_broker= $statement_all_broker->num_rows;
                              ?>
                           <h4 class="font-weight-semibold"><?=$statement_all_count_broker?></h4>
                           <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="78"></div>
                           </div>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                           <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-success mr-2"></div>
                              <a href="<?=MAIN_URL?>/dealer_management.php">
                                 <p class="mb-0">Total Dealers</p>
                              </a>
                           </div>
                           <?php
                              $query_all_dealer = "SELECT * FROM users where user_type = 'dealer' and store_id  = $store_id ";
                              $statement_all_dealer = $conn->query($query_all_dealer);
                              $statement_all_count_dealer= $statement_all_dealer->num_rows;
                              ?>
                           <h4 class="font-weight-semibold"><?=$statement_all_count_dealer?></h4>
                           <div class="progress progress-md">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="45"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 stretch-card average-price-card">
               <div class="card text-white">
                  <div class="card-body">
                     <div class="d-flex justify-content-between pb-2 align-items-center">
                        <?php
                           $query_all_bill = "SELECT * FROM bills where  store_id  = $store_id ";
                           $statement_all_bill = $conn->query($query_all_bill);
                           $statement_all_count_bill= $statement_all_bill->num_rows;
                           ?>
                        <h2 class="font-weight-semibold mb-0"><?=$statement_all_count_bill?></h2>
                        <div class="icon-holder">
                           <i class="mdi mdi-briefcase-outline"></i>
                        </div>
                     </div>
                     <div class="d-flex justify-content-between">
                        <a href="<?=MAIN_URL?>/all_bills.php">
                           <h5 class="font-weight-semibold mb-0" style="color: white;">Total Bills</h5>
                        </a>
                        <p class="text-white mb-0">Since This month</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- content-wrapper ends -->
<?php
   include_once('include/footer.php');
   ?>

